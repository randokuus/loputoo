<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'C:/xampp7/htdocs/loputoo/db.php';
include_once 'C:/xampp7/htdocs/loputoo/mobile_menu.php';
include_once 'C:/xampp7/htdocs/loputoo/tournament_header_settings.php';

if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$id = (int)$_GET['id'];
$result = $mysql->query('SELECT * FROM tournaments AS t 
                LEFT JOIN sports as s ON t.sport_id = s.id
                LEFT JOIN countries as c ON t.country_id = c.country_id
                LEFT JOIN ages as a ON t.age_id = a.id
                LEFT JOIN class as cl ON t.class_id = cl.id
                LEFT JOIN level as l ON t.level_id = l.id
                LEFT JOIN gender as g ON t.gender_id = g.id
                LEFT JOIN tournament_settings as ts ON t.id = ts.tournament_id
                WHERE t.Id = "' . $id . '";');

while ($row = $result->fetch_assoc()){
if($user->is_logged_in() && $row['user_id'] == $userId ) {
?>
<div class="col-sm-12" style="background-color: white;">
    <div class="col-sm-3">
        <?php include_once 'sideMenu.php'?>
    </div>
    <div class="col-sm-9">
        <h2>Design</h2>
        <hr>
        <?php
            if ($row['tournament_id'] == $id) {
                if (isset($_POST['submit']) && !empty($_FILES['tournament_banner']['name'])) {
                    ?>
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <strong>Success!</strong> Information has updated.
                        </div>
                    </div>
                    <?php
                    $background = mysqli_real_escape_string($mysql, $_POST['background_color']);
                    if (isset($_POST['sponsor_enabled'])){
                        $sponsors = "1";
                    }else {
                        $sponsors = "0";
                    }
                    if (isset($_POST['reg_open'])){
                        $registration = "1";
                    }else {
                        $registration = "0";
                    }
                    $image = ($_FILES['tournament_banner']['name']);
                    if (!empty($_FILES['tournament_banner'])) {
                        include_once 'tournament_banner_images.php';
                    }
                    $query = "UPDATE tournament_settings SET background_color = '$background', banner_path = '$image', sponsors_enabled = '$sponsors', reg_open = '$registration' WHERE tournament_id = '$id'";
                    $_POST = array();
                    if (!$mysql->query($query)) {
                        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                } else if (isset($_POST['submit'])){
                    ?>
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <strong>Success!</strong> Information has updated.
                        </div>
                    </div>
                    <?php
                    $background = mysqli_real_escape_string($mysql, $_POST['background_color']);
                    if (isset($_POST['sponsor_enabled'])){
                        $sponsors = "1";
                    }else {
                        $sponsors = "0";
                    }
                    if (isset($_POST['reg_open'])){
                        $registration = "1";
                    }else {
                        $registration = "0";
                    }
                    $query = "UPDATE tournament_settings SET background_color = '$background', sponsors_enabled = '$sponsors', reg_open = '$registration' WHERE tournament_id = '$id'";
                    $_POST = array();
                    if (!$mysql->query($query)) {
                        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                } ?>
                <div class="col-sm-6">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Choose backgorund color</label>
                                <input type="color" name="background_color" id="background_color"
                                       value="<?php echo $row['background_color']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Tournament banner *(min-width:1140px) </label>
                                <input type="file" name="tournament_banner" id="tournament_banner"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sponsors enabled </label>
                                <?php if($row['sponsors_enabled'] == 1) { ?>
                                    <input checked type="checkbox" id ="sponsor_enabled" name="sponsor_enabled" value="1"/>
                                <?php } else {?>
                                    <input type="checkbox" id ="sponsor_enabled" name="sponsor_enabled" value="0"/>
                               <?php }?>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Registration open </label>
                                <?php if($row['reg_open'] == 1) { ?>
                                    <input checked type="checkbox" id ="reg_open" name="reg_open" value="1"/>
                                <?php } else {?>
                                    <input type="checkbox" id ="reg_open" name="reg_open" value="0"/>
                                <?php }?>
                            </div>
                        </div>
                        <button type="submit" id="submit" name="submit" value="Confirm"
                                class="btn btn-primary form-submit" style="margin-bottom:10px;">Confirm
                        </button>
                    </form>
                </div>
            <?php } else {

                if (isset($_POST['submit'])) {
                    ?>
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <strong>Success!</strong> Information has updated.
                        </div>
                    </div>
                    <?php
                    $background = mysqli_real_escape_string($mysql, $_POST['background_color']);
                    $tournamentId = $id;
                    if (isset($_POST['sponsor_enabled'])){
                        $sponsors = "1";
                    }else {
                        $sponsors = "0";
                    }
                    if (isset($_POST['reg_open'])){
                        $registration = "1";
                    }else {
                        $registration = "0";
                    }
                    $image = ($_FILES['tournament_banner']['name']);
                    if (!empty($_FILES['tournament_banner'])) {
                        include_once 'tournament_banner_images.php';
                    }
                    $query = "INSERT INTO tournament_settings (background_color, banner_path, reg_open, sponsors_enabled, tournament_id)
                VALUES
                ('{$background}','{$image}','{$registration}','{$sponsors}','$tournamentId');";
                    $_POST = array();
                    if (!$mysql->query($query)) {
                        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                }
        ?>
        <div class="col-sm-6">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Choose backgorund color</label>
                        <input type="color" name="background_color" id="background_color" value="#ffffff"/>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Tournament banner *(min-width:1140px) </label>
                        <input type="file" name="tournament_banner" id="tournament_banner" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Sponsors allowed </label>
                        <input type="checkbox" id ="sponsor_enabled" name="sponsor_enabled" value="1"/>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Registration open </label>
                        <input type="checkbox" id ="reg_open" name="reg_open" value="1"/>
                    </div>
                </div>
                <button type="submit" id="submit" name="submit" value="Confirm" class="btn btn-primary form-submit" style="margin-bottom:10px;">Confirm</button>
            </form>
        </div>
        <?php } ?>
    </div>
</div>
<?php } else {} }?>
<div class="container">
</div>
<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>

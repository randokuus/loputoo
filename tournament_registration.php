<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
$id = (int)$_GET['id'];
include_once 'db.php';
include_once 'mobile_menu.php';
include_once 'tournament_header.php';

if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$sql = $mysql->query('SELECT user_id FROM tournaments WHERE id = "'.$id.'"');
while ($row = $sql->fetch_assoc()){
    $tournamentUser = $row['user_id'];
}
$result = $mysql->query("SELECT DISTINCT * FROM tournament_settings WHERE tournament_id = '".$id."';");

?>
<?php
if (isset($_POST['submit'])){
    if($user->is_logged_in()) {
    ?>
    <div class="alert alert-success col-sm-12">
        <strong>Success!</strong> Info has sent to email.
    </div>
    <?php } else {?>
        <div class="alert alert-success col-sm-12">
            <strong>Success!</strong> Team has registred.
        </div>
    <?php }
    $teamName = mysqli_real_escape_string($mysql, $_POST['team_name']);
    $countryId = mysqli_real_escape_string($mysql, $_POST['country_id']);
    $contactPerson = mysqli_real_escape_string($mysql, $_POST['contact_person']);
    $contactNumber = mysqli_real_escape_string($mysql, $_POST['contact_number']);
    $contactEmail = mysqli_real_escape_string($mysql, $_POST['contact_email']);
    $image=($_FILES['team_logo']['name']);
    if (!empty($_FILES['team_logo'])) {
        include_once 'team_logos.php';
    }
    $query = "INSERT INTO teams_tournament(team_name, contact_name, contact_email, contact_phone, country_id, logo_url, manager_id)
                VALUES
                ('{$teamName}','{$contactPerson}','{$contactEmail}','{$contactNumber}','{$countryId}','{$image}', '{$userId}');";
    $_POST = array();
    if(!$mysql->query($query)){
        echo'Sisestus ebaõnnestus - ' . $mysql->error;
    }
}
?>
<div class="container" style="background-color: white;" >
    <div class="col-md-9 col-sm-12 col-xs-12" >
        <div class="col-sm-12">
            <h2>Registration</h2>
        </div>
        <?php
        while ($row = $result->fetch_assoc()){?>
           <?php
         if($row['reg_open'] == 1 || $user->is_logged_in() && $tournamentUser == $userId) {?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Team name *</label>
                    <input required type="text" id ="team_name" name="team_name" class="form-control" value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <label>Country *</label>
                <select class="form-control" name="country_id">
                    <option>-Select-</option>
                    <?php

                    $sql = mysqli_query($mysql, "SELECT DISTINCT country_name, country_id FROM countries");

                    while ($row = $sql->fetch_assoc()){

                        ?>
                        <option id="country_id" name='country_id' value=<?php echo $row['country_id']; ?>><?php echo $row['country_name']; ?></option>

                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Contact person *</label>
                    <input required type="text" id ="contact_person" name="contact_person" class="form-control" value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Contact phone number</label>
                    <input required type="text" id ="contact_number" name="contact_number" class="form-control" value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Contact email *</label>
                    <input required type="text" id ="contact_email" name="contact_email" class="form-control" value=""/>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Team logo</label>
                    <input type="file" name="team_logo" id="team_logo" class="form-control" />
                </div>
            </div>
            <button type="submit" id="submit" name="submit" value="Confirm registration" class="btn btn-primary form-submit" style="margin-bottom:10px;">Confirm registration</button>
        </form>
        <?php } else { ?>
            <h4>Sorry, registration is closed!</h4>
        <?php } }?>
    </div>
    <?php
    $result = $mysql->query("SELECT DISTINCT * FROM tournament_settings WHERE tournament_id = '".$id."';");
    while ($row = $result->fetch_assoc()){
        if($row['sponsors_enabled'] == 1) {
            ?>
    <div class="col-md-3 col-sm-12 col-xs-12" style="text-align: center">
        <h4><div style="text-align: center">Supporters</div></h4>
        <hr>
        <a href="http://www.turniir.ee" target="_blank"><img src="images/logos/turniir_new_0.png" style="max-width:180px; max-height:180px;" /></a>
        <?php
        $sql = $mysql->query('SELECT * FROM sponsors WHERE tournament_id = "'.$id.'"');
        ?>
        <?php while ($row = $sql->fetch_assoc()){ ?>
            <a href="<?php echo $row['sponsor_site_url'] ?>" target="_blank"><img src="images/sponsorImages/<?php echo $row['sponsor_logo_url']?>" style="max-width:180px; max-height:180px; margin-top:25px;" /></a>
        <?php } ?>
    </div>
    <?php } else {} } ?>
</div>
</body>
<?php include_once 'footer.php'; ?>

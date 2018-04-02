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


$id = (int)$_GET['id'];

if (isset($_GET['updateSponsor'])) {

    if (!empty($_GET['image'])) {
        include_once 'C:/xampp7/htdocs/loputoo/sponsor_images.php';
        $query = "UPDATE sponsors SET sponsor_name = '". $_GET['sponsorName']."', sponsor_site_url = '". $_GET['sponsorSite']."', sponsor_logo_url = '". $_GET['image']."' WHERE sponsor_id = '". $_GET['sponsorId']."'";
    } else {
        $query = "UPDATE sponsors SET sponsor_name = '". $_GET['sponsorName']."', sponsor_site_url = '". $_GET['sponsorSite']."' WHERE sponsor_id = '". $_GET['sponsorId']."'";
    }
    $_POST = array();
    if (!$mysql->query($query)) {
        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
    }
    exit();
}

if (isset($_GET['deleteSponsor'])) {
    $query = "DELETE FROM sponsors WHERE sponsor_id = '". $_GET['sponsorId']."'";

    $mysql->query($query);
    exit();
}

if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$result = $mysql->query('SELECT DISTINCT user_id FROM tournaments
                          WHERE id = "' . $id . '";');
while ($row = $result->fetch_assoc()){
    if($user->is_logged_in() && $row['user_id'] == $userId ) {
?>
    <div class="col-sm-12 col-xs-12" style="background-color: white;">
        <div class="col-sm-3">
            <?php include_once 'sideMenu.php'?>
        </div>
        <div class="col-sm-9">
            <h2>Sponsors</h2>
            <hr>
            <div class=" col-md-6 col-sm-12 col-xs-12">
                <h3>Change or add information for your sponsor(s)</h3>
                <hr>
                <?php $sql = $mysql->query('SELECT * FROM sponsors
                WHERE tournament_id = "' . $id . '";'); ?>
                <?php while ($row = $sql->fetch_assoc()){
                    ?>
                    <div id="sponsors">
                        <div class="col-sm-7">
                            <label>Change sponsor name</label> <br />
                            <input required type="text" id="sponsor_name_<?php echo $row['sponsor_id']; ?>" name="sponsor_name" class="form-control"value="<?php echo $row['sponsor_name']; ?>"/> <br />
                            <label>Change sponsor site</label> <br />
                            <input required type="text" id="sponsor_site_<?php echo $row['sponsor_id']; ?>" name="sponsor_site" class="form-control" value="<?php echo $row['sponsor_site_url']; ?>"/><br/>
                        </div>
                        <div class="col-sm-5">
                            <?php
                            $logo = 'c:/xampp7/htdocs/loputoo/images/sponsorImages/'. $row['sponsor_logo_url'];
                            if ($row['sponsor_logo_url'] != '' && file_exists($logo)) {?>
                                <img class="img-responsive center-block max-height" style="max-width:150px; max-height:150px; margin-top: 10px; margin-bottom: 10px;" src="http://localhost:8080/loputoo/images/sponsorImages/<?php echo $row['sponsor_logo_url']; ?>">
                            <?php }
                            else { ?> <p>No pictures available</p>
                            <?php } ?>
                            <div class="form-group">
                                <label>Change sponsor image</label>
                                <input type="file" name="sponsor_logo" id="sponsor_logo_<?php echo $row['sponsor_id']; ?>" class="form-control" value="<?php echo $row['sponsor_logo_url']; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-top:10px; margin-bottom:10px;">
                            <button class="btn btn-primary" onclick="updateSponsor(<?php echo $row['sponsor_id'];?>)" style="margin-right:10px;">Confirm</button><button id="deleteSponsor" onclick="deleteSponsor(<?php echo $row['sponsor_id'];?>)"  class="btn btn-danger"><span style="margin-right:3px;" class="glyphicon glyphicon-trash"></span>Delete</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <?php
                if (isset($_POST['submit'])){
                    ?>
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <strong>Success!</strong> Sponsor was added.
                        </div>
                    </div>
                    <?php
                    $sponsorName = mysqli_real_escape_string($mysql, $_POST['sponsor_name']);
                    $sponsorSite= mysqli_real_escape_string($mysql, $_POST['sponsor_site']);
                    $tournamentId = $id;
                    $image=($_FILES['sponsor_logo']['name']);
                    if (!empty($_FILES['sponsor_logo'])) {
                        include_once 'C:/xampp7/htdocs/loputoo/sponsor_images.php';
                    }
                    $query = "INSERT INTO sponsors (sponsor_name, sponsor_site_url, sponsor_logo_url, tournament_id)
                VALUES
                ('{$sponsorName}','{$sponsorSite}','{$image}','$tournamentId');";
                    $_POST = array();
                    if(!$mysql->query($query)){
                        echo'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <div class="row">
                    <h3>Add new</h3>
                    <hr>
                    <form id="addSponsor" method="post" action="" enctype="multipart/form-data">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sponsor name *</label>
                                <input required type="text" id ="sponsor_name" name="sponsor_name" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sponsor site *</label>
                                <input required type="text" id ="sponsor_site" name="sponsor_site" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sponsor logo</label>
                                <input required type="file" name="sponsor_logo" id="sponsor_logo" class="form-control" />
                            </div>
                        </div>
                        <button type="submit" name="submit" value="Confirm" class="btn btn-primary form-submit" style="margin-bottom:10px;">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } else {} }?>
    <div class="container">
    </div>
    <script>
        function updateSponsor (id){
            var sponsorName = document.getElementById('sponsor_name_' + id).value;
            var sponsorSite = document.getElementById('sponsor_site_' + id).value;
            var fullPath = document.getElementById ('sponsor_logo_' + id).value;
            var image = fullPath.replace(/^.*[\\\/]/, '');
            var url = '&sponsorId='+ id +'&sponsorName=' + sponsorName + '&sponsorSite=' + sponsorSite + '&image=' + image;
            $.ajax({
                type: "POST",
                url: 'http://localhost:8080/loputoo/tournament_settings/sponsors.php?updateSponsor=1' + url
            });
            location.href=location.href
        }
        function deleteSponsor (id){
            var url = '&sponsorId=' + id;
            $.ajax({
                type: "POST",
                url: 'http://localhost:8080/loputoo/tournament_settings/sponsors.php?deleteSponsor=1' + url
            });
            location.href=location.href

        }
    </script>

<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>
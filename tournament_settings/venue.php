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

if (isset($_GET['updateVenue'])) {
    if (!empty($_GET['image'])) {
        $query = "UPDATE venue SET venue_name = '" . $_GET['venueName'] . "', venue_description = '" . $_GET['venueDescr'] . "', venue_address = '" . $_GET['venueAddress'] . "', venue_image_url = '" . $_GET['image'] . "' WHERE id = '" . $_GET['venueId'] . "'";

    } else {
        $query = "UPDATE venue SET venue_name = '" . $_GET['venueName'] . "', venue_description = '" . $_GET['venueDescr'] . "', venue_address = '" . $_GET['venueAddress'] . "' WHERE id = '" . $_GET['venueId'] . "'";

    }
    $_POST = array();
    if (!$mysql->query($query)) {
        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
    }
    exit();
}

if (isset($_GET['deleteVenue'])) {
    $query = "DELETE FROM venue WHERE id = '". $_GET['venueId']."'";

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
            <h2>Venues</h2>
            <hr>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <h3>Change or add information for your venue(s)</h3>
                <hr>
                <?php $sql = $mysql->query('SELECT * FROM venue
                WHERE tournament_id = "' . $id . '";'); ?>
                <?php while ($row = $sql->fetch_assoc()){
                    ?>
                    <div class="col-sm-7">
                        <label>Change venue name</label> <br />
                        <input required type="text" id="venue_name_<?php echo $row['id']; ?>" name="venue_name" class="form-control"value="<?php echo $row['venue_name']; ?>"/> <br />
                        <label>Change venue description</label> <br />
                        <textarea class="ckeditor" required id="venue_descr_<?php echo $row['id']; ?>" name="venue_description" class="form-control"><?php echo $row['venue_description']; ?></textarea><br/>
                        <label>Change venue address</label> <br />
                        <input required type="text" id="venue_address_<?php echo $row['id']; ?>" name="venue_address" class="form-control" value="<?php echo $row['venue_address']; ?>"/>
                    </div>
                    <div class="col-sm-5">
                        <?php
                        $logo = 'c:/xampp7/htdocs/loputoo/images/venues/'. $row['venue_image_url'];
                        if ($row['venue_image_url'] != '' && file_exists($logo)) {?>
                            <img class="img-responsive center-block max-height" style="width:350px; height:200px; margin-top: 10px; margin-bottom: 10px;" src="http://localhost:8080/loputoo/images/venues/<?php echo $row['venue_image_url']; ?>">
                        <?php }
                        else { ?> <p>No pictures available</p>
                        <?php } ?>
                        <div class="form-group">
                            <label>Change venue image</label>
                            <input type="file" id="venue_image_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['venue_image_url']; ?>" />
                        </div>
                    </div>
                    <div class="col-sm-12" style="margin-top:10px; margin-bottom:10px;">
                        <button class="btn btn-primary" onclick="updateVenue(<?php echo $row['id'];?>)" style="margin-right:10px;">Confirm</button><button onclick="deleteVenue(<?php echo $row['id'];?>)"  class="btn btn-danger"><span style="margin-right:3px;" class="glyphicon glyphicon-trash"></span>Delete</button>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <?php
                if (!empty($_FILES['venue_image_url'])) {
                    include_once 'C:\xampp7\htdocs\loputoo\venue_images.php';
                }
                if (isset($_POST['submit4'])){
                    $venueName = mysqli_real_escape_string($mysql, $_POST['venue_name']);
                    $venueDescription = mysqli_real_escape_string($mysql, $_POST['venue_description']);
                    $venueAddress = mysqli_real_escape_string($mysql, $_POST['venue_address']);
                    $image=($_FILES['venue_image_url']['name']);
                    $tournamentId = $id;
                    $query = "INSERT INTO venue (venue_name, venue_address, venue_image_url, venue_description, tournament_id)
                VALUES
                ('{$venueName}','{$venueAddress}','{$image}','{$venueDescription}','{$tournamentId}');";
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
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Venue name</label>
                            <input required type="text" id ="venue_name" name="venue_name" class="form-control" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Venue description</label> <br/>
                            <textarea class="ckeditor" name="venue_description" id="venue_description" class="form-control"></textarea><br/>
                        </div>
                        <div class="form-group">
                            <label>Venue address</label>
                            <input required type="text" id ="venue_address" name="venue_address" class="form-control" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Venue image</label>
                            <input type="file" name="venue_image_url" id="venue_image_url" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="submit4">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } else {} }?>
    <div class="container">
    </div>
    <script>
        function updateVenue (id){
            var venueName = document.getElementById('venue_name_' + id).value;
            var venueDescr = document.getElementById('venue_descr_' + id).value;
            var venueAddress = document.getElementById('venue_address_' + id).value;
            var fullPath = document.getElementById ('venue_image_' + id).value;
            var image = fullPath.replace(/^.*[\\\/]/, '');
            var url = '&venueId='+ id +'&venueName=' + venueName + '&venueDescr=' + venueDescr + '&venueAddress=' + venueAddress + '&image=' + image;
            $.ajax({
                type: "POST",
                url: 'http://localhost:8080/loputoo/tournament_settings/venue.php?updateVenue=1' + url
            });
            
        }
        function deleteVenue (id){
            var url = '&venueId=' + id;
            $.ajax({
                type: "POST",
                url: 'http://localhost:8080/loputoo/tournament_settings/venue.php?deleteVenue=1' + url
            });
            location.href=location.href
        }
    </script>

<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>
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

if (isset($_GET['updateLeisure'])) {

    if (!empty($_GET['leisure_image_url'])) {
        include_once 'C:/xampp7 /htdocs/loputoo/leisure_images.php';
        $query = "UPDATE leisure SET leisure_name = '". $_GET['leisureName']."', leisure_description = '". $_GET['leisureDescr']."', leisure_address = '". $_GET['leisureAddress']."', leisure_image_url = '". $_GET['leisure_image_url']."' WHERE id = '". $_GET['leisureId']."'";
    } else {
        $query = "UPDATE leisure SET leisure_name = '". $_GET['leisureName']."', leisure_description = '". $_GET['leisureDescr']."', leisure_address = '". $_GET['leisureAddress']."' WHERE id = '". $_GET['leisureId']."'";
    }

    $_POST = array();
    if (!$mysql->query($query)) {
        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
    }
    exit();
}

if (isset($_GET['deleteLeisure'])) {
    $query = "DELETE FROM leisure WHERE id = '". $_GET['leisureId']."'";

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
            <h2>Leisure</h2>
            <hr>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <h3>Change or add information for your leisure(s)</h3>
                <hr>
                <?php
                $sql = $mysql->query('SELECT * FROM leisure
                WHERE tournament_id = "' . $id . '";');
            ?>
            <?php while ($row = $sql->fetch_assoc()){
                ?>
                    <div class="col-sm-7 col-xs-12">
                        <label>Change leisure name</label> <br />
                        <input required type="text" id="leisure_name_<?php echo $row['id']; ?>" name="leisure_name" class="form-control"value="<?php echo $row['leisure_name']; ?>"/> <br />
                        <label>Change leisure description</label> <br />
                        <textarea class="ckeditor" required id="leisure_descr_<?php echo $row['id']; ?>" name="leisure_description" class="form-control"><?php echo $row['leisure_description']; ?></textarea><br/>
                        <label>Change leisure address</label> <br />
                        <input required type="text" id="leisure_address_<?php echo $row['id']; ?>" name="leisure_address" class="form-control" value="<?php echo $row['leisure_address']; ?>"/>
                    </div>
                    <div class="col-sm-5 col-xs-12">
                        <?php
                        $logo = 'c:/xampp7/htdocs/loputoo/images/leisure/'. $row['leisure_image_url'];
                        if ($row['leisure_image_url'] != '' && file_exists($logo)) {?>
                            <img class="img-responsive center-block max-height" style="width:350px; height:200px; margin-top: 10px; margin-bottom: 10px;" src="http://localhost:8080/loputoo/images/leisure/<?php echo $row['leisure_image_url']; ?>">
                        <?php }
                        else { ?> <p>No pictures available</p>
                        <?php } ?>
                        <div class="form-group">
                            <label>Change leisure image</label>
                            <?php echo $row['leisure_image_url']; ?>
                            <input type="file" name="leisure_image_url" id="leisure_image_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['leisure_image_url']; ?>" />
                        </div>
                    </div>
                    <div class="col-sm-12" style="margin-top:10px; margin-bottom:10px;">
                        <button class="btn btn-primary" onclick="updateLeisure(<?php echo $row['id'];?>)" style="margin-right:10px;">Confirm</button><button onclick="deleteLeisure(<?php echo $row['id'];?>)"  class="btn btn-danger"><span style="margin-right:3px;" class="glyphicon glyphicon-trash"></span>Delete</button>
                    </div>
            <?php } ?>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <?php
                if (!empty($_FILES['leisure_image_url'])) {
                    include_once 'C:/xampp7 /htdocs/loputoo/leisure_images.php';
                }
                if (isset($_POST['submit'])&& !empty($_POST['leisure_name'])){
                    $leisureName = mysqli_real_escape_string($mysql, $_POST['leisure_name']);
                    $leisureDescription = mysqli_real_escape_string($mysql, $_POST['leisure_description']);
                    $leisureAddress = mysqli_real_escape_string($mysql, $_POST['leisure_address']);
                    $image=($_FILES['leisure_image_url']['name']);
                    $tournamentId = $id;
                    $query = "INSERT INTO leisure (leisure_name, leisure_address, leisure_image_url, leisure_description, tournament_id)
                VALUES
                ('{$leisureName}','{$leisureAddress}','{$image}','{$leisureDescription}','{$tournamentId}');";
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
                            <label>Leisure name</label>
                            <input required type="text" id ="leisure_name" name="leisure_name" class="form-control" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Leisure description</label>
                            <textarea class="ckeditor" required type="text" id ="leisure_description" name="leisure_description" class="form-control" value=""></textarea>
                        </div>
                        <div class="form-group">
                            <label>Leisure address</label>
                            <input required type="text" id ="leisure_address" name="leisure_address" class="form-control" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Leisure image</label>
                            <input type="file" name="leisure_image_url" id="leisure_image_url" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
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
        function updateLeisure (id){
            var leisureName = document.getElementById('leisure_name_' + id).value;
            var leisureDescr = document.getElementById('leisure_descr_' + id).value;
            var leisureAddress = document.getElementById('leisure_address_' + id).value;
            var fullPath = document.getElementById ('leisure_image_' + id).value;
            var image = fullPath.replace(/^.*[\\\/]/, '');
            var url = '&leisureId='+ id +'&leisureName=' + leisureName + '&leisureDescr=' + leisureDescr + '&leisureAddress=' + leisureAddress + '&leisure_image_url=' + image;
            $.ajax({
                type: "POST",
                url: 'http://localhost:8080/loputoo/tournament_settings/leisure.php?updateLeisure=1' + url
            });
            location.href=location.href
        }
        function deleteLeisure (id){
            var url = '&leisureId=' + id;
            $.ajax({
                type: "POST",
                url: 'http://localhost:8080/loputoo/tournament_settings/leisure.php?deleteLeisure=1' + url
            });
            location.href=location.href
        }
    </script>

<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>
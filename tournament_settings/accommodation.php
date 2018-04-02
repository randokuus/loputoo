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

if (isset($_GET['updateAcc'])) {
    if (!empty($_GET['logo'])) {
        $query = "UPDATE accommodation SET name = '" . $_GET['accName'] . "', information = '" . $_GET['accDescr'] . "', address = '" . $_GET['accAddress'] . "', image_url = '" . $_GET['logo'] . "' WHERE id = '" . $_GET['accId'] . "'";
    }else {
        $query = "UPDATE accommodation SET name = '" . $_GET['accName'] . "', information = '" . $_GET['accDescr'] . "', address = '" . $_GET['accAddress'] . "' WHERE id = '" . $_GET['accId'] . "'";
    }
    $_POST = array();
    if (!$mysql->query($query)) {
        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
    }
    exit();
}

if (isset($_GET['deleteAcc'])) {
    $query = "DELETE FROM accommodation WHERE id = '". $_GET['accId']."'";

    $mysql->query($query);
    exit();
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
                <h2>Accommodation</h2>
                <hr>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <h3>Change or add information for your accommodation(s)</h3>
                    <hr>
                    <?php
                        $sql = $mysql->query('SELECT * FROM accommodation
                              WHERE tournament_id = "' . $id . '";');
                        ?>
                        <?php while ($row = $sql->fetch_assoc()){
                            ?>
                                <div class="col-sm-7">
                                    <label>Change accommodation name</label> <br />
                                    <input required type="text" id="acc_name_<?php echo $row['id']; ?>" name="acc_name" class="form-control"value="<?php echo $row['name']; ?>"/> <br />
                                    <label>Change accommodation description</label> <br />
                                    <textarea class="ckeditor" required id="acc_descr_<?php echo $row['id']; ?>" name="acc_description" class="form-control"><?php echo $row['information']; ?></textarea><br/>
                                    <label>Change accommodation address</label> <br />
                                    <input required type="text" id="acc_address_<?php echo $row['id']; ?>" name="acc_address" class="form-control" value="<?php echo $row['address']; ?>"/>
                                </div>
                                <div class="col-sm-5">
                                    <?php
                                    $logo = 'c:/xampp7/htdocs/loputoo/images/accommodation/'. $row['image_url'];
                                    if ($row['image_url'] != '' && file_exists($logo)) {?>
                                        <img class="img-responsive center-block max-height" style="width:350px; height:200px; margin-top: 10px; margin-bottom: 10px;" src="http://localhost:8080/loputoo/images/accommodation/<?php echo $row['image_url']; ?>">
                                    <?php }
                                    else { ?> <p>No pictures available</p>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label>Change accommodation image</label>
                                        <input type="file" name="logo" id="logo_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['image_url']; ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-12" style="margin-top:10px; margin-bottom:10px;">
                                    <button class="btn btn-primary" onclick="updateAcc(<?php echo $row['id'];?>)" style="margin-right:10px;">Confirm</button><button onclick="deleteAcc(<?php echo $row['id'];?>)" class="btn btn-danger"><span style="margin-right:3px;" class="glyphicon glyphicon-trash"></span>Delete</button>
                                </div>
                        <?php } ?>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?php
                    if (!empty($_FILES['logo'])) {
                        include_once 'C:/xampp7/htdocs/loputoo/accommodation_images.php';
                    }
                    if (isset($_POST['submit3'])  && !empty($_POST['name']) && !empty($_POST['information']) && !empty($_POST['address'])){
                        $name = mysqli_real_escape_string($mysql, $_POST['name']);
                        $information = mysqli_real_escape_string($mysql, $_POST['information']);
                        $address = mysqli_real_escape_string($mysql, $_POST['address']);
                        $logo=($_FILES['logo']['name']);
                        $tournamentId = $id;
                        $query = "INSERT INTO accommodation (name, information, image_url, tournament_id, address)
                VALUES
                ('{$name}','{$information}','{$logo}','{$tournamentId}','{$address}');";
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
                                <label>Name</label>
                                <input required type="text" id ="name" name="name" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Information</label> <br/>
                                <textarea class="ckeditor" required type="text" id ="information" name="information" class="form-control" value=""></textarea>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input required type="text" id ="address" name="address" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="logo" id="logo" class="form-control" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="submit3">Confirm</button>
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
        function updateAcc (id){
            var accName = document.getElementById('acc_name_' + id).value;
            var accDescr = document.getElementById('acc_descr_' + id).value;
            var accAddress = document.getElementById('acc_address_' + id).value;
            var fullPath = document.getElementById ('logo_' + id).value;
            var logo = fullPath.replace(/^.*[\\\/]/, '');
            var url = '&accId='+ id +'&accName=' + accName + '&accDescr=' + accDescr + '&accAddress=' + accAddress + '&logo=' + logo;
            $.ajax({
                type: "POST",
                url: 'http://localhost:8080/loputoo/tournament_settings/accommodation.php?updateAcc=1' + url
            });
            location.href=location.href
        }
        function deleteAcc (id){
            var url = '&accId=' + id;
            $.ajax({
                type: "POST",
                url: 'http://localhost:8080/loputoo/tournament_settings/accommodation.php?deleteAcc=1' + url
            });
            location.href=location.href
        }
    </script>

<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>
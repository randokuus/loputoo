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
    $result = $mysql->query("select m.memberID, u.user_id, u.roll_id from members as m LEFT JOIN users_rolls as u ON memberID = user_id  where username ='" . $_SESSION['username'] . "'");
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
    <h2>General settings</h2>
    <hr>
    <?php
    if (isset($_POST['submit']) && !empty($_FILES['logo']['name'])){
        ?>
        <div class="col-sm-12">
            <div class="alert alert-success">
                <strong>Success!</strong> Information has updated.
            </div>
        </div>
    <?php
        $name = $row['name'] = mysqli_real_escape_string($mysql, $_POST['name']);
        $startDate = $row['start_date'] = mysqli_real_escape_string($mysql, $_POST['start_date']);
        $endDate = $row['end_date'] = mysqli_real_escape_string($mysql, $_POST['end_date']);
        $organizerName = $row['organizer_name'] = mysqli_real_escape_string($mysql, $_POST['organizer_name']);
        $logo = $row['logo'] = ($_FILES['logo']['name']);
        $info = $row['info'] = mysqli_real_escape_string($mysql, $_POST['info']);
        $rules = $row['rules'] = mysqli_real_escape_string($mysql, $_POST['rules']);
        $address = $row['address'] = mysqli_real_escape_string($mysql, $_POST['address']);
        $homepage = $row['homepage'] = mysqli_real_escape_string($mysql, $_POST['homepage']);
        $facebook = $row['facebook'] = mysqli_real_escape_string($mysql, $_POST['facebook']);
        $price = $row['price'] = mysqli_real_escape_string($mysql, $_POST['price']);
        $query = "UPDATE tournaments SET name = '$name', start_date = '$startDate', end_date = '$endDate', organizer_name = '$organizerName', logo = '$logo', info = '$info', rules = '$rules', address = '$address', homepage = '$homepage', facebook = '$facebook', price = '$price' WHERE id = '$id'";
        $_POST = array();
        if(!$mysql->query($query)){
            echo'Sisestus ebaõnnestus - ' . $mysql->error;
        }
        echo "<meta http-equiv='refresh' content='0'>";
    } else if (isset($_POST['submit'])){
        $name = $row['name'] = mysqli_real_escape_string($mysql, $_POST['name']);
        $startDate = $row['start_date'] = mysqli_real_escape_string($mysql, $_POST['start_date']);
        $endDate = $row['end_date'] = mysqli_real_escape_string($mysql, $_POST['end_date']);
        $organizerName = $row['organizer_name'] = mysqli_real_escape_string($mysql, $_POST['organizer_name']);
        $info = $row['info'] = mysqli_real_escape_string($mysql, $_POST['info']);
        $rules = $row['rules'] = mysqli_real_escape_string($mysql, $_POST['rules']);
        $address = $row['address'] = mysqli_real_escape_string($mysql, $_POST['address']);
        $homepage = $row['homepage'] = mysqli_real_escape_string($mysql, $_POST['homepage']);
        $facebook = $row['facebook'] = mysqli_real_escape_string($mysql, $_POST['facebook']);
        $price = $row['price'] = mysqli_real_escape_string($mysql, $_POST['price']);
        $query = "UPDATE tournaments SET name = '$name', start_date = '$startDate', end_date = '$endDate', organizer_name = '$organizerName', info = '$info', rules = '$rules', address = '$address', homepage = '$homepage', facebook = '$facebook', price = '$price' WHERE id = '$id'";
        $_POST = array();
        if(!$mysql->query($query)){
            echo'Sisestus ebaõnnestus - ' . $mysql->error;
        }
    }
    ?>
    <div class="col-md-6 col-sm-12">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input required type="text" id="name" name="name" class="form-control" value="<?php echo $row['name']; ?>"/>
            </div>
            <hr>
            <div class="form-group">
                <label>Organizer name</label>
                <input type="text" id="organizer_name" name="organizer_name" class="form-control" value="<?php echo $row['organizer_name']; ?>"/>
            </div>
            <div class="form-group">
                <label>Logo</label>
                <input type="file" name="logo" id="logo" class="form-control" />
            </div>
            <div class="form-group">
                <label>Info</label>
                <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
                <textarea class="ckeditor" name="info" id="info" class="form-control"><?php echo $row['info']; ?></textarea><br/>
            </div>
            <div class="form-group">
                <label>Rules</label>
                <textarea class="ckeditor" name="rules" id="rules" class="form-control" value=""><?php echo $row['rules']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo $row['address']; ?>"/>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label>Homepage</label>
                        <input type="text" id="homepage" name="homepage" class="form-control" value="<?php echo $row['homepage']; ?>"/>
                    </div>
                    <div class="col-sm-6">
                        <label>Facebook</label>
                        <input type="text" id="facebook" name="facebook" class="form-control" value="<?php echo $row['facebook']; ?>"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label>Price</label>
                        <input type="text" id="price" name="price" class="form-control" value="<?php echo $row['price']; ?>"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Start date</label>
                <input required type="date" id ="startDate" name="start_date" class="form-control" value="<?php echo $row['start_date']; ?>"/>
            </div>
            <div class="form-group">
                <label>End date</label>
                <input type="date" name="end_date" class="form-control" value="<?php echo $row['end_date']; ?>"/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit">Update indormation</button>
            </div>
        </form>
    </div>
</div>
</div>
<?php } else {} }?>
<div class="container">
</div>
<?php
if (!empty($_FILES['logo'])) {
    $target_dir = "C:/xampp7/htdocs/loputoo/images/logos/";
    $target_file = $target_dir . basename($_FILES["logo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["logo"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["logo"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["logo"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>

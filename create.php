<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'db.php';
include_once 'header.php';
if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
    $userId = $row['memberID'];
    }
}
if (isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['sport_id']) && !empty($_POST['country_id']) && !empty($_POST['level_id']) && !empty($_POST['gender_id']) && !empty($_POST['class_id']) && !empty($_POST['start_date'])){
    ?>
    <div class="col-sm-12">
        <div class="alert alert-success">
            <strong>Success!</strong> Tournament has created.
        </div>
        <div class="toAccount">
            <a style="color:black;" href="http://localhost:8080/loputoo/myAccount.php"><h4 class="to-upper">See your tournaments</h4></a>
        </div>
    </div>
    <?php
    $name = mysqli_real_escape_string($mysql, $_POST['name']);
    $sportId = mysqli_real_escape_string($mysql, $_POST['sport_id']);
    $countryId = mysqli_real_escape_string($mysql, $_POST['country_id']);
    $levelId = mysqli_real_escape_string($mysql, $_POST['level_id']);
    $ageId = mysqli_real_escape_string($mysql, $_POST['age_id']);
    $genderId = mysqli_real_escape_string($mysql, $_POST['gender_id']);
    $classId = mysqli_real_escape_string($mysql, $_POST['class_id']);
    $startDate = mysqli_real_escape_string($mysql, $_POST['start_date']);
    $endDate = mysqli_real_escape_string($mysql, $_POST['end_date']);
    $organizerName = mysqli_real_escape_string($mysql, $_POST['organizer_name']);
    $logo=($_FILES['logo']['name']);
    $info = mysqli_real_escape_string($mysql, $_POST['info']);
    $address = mysqli_real_escape_string($mysql, $_POST['address']);
    $homepage = mysqli_real_escape_string($mysql, $_POST['homepage']);
    $facebook = mysqli_real_escape_string($mysql, $_POST['facebook']);
    $price = mysqli_real_escape_string($mysql, $_POST['price']);
    $maxParticipants = mysqli_real_escape_string($mysql, $_POST['max_participants']);
    $query = "INSERT INTO tournaments (name, sport_id, country_id, level_id, age_id, gender_id, class_id, start_date, end_date, organizer_name, logo, info, address,homepage, facebook, price, max_participants, user_id)
    VALUES
    ('{$name}','{$sportId}','{$countryId}','{$levelId}','{$ageId}','{$genderId}','{$classId}','{$startDate}','{$endDate}','{$organizerName}','{$logo}','{$info}','{$address}','{$homepage}','{$facebook}','{$price}','{$maxParticipants}','{$userId}');";
    $_POST = array();
    if(!$mysql->query($query)){
        echo'Sisestus ebaõnnestus - ' . $mysql->error;
    }

}
?>
    <body style="font-family: 'Lato', sans-serif;">
    <div class="container">
        <div class="row">
            <h3>Create new Tournament</h3>
            <hr>
            <?php if(!$user->is_logged_in()){ ?>
            Sorry, you need to log in to create tournament <br/>
            <a href="http://localhost:8080/loputoo/loginandregister/login.php"><h3>Log in</h3></a>
            <?php } else { ?>
            <div class="col-md-6">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input required type="text" id ="name" name="name" class="form-control" value=""/>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Sports</label>
                                <select class="form-control" name="sport_id">
                                    <?php

                                    $sql = mysqli_query($mysql, "SELECT DISTINCT sport_name, id FROM sports");

                                    while ($row = $sql->fetch_assoc()){

                                        ?>
                                        <option id="sport_id" name='sportId' value=<?php echo $row['id']; ?>><?php echo $row['sport_name']; ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Country</label>
                                <select class="form-control" name="country_id">
                                    <?php

                                    $sql = mysqli_query($mysql, "SELECT DISTINCT country_name, country_id FROM countries");

                                    while ($row = $sql->fetch_assoc()){

                                        ?>
                                        <option id="country_id" name='countryId' value=<?php echo $row['country_id']; ?>><?php echo $row['country_name']; ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Level</label>
                                <select class="form-control" name="level_id">
                                    <?php

                                    $sql = mysqli_query($mysql, "SELECT DISTINCT level, id FROM level");

                                    while ($row = $sql->fetch_assoc()){

                                        ?>
                                        <option id="level_id" name='levelId' value=<?php echo $row['id']; ?>><?php echo $row['level']; ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Age group</label>
                                <select class="form-control" name="age_id">
                                    <?php

                                    $sql = mysqli_query($mysql, "SELECT DISTINCT age_name, id FROM ages");

                                    while ($row = $sql->fetch_assoc()){

                                        ?>
                                        <option id="age_id" name='ageId' value=<?php echo $row['id']; ?>><?php echo $row['age_name']; ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Gender</label>
                                <select class="form-control" name="gender_id">
                                    <?php

                                    $sql = mysqli_query($mysql, "SELECT DISTINCT gender, id FROM gender");

                                    while ($row = $sql->fetch_assoc()){

                                        ?>
                                        <option id="gender_id" name='genderId' value=<?php echo $row['id']; ?>><?php echo $row['gender']; ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Class</label>
                                <select class="form-control" name="class_id">
                                    <?php

                                    $sql = mysqli_query($mysql, "SELECT DISTINCT class_name, id FROM class");

                                    while ($row = $sql->fetch_assoc()){

                                        ?>
                                        <option id="class_id" name='classId' value=<?php echo $row['id']; ?>><?php echo $row['class_name']; ?></option>

                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Start date</label>
                        <input required type="date" id ="startDate" name="start_date" class="form-control" value=""/>
                    </div>
                    <hr>
                    <div><h4>Optional information</h4></div>
                    <div class="form-group">
                        <label>Organizer name</label>
                        <input type="text" id="organizerName" name="organizer_name" class="form-control" value=""/>
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Info</label>
                        <textarea name="info" id="info" class="form-control" value=""></textarea>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" id="address" name="address" class="form-control" value=""/>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Homepage</label>
                                <input type="text" id="homepage" name="homepage" class="form-control" value=""/>
                            </div>
                            <div class="col-sm-6">
                                <label>Facebook</label>
                                <input type="text" id="facebook" name="facebook" class="form-control" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Price</label>
                                <input type="text" id="price" name="price" class="form-control" value=""/>
                            </div>
                            <div class="col-sm-6">
                                <label>Maximum number of participants</label>
                                <input type="integer" id="maxParticipants'" name="max_participants" class="form-control" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>End date</label>
                        <input type="date" name="end_date" class="form-control" value=""/>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="submit">Add Tournament</button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>

    </div>

    <?php
    if (!empty($_FILES['logo'])) {
        $target_dir = "images/logos/";
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
    <?php include_once 'footer.php'; ?>
    </body>

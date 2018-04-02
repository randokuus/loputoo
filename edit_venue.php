<?php
include_once 'db.php';
include_once 'header.php';
$id = (int)$_GET['id'];
?>
<body style="font-family: 'Lato', sans-serif;">
<div class="container" style="background-color: white;">
    <div class="col-sm-12">
        <h2>Venues</h2>
        <hr>
        <h4>Change or add information for your venues</h4>
        <?php
        $kala = true;
        if($kala){
        $sql = $mysql->query('SELECT * FROM venue
                WHERE id = "' . $id . '";');
        ?>
        <?php while ($row = $sql->fetch_assoc()){
            $venueId = $row['id'];
            ?>
            <?php
            if (isset($_POST['submit'])) {
                $venueName = $row['venue_name'] = mysqli_real_escape_string($mysql, $_POST['venue_name']);
                $venueDescription = $row['venue_description'] = mysqli_real_escape_string($mysql, $_POST['venue_description']);
                $venueAddress = $row['venue_address'] = mysqli_real_escape_string($mysql, $_POST['venue_address']);
                if (isset($_FILES['venue_image_url'])) {
                    include_once 'venue_images.php';
                    $image = $row['venue_image_url'] = ($_FILES['venue_image_url']['name']);
                }else {
                    $image = $row['venue_image_url'] = mysqli_real_escape_string($mysql, $_POST['venue_image_url']);
                }
                $query = "UPDATE venue SET venue_name = '$venueName', venue_description = '$venueDescription', venue_address = '$venueAddress', venue_image_url = '$image' WHERE id = $venueId";
                $_POST = array();
                if (!$mysql->query($query)) {
                    echo 'Sisestus ebaõnnestus - ' . $mysql->error;
                }
            }
            if (isset($_POST['delete'])) {
                $query = "DELETE FROM venue WHERE id = '$venueId'";

                $mysql->query($query);
            }

            ?>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="col-sm-7">
                    <label>Change venue name</label> <br />
                    <input required type="text" id ="venue_name" name="venue_name" class="form-control"value="<?php echo $row['venue_name']; ?>"/> <br />
                    <label>Change venue description</label> <br />
                    <textarea required id ="venue_description" name="venue_description" class="form-control"><?php echo $row['venue_description']; ?></textarea><br/>
                    <label>Change venue address</label> <br />
                    <input required type="text" id ="venue_address" name="venue_address" class="form-control" value="<?php echo $row['venue_address']; ?>"/>
                </div>
                <div class="col-sm-5">
                    <?php
                    $logo = 'c:/xampp7/htdocs/loputoo/images/venues/'. $row['venue_image_url'];
                    if ($row['venue_image_url'] != '' && file_exists($logo)) {?>
                        <img class="img-responsive center-block max-height" style="width:350px; height:200px; margin-top: 10px; margin-bottom: 10px;" src="images/venues/<?php echo $row['venue_image_url']; ?>">
                    <?php }
                    else { ?> <p>No pictures available</p>
                    <?php } ?>
                    <div class="form-group">
                        <label>Change venue image</label>
                        <input type="file" name="venue_image_url" id="venue_image_url" class="form-control" value="<?php echo $row['venue_image_url']; ?>" />
                    </div>
                </div>
                <div class="col-sm-12" style="margin-top:10px; margin-bottom:10px;">
                    <button type="submit" class="btn btn-primary" name="submit" style="margin-right:10px;">Confirm</button><button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-primary" name="delete">Delete</button>
                    <button onclick="goBack()" class="btn btn-primary" style="margin-left:10px;"><a style="color:white;" href="#">Back to venues</a></button>
                </div>
            </form>
        <?php }
        } else {} ?>
    </div>
</div>
<?php include_once 'footer.php'; ?>
<script>
    function goBack() {
        window.history.back();
    }
</script>

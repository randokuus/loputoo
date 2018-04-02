<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'db.php';
include_once 'header.php';
$id = 26;
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
}
var_dump($leisureName, $leisureDescription, $leisureAddress, $tournamentId, $id);
?>
<div class="container">
    <div class="row">
        <h3>Add information about Venues</h3>
        <hr>
        <div class="col-md-6">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Leisure name</label>
                    <input required type="text" id ="leisure_name" name="leisure_name" class="form-control" value=""/>
                </div>
                <div class="form-group">
                    <label>Leisure description</label>
                    <input required type="text" id ="leisure_description" name="leisure_description" class="form-control" value=""/>
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
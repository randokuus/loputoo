<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'C:/xampp7/htdocs/loputoo/db.php';
include_once 'C:/xampp7/htdocs/loputoo/mobile_menu.php';
include_once 'C:/xampp7/htdocs/loputoo/tournament_header.php';
$id = (int)$_GET['id'];
?>
<div class="container" style="background-color: white;">
    <h3>Add new note</h3>
    <?php
    if (isset($_POST['submit'])){
        ?>
        <div class="col-sm-12">
            <div class="alert alert-success">
                <strong>Success!</strong> note has added.
            </div>
        </div>
        <?php
        $name = mysqli_real_escape_string($mysql, $_POST['name']);
        $description = mysqli_real_escape_string($mysql, $_POST['description']);
        $dateTime =  date("Y-m-d H:i:s");
        $query = "INSERT INTO notes (note_name, description, tournament_id, time)
            VALUES
            ('{$name}','{$description}','{$id}','{$dateTime}');";
        $_POST = array();
        if(!$mysql->query($query)){
            echo'Sisestus ebaõnnestus - ' . $mysql->error;
        }

    }
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label>Note heading</label>
            <input required type="text" id="name" name="name" class="form-control" value="<?php echo $row['name']; ?>"/>
        </div>
        <hr>
        <div class="form-group">
            <label>Note description</label>
            <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
            <textarea class="ckeditor" name="description" id="description" class="form-control"></textarea><br/>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="submit">Add note</button>
        </div>
    </form>
</div>
</body>
<?php include_once 'C:/xampp7/htdocs/loputoo/footer.php'; ?>

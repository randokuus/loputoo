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

if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$id = (int)$_GET['id'];
$noteId = (int)$_GET['noteId'];
$result = $mysql->query('SELECT user_id FROM tournaments WHERE id = "'.$id.'"');
while ($row = $result->fetch_assoc()){
    if($user->is_logged_in() && $row['user_id'] == $userId ) {
?>
    <div class="container" style="background-color: white;">
        <h3>Edit note</h3>
        <?php
        if (isset($_POST['submit'])){
            ?>
            <div class="col-sm-12">
                <div class="alert alert-success">
                    <strong>Success!</strong> note has edited.
                </div>
            </div>
            <?php
            $name = mysqli_real_escape_string($mysql, $_POST['name']);
            $description = mysqli_real_escape_string($mysql, $_POST['description']);
            $dateTime =  date("Y-m-d H:i:s");
            $query = "UPDATE notes SET note_name = '$name', description = '$description', time = '$dateTime' WHERE id = '$noteId'";
            $_POST = array();
            if(!$mysql->query($query)){
                echo'Sisestus ebaõnnestus - ' . $mysql->error;
            }

        }
        ?>
        <?php
        if (isset($_POST['submit2'])){
            ?>
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <strong>note has deleted</strong>
                </div>
            </div>
            <?php
            $query = "DELETE FROM notes WHERE id = '".$noteId."'";

            $mysql->query($query);

        }
        ?>
        <?php
        $sql = $mysql->query('SELECT * FROM notes WHERE id = "'.$noteId.'"');
        while ($row = $sql->fetch_assoc()){?>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Note heading</label>
                    <input required type="text" id="name" name="name" class="form-control" value="<?php echo $row['note_name']; ?>"/>
                </div>
                <hr>
                <div class="form-group">
                    <label>Note description</label>
                    <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
                    <textarea class="ckeditor" name="description" id="description" class="form-control"><?php echo $row['description']; ?></textarea><br/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="submit">Edit note</button><button name="submit2" style="margin-left:5px;" class="btn btn-danger delete-player-row"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                </div>
            </form>
        <?php }?>
    </div>
        <?php } else {} }?>
    </body>
<?php include_once 'C:/xampp7/htdocs/loputoo/footer.php'; ?>
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
?>
<div class="container" style="background-color: white;">
    <?php
    $sql = $mysql->query('SELECT * FROM notes WHERE id = "'.$noteId.'" AND tournament_id = "'.$id.'"');
    while ($row = $sql->fetch_assoc()){?>
    <h3><?php echo $row['note_name'] ?></h3>
    <p><?php echo $row['time'] ?></p>
    <div class="note-content col-sm-9">
        <div class="col-sm-6">
            <p><?php echo $row['description'] ?></p>
        </div>
    </div>
        <?php
        $result = $mysql->query('SELECT user_id FROM tournaments WHERE id = "'.$id.'"');
        while ($row = $result->fetch_assoc()){
            if($user->is_logged_in() && $row['user_id'] == $userId ) {
        ?>
    <div class="col-sm-3">
        <div style="float:right;padding:8px;" id="create-new-note-link"><a href="http://localhost:8080/loputoo/notes/addNote.php?id=<?php echo $id;?>"><span class="glyphicon glyphicon-plus"></span>Add new note</a></div>
        <div style="float:right;padding:8px;" id="edit-note-link"><a style="color:black;" href="http://localhost:8080/loputoo/notes/edit.php?id=<?php echo $id;?>&noteId=<?php echo $noteId;?>"><span class="glyphicon glyphicon-edit"></span> Edit note</a></div>
    </div>
        <?php } else {} } ?>
        <?php
        $sql = $mysql->query('SELECT * FROM notes WHERE id = "'.$noteId.'" AND tournament_id = "'.$id.'"');
        while ($row = $sql->fetch_assoc()){?>
    <div class="note-footer col-sm-12" style="margin-top:30px;">
        <h3><?php echo $row['note_name'] ?></h3>
        <p><?php echo $row['time'] ?></p>
    </div>

    <?php } }?>
</div>
</body>
<?php include_once 'C:/xampp7/htdocs/loputoo/footer.php'; ?>
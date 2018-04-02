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
<div class="col-sm-12" style="background-color: white;">
    <div class="col-sm-3">
        <?php include_once 'sideMenu.php'?>
    </div>
    <div class="col-sm-9">
        <h2>Groups</h2>
        <hr>
        <?php $sql = $mysql->query('SELECT * FROM classes WHERE tournament_id = "'.$id.'"');?>
        <?php while ($row = $sql->fetch_assoc()){
            $classId = $row['id'];
            $className = $row['class_name']; ?>
            <h4 style="font-size:2em;"><?php echo $className;?></h4>
            <div class="col-sm-6">
                <?php $result = $mysql->query('SELECT DISTINCT * FROM groups WHERE tournament_id = "'.$id.'" AND class_id = "'.$classId.'"');
                while ($row = $result->fetch_assoc()){?>
                    <div class="to-upper" style="border: 1px solid #dddddd; margin-bottom: 10px; height:45px;">
                        <a style="color:black;" href="http://localhost:8080/loputoo/tournament_settings/groups/?id=<?php echo $id;?>&groupId=<?php echo $row['id'];?>"><span style="font-size: 1.5em;"><?php echo $row['name'] ?></span> | <?php echo $row['number_of_teams'] ?> Teams<span></a></span><span style="float:right;"><button style="margin-top:5px;" class="btn btn-default js-edit-group-btn" data-group-id="<?php echo $row['id'] ?>"><span class="glyphicon glyphicon-cog"></span></button></span>
                    </div>
                <?php }?>
            </div>
            <div class="col-sm-6">
                <h4>Create new group for class </h4>
                <?php
                if (isset($_POST['submit']) && !empty($_POST['venue_id'])){
                    ?>
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <strong>Success!</strong> Group was created.
                        </div>
                    </div>
                    <?php
                    $groupName = mysqli_real_escape_string($mysql, $_POST['group_name']);
                    $teamNumbers= mysqli_real_escape_string($mysql, $_POST['team_numbers']);
                    $advancing= mysqli_real_escape_string($mysql, $_POST['advancing_number']);
                    $venueId= mysqli_real_escape_string($mysql, $_POST['venue_id']);
                    $tournamentId = $id;
                    $query = "INSERT INTO groups (name, number_of_teams, teams_advancing, venue_id, class_id, tournament_id)
            VALUES
            ('{$groupName}','{$teamNumbers}','{$advancing}','{$venueId}','{$classId}','$tournamentId');";
                    $_POST = array();
                    if(!$mysql->query($query)){
                        echo'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                }
                ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Group name *</label>
                            <input required type="text" id="group_name" name="group_name" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Number of teams *</label>
                            <input required type="int" id="team_numbers" name="team_numbers" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Number of teams advancing *</label>
                            <input required type="int" id="advancing_number" name="advancing_number" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Add venue to the group*</label>
                            <select required class="form-control" name="venue_id">
                                <?php

                                $result = mysqli_query($mysql, "SELECT DISTINCT venue_name, id FROM venue WHERE tournament_id = '".$id."'");

                                while ($row = $result->fetch_assoc()){

                                    ?>
                                    <option id="venue_id" name='venue_id' value=<?php echo $row['id']; ?>><?php echo $row['venue_name']; ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="submit" value="Confirm" class="btn btn-primary form-submit" style="margin-top:10px; margin-bottom:10px;">Confirm</button>
                </form>
            </div>
        <?php } ?>
    </div>
</div>
<?php } else {} }?>
<div class="container">
</div>
<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>

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

if (isset($_GET['deleteTeam'])) {
    $query = 'DELETE FROM teams_in_tournaments WHERE team_id ="'.$_GET['teamId'].'" AND class_id ="'.$_GET['classId'].'";';

    $mysql->query($query);
    exit();
}
if (isset($_GET['deleteClass'])) {
    $query = 'DELETE FROM classes WHERE id ="'.$_GET['classId'].'";';

    $mysql->query($query);
    exit();
}
if (isset($_GET['addTeam'])) {
    $query = 'INSERT INTO teams_in_tournaments (tournament_id, team_id, class_id) VALUES("'.$_GET['tournamentId'].'","'.$_GET['teamId'].'", "'.$_GET['classId'].'");';
    var_dump($query);
    $mysql->query($query);
    exit();
}
while ($row = $result->fetch_assoc()){
    if($user->is_logged_in() && $row['user_id'] == $userId ) {
?>
<div class="col-sm-12 col-xs-12" style="background-color: white;">
    <div class="col-sm-3 col-xs-12">
        <?php include_once 'sideMenu.php'?>
    </div>
    <div class="col-sm-9 col-xs-12">
        <h2>Classes</h2>
        <hr>
        <div class="col-sm-12">
            <div class="col-sm-7 col-xs-12">
                <?php $sql = $mysql->query('SELECT * FROM classes WHERE tournament_id = "'.$id.'"');?>
                <?php while ($row = $sql->fetch_assoc()){
                    $classId = $row['id'];
                    $className = $row['class_name'];
                    ?><span style="font-size:2em;"><?php echo $className;?></span><button onclick="deleteClass(<?php echo $classId;?>)" style="margin-left:15px;" class="btn-danger delete-player-row"><span class="glyphicon glyphicon-trash"></span> Delete class</button>
                    <hr><?php
                    $team_id = $row['id'];
                    ?> <?php
                    $result = $mysql->query('SELECT tt.id as t_id, tt.logo_url, tt.team_name, tit.class_id, tit.team_id, c.class_name FROM teams_in_tournaments as tit
                    LEFT JOIN teams_tournament as tt ON tit.team_id = tt.id
                    LEFT JOIN classes as c ON tit.class_id = c.id
                    WHERE tit.class_id = "'.$classId.'" ORDER BY tit.class_id');?>
                    <?php while ($row = $result->fetch_assoc()){
                        $logo = 'c:/xampp7/htdocs/loputoo/images/team_logos/'. $row['logo_url'];
                        if ($row['logo_url'] != '' && file_exists($logo)) {?>
                            <span><img style="max-width:50px; max-height:50px; margin-right:8px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/<?php echo $row['logo_url']?>"></span>
                        <?php }
                        else { ?> <span><img style="max-width:50px; max-height:50px; margin-right:8px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/default-logo.png"></span>
                        <?php } ?>
                        <span style="font-size: 1.5em; margin-bottom:20px;">
                        <?php echo $row['team_name']?></a></span><button onclick="deleteTeam(<?php echo $classId . ', ' . $row['t_id'];?>)" style="margin-left:15px;" class="btn-danger delete-player-row"><span class="glyphicon glyphicon-trash"></span> Delete</button><br/>

                    <?php } ?>
                    <div class="addTeam">
                        <h4>Add teams to class</h4>
                            <select class="form-control" id="team_id_<?php echo $classId; ?>" name="team_id">
                                <?php
                                $team = mysqli_query($mysql, "SELECT DISTINCT team_name, id FROM teams_tournament");
                                while ($row = $team->fetch_assoc()){
                                    ?>
                                    <option id="team_id" name='teamId' value=<?php echo $row['id']; ?>><?php echo $row['team_name']; ?></option>
                                    <?php
                                }?>
                            </select>
                            <div class="form-group">
                                <button type="submit" onclick="addTeam(<?php echo $classId . ', ' . $id  ;?>)" class="btn btn-primary" style="margin-top:10px;">Add Team</button>
                            </div>
                    </div>
                        <?php } ?>
            </div>
            <div class="col-sm-5 col-xs-12">
                <?php
                if (isset($_POST['submit']) && !empty($_POST['format_id'])){
                    ?>
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <strong>Success!</strong> Class was created.
                        </div>
                    </div>
                    <?php
                    $className = mysqli_real_escape_string($mysql, $_POST['class_name']);
                    $matchPeriods= mysqli_real_escape_string($mysql, $_POST['match_periods']);
                    $periodLength= mysqli_real_escape_string($mysql, $_POST['period_length']);
                    $maxTeams= mysqli_real_escape_string($mysql, $_POST['max_teams']);
                    $maxPlayers= mysqli_real_escape_string($mysql, $_POST['max_players']);
                    $formatId= mysqli_real_escape_string($mysql, $_POST['format_id']);
                    $startTime= mysqli_real_escape_string($mysql, $_POST['start_time']);
                    $endTime= mysqli_real_escape_string($mysql, $_POST['end_time']);
                    $tournamentId = $id;
                    $query = "INSERT INTO classes (class_name, max_teams, match_periods, max_players, format_id, start_time, end_time, tournament_id)
            VALUES
            ('{$className}','{$maxTeams}','{$matchPeriods}','{$maxPlayers}','{$formatId}','{$startTime}','{$endTime}','$tournamentId');";
                    $_POST = array();
                    if(!$mysql->query($query)){
                        echo'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
            <h3>Add new class</h3>
            <hr>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Class name *</label>
                            <input required type="text" id ="class_name" name="class_name" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Match periods *</label>
                            <input required type="int" id ="match_periods" name="match_periods" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Match period length *</label>
                            <input required type="int" id ="period_length" name="period_length" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Max teams *</label>
                            <input required type="int" id ="max_teams" name="max_teams" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Max players per team *</label>
                            <input required type="int" id ="max_players" name="max_players" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label>Choose format</label>
                        <select class="form-control" name="format_id">
                            <?php

                            $sql = mysqli_query($mysql, "SELECT DISTINCT format_name, format_id FROM tournament_formats");

                            while ($row = $sql->fetch_assoc()){

                                ?>
                                <option id="format_id" name='format_id' value=<?php echo $row['format_id']; ?>><?php echo $row['format_name']; ?></option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label>Start time *</label>
                        <div class="form-group">
                            <input required type="date" id ="start_time" name="start_time" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label>End time *</label>
                        <div class="form-group">
                            <input required type="date" id ="end_time" name="end_time" class="form-control" value=""/>
                        </div>
                    </div>
                    <button type="submit" name="submit" value="Confirm" class="btn btn-primary form-submit" style="margin-top:10px; margin-bottom:10px;">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } else {} }?>
<div class="container">
</div>
<script>
    function deleteTeam (classId, teamId){
    var url = '&teamId=' + teamId + '&classId=' + classId;
    $.ajax({
    type: "POST",
    url: 'http://localhost:8080/loputoo/tournament_settings/classes.php?deleteTeam=1' + url
    });
        location.href=location.href

    }
    function deleteClass (classId){
        var url ='&classId=' + classId;
        $.ajax({
            type: "POST",
            url: 'http://localhost:8080/loputoo/tournament_settings/classes.php?deleteClass=1' + url
        });
        location.href=location.href

    }
    function addTeam (classId, tournamentId){
        var teamId = document.getElementById ('team_id_' + classId).value;
        var url = '&teamId=' + teamId + '&classId=' + classId + '&tournamentId=' + tournamentId;
        $.ajax({
            type: "POST",
            url: 'http://localhost:8080/loputoo/tournament_settings/classes.php?addTeam=1' + url
        });
        location.href=location.href

    }
</script>
<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>
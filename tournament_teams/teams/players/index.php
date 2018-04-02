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
$id = (int)$_GET['playerId'];
$teamId = (int)$_GET['teamId'];
$tournamentId = (int)$_GET['id'];
$classId = (int)$_GET['classId'];

if($user->is_logged_in()) {
    $result = $mysql->query("SELECT memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$sql = $mysql->query('SELECT user_id FROM tournaments WHERE id = "'.$tournamentId.'"');
while ($row = $sql->fetch_assoc()){
    $tournamentUser = $row['user_id'];
}

$result = $mysql->query('SELECT DISTINCT * FROM players as p 
LEFT JOIN player_positions as pp ON p.position_id = pp.id
LEFT JOIN teams_tournament as tt ON p.team_id = tt.id
WHERE p.id = "'.$id.'";');

?>
    <div class="container" style="background-color: white;">
        <div class="col-sm-9">
            <?php while ($row = $result->fetch_assoc()){
                $playerPosition = $row['position_id'];
                ?>
                <div class="col-sm-12" style="margin-bottom: 20px;">
                    <h1><?php echo '#' . $row['player_nr'] .' | '. $row['firstname'] .' '. $row['lastname'] .' - '. $row['team_name'];?></h1>
                </div>
                <div class="col-sm-4">
                    <?php
                    $image = 'c:/xampp7/htdocs/loputoo/images/players_images/'. $row['image'];
                    if ($row['image'] != '' && file_exists($image)) {?>
                        <img class="img-responsive center-blockt" style="max-width:220px; max-height:220px; border: 3px solid rgba(0,0,0,0.2);" src="http://localhost:8080/loputoo/images/players_images/<?php echo $row['image']; ?>">
                    <?php }
                    else { ?> <img class="img-responsive center-block max-height" style="max-width:220px; max-height:220px;  border: 3px solid rgba(0,0,0,0.2);" src="http://localhost:8080/loputoo/images/players_images/default_image.png">
                    <?php } ?>
                </div>
                <div class="col-sm-4">
                    <div class="to-upper">
                        <span style="color:rgba(0,0,0,0.6);">Name:</span><span> <?php echo $row['firstname'] .' '. $row['lastname']; ?></span><br/>
                        <span style="color:rgba(0,0,0,0.6);">Number:</span><span> <?php echo $row['player_nr']; ?></span><br/>
                        <span style="color:rgba(0,0,0,0.6);">Position:</span><span> <?php echo $row['position']; ?></span><br/>
                        <?php
                        $dateOfBirth = $row['birthdate'];
                        $today = date("Y-m-d");
                        $diff = date_diff(date_create($dateOfBirth), date_create($today));
                        ?>
                        <span style="color:rgba(0,0,0,0.6);">Age:</span><span> <?php echo $diff->format('%y'); ?></span><br/>
                        <span style="color:rgba(0,0,0,0.6);">Birthdate:</span><span> <?php echo $row['birthdate']; ?></span>
                    </div>
                </div>
            <?php } ?>
                <div class="col-sm-4">
                    Select a player:
                    <select class="form-control" id="player_id" name="player_id" onchange="playerChange()" value=""">
                        <?php
                        $sql = $mysql->query("SELECT DISTINCT id, firstname, lastname FROM players WHERE team_id = '".$teamId."' AND class_id = '".$classId."' ;");
                        while ($row = $sql->fetch_assoc()) {
                            ?>
                            <option id="player_id" name='player_id'
                                    value="<?php echo $row['id']; ?>" <?php if ($id == $row['id']) { ?> Selected <?php } ?>>
                                <?php echo $row['firstname'] . ' ' . $row['lastname']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <script type="text/javascript">
                    function playerChange(){
                        var urlString = "http://localhost:8080/loputoo/tournament_teams/teams/players/?id=<?php echo $tournamentId;?>&classId=<?php echo $classId;?>&teamId=<?php echo $teamId;?>&playerId=<?php echo $row['id'];?>";

                        var players = document.getElementById('player_id');
                        var selectedPlayer = players.options[players.selectedIndex];
                        if (selectedPlayer.value != "nothing"){
                            window.location = urlString + selectedPlayer.value;
                        }
                    }
                </script>
                <?php
                $result = $mysql->query('SELECT DISTINCT * FROM players as p 
                LEFT JOIN player_positions as pp ON p.position_id = pp.id
                LEFT JOIN teams_tournament as tt ON p.team_id = tt.id
                WHERE p.id = "'.$id.'";');
                ?>
            <?php while ($row = $result->fetch_assoc()){
                $managerId = $row['manager_id'];?>
                <div class="col-sm-12" style="margin-top:20px;">
                    <div id="player-page-statistics">
                        <div class="panel panel-default">
                            <div class="panel-heading">Statistics</div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead><tr><th>Goals</th><th>Assists</th><th>Yellows</th></tr></thead>
                                    <tbody><tr><td>0</td><td>0</td><td>0</td></tr></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            if ($user->is_logged_in()){
                if($tournamentUser == $userId || $managerId == $userId ){ ?>
            <div class="col-sm-12">
                <h3>Update player information</h3>
                <?php
                if (isset($_POST['submit']) && !empty($_FILES['player_image']['name'])){
                    $firstname = mysqli_real_escape_string($mysql, $_POST['firstname']);
                    $lastname = mysqli_real_escape_string($mysql, $_POST['lastname']);
                    $playerNumber = mysqli_real_escape_string($mysql, $_POST['player_number']);
                    $birthdate = mysqli_real_escape_string($mysql, $_POST['birthdate']);
                    $positionId = mysqli_real_escape_string($mysql, $_POST['position_id']);
                    $teamId = $id;
                    $image=($_FILES['player_image']['name']);
                    include_once 'C:/xampp7/htdocs/loputoo/tournament_teams/teams/player_image.php';
                    $query = "UPDATE players SET firstname = '$firstname', lastname = '$lastname', player_nr = '$playerNumber', birthdate = '$birthdate', position_id = '$positionId', image = '$image' WHERE id = $id";
                    $_POST = array();
                    if (!$mysql->query($query)) {
                        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                } else if (isset($_POST['submit']) && empty($_POST['player_image'])) {
                    $firstname = mysqli_real_escape_string($mysql, $_POST['firstname']);
                    $lastname = mysqli_real_escape_string($mysql, $_POST['lastname']);
                    $playerNumber = mysqli_real_escape_string($mysql, $_POST['player_number']);
                    $birthdate = mysqli_real_escape_string($mysql, $_POST['birthdate']);
                    $positionId = mysqli_real_escape_string($mysql, $_POST['position_id']);
                    $teamId = $id;
                    $query = "UPDATE players SET firstname = '$firstname', lastname = '$lastname', player_nr = '$playerNumber', birthdate = '$birthdate', position_id = '$positionId' WHERE id = $id";
                    $_POST = array();
                    if (!$mysql->query($query)) {
                        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                if (isset($_POST['delete'])) {
                    $query = "DELETE FROM players WHERE id = '$id'";

                    $mysql->query($query);
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="col-sm-6">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Firstname</label>
                                <input required type="text" id ="firstname" name="firstname" class="form-control" value="<?php echo $row['firstname']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Lastname </label>
                                <input required type="text" id ="lastname" name="lastname" class="form-control" value="<?php echo $row['lastname']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Player number</label>
                                <input required type="text" id ="player_number" name="player_number" class="form-control" value="<?php echo $row['player_nr']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Birthdate</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?php echo $row['birthdate']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <select class="form-control" name="position_id" value="<?php echo $row['position_id']; ?>">
                                <?php

                                $sql = mysqli_query($mysql, "SELECT DISTINCT id, position FROM player_positions");

                                while ($row = $sql->fetch_assoc()){

                                    ?>
                                    <option <?php if($playerPosition == $row['id']){?> Selected <?php } ?> id="position_id" name='position_id' value="<?php echo $row['id']; ?>">
                                        <?php echo $row['position']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Player image</label>
                                <input type="file" name="player_image" id="player_image" class="form-control" />
                            </div>
                        </div>
                        <div class="buttons" style="margin-bottom:10px;">
                            <button type="submit" id="submit" name="submit" value="Confirm" class="btn btn-primary form-submit" style="margin-right:10px;">Confirm</button><button type="submit" name="delete" onclick="return confirm('Are you sure?')" class="btn btn-danger"><span style="margin-right:3px;" class="glyphicon glyphicon-trash"></span>Delete</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php } else { } }?>
            <?php } ?>
        </div>
        <?php
        $result = $mysql->query("SELECT DISTINCT * FROM tournament_settings WHERE tournament_id = '".$id."';");
        while ($row = $result->fetch_assoc()){
        if($row['sponsors_enabled'] == 1) {
        ?>
        <div class="col-sm-3">
            <h4><div style="text-align: center">Supporters</div></h4>
            <hr>
            <div style="text-align: center;">
                <a href="http://www.turniir.ee" target="_blank"><img src="http://localhost:8080/loputoo/images/logos/turniir_new_0.png" style="max-width:200px; max-height:200px;" /></a>
                <?php
                $sql = $mysql->query('SELECT * FROM sponsors WHERE tournament_id = "27"');
                ?>
                <?php while ($row = $sql->fetch_assoc()){ ?>
                    <a href="<?php echo $row['sponsor_site_url'] ?>" target="_blank"><img src="http://localhost:8080/loputoo/images/sponsorImages/<?php echo $row['sponsor_logo_url']?>" style="max-width:200px; max-height:200px; margin-top:25px;" /></a>
                <?php } ?>
            </div>
        </div>
        <?php } else { } }?>
    </div>
<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>

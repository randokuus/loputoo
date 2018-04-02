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
$teamId = (int)$_GET['teamId'];
$tournamentId = (int)$_GET['id'];
$classId = (int)$_GET['classId'];

if($user->is_logged_in()) {
    $result = $mysql->query("SELECT memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
?>
<?php
$sql = $mysql->query('SELECT * FROM teams_in_tournaments as tit 
                      LEFT JOIN teams_tournament as tt ON tit.team_id = tt.id
                      LEFT JOIN classes as c ON tit.class_id = c.id
                      LEFT JOIN tournaments as t ON tit.tournament_id = t.id
                      WHERE tit.team_id = "'.$teamId.'" AND tit.class_id = "'.$classId.'"');
?>
<?php while ($row = $sql->fetch_assoc()){
    $tournamentUser = $row['user_id'];
    $managerId = $row['manager_id'];
    ?>
    <div class="container" style="background-color: white;">
        <div class="col-sm-9">
            <h1><?php echo $row['team_name']?></h1> <br/>
            <ul class="nav nav-tabs" style="background-color: white; width:100%; margin-left:-15px;">
                <li class="active">
                    <a class="nav-link" data-toggle="tab" href="#team_info">Team info <span class="sr-only">(current)</span></a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#players">Players</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="team_info">
                    <div class="col-sm-4">
                        <?php
                        $logo = 'c:/xampp7/htdocs/loputoo/images/team_logos/'. $row['logo_url'];
                        if ($row['logo_url'] != '' && file_exists($logo)) {?>
                        <img style="max-width:150px; max-height:150px; margin-top:15px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/<?php echo $row['logo_url']?>">
                        <?php }
                        else { ?> <img style="max-width:150px; max-height:150px; margin-top:15px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/default-logo.png">
                        <?php } ?>
                    </div>
                    <div class="col-sm-4">
                        <p style="margin-top:13px;">Team name : <?php echo $row['team_name']; ?></p>
                        <p>Country : <?php if ( $row['country_id'] == '1') {?>
                                <img src="http://localhost:8080/loputoo/images/flags/et-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <?php if ( $row['country_id'] == '2') {?>
                                <img src="http://localhost:8080/loputoo/images/flags/ru-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <?php if ( $row['country_id'] == '3') {?>
                                <img src="http://localhost:8080/loputoo/images/flags/lv-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <?php if ( $row['country_id'] == '4') {?>
                                <img src="http://localhost:8080/loputoo/images/flags/lt-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <?php if ( $row['country_id'] == '5') {?>
                                <img src="http://localhost:8080/loputoo/images/flags/fi-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?></p>
                        <p> Class:<?php echo $row['class_name'] ;?></p>
                    </div>
                    <div class="col-sm-4">
                        <hr style="margin:5px; 0;">
                        Top scorers:
                    </div>
                    <div class="col-sm-12">
                        <div id="team-games">
                            <div class="clearfix"></div>
                            <div class="panel panel-default">
                                <div class="panel-heading"><span class="glyphicon glyphicon-calendar"></span>Schedule</div>
                                <div class="panel-body">
                                    <a class="match-link" style="color:black" href="#">
                                        <div class="match-container">
                                            <div class="match-header">
                                                <span class="header-content-date"><small>24/02/2018 10:00</small></span>
                                                <span class="header-content-venue"><small>Tarvastu Gümn spordisaal</small></span>
                                            </div>
                                            <div class="panel-body">
                                                <div>
                                                    <table class="match-body-table">
                                                        <tbody>
                                                        <tr>
                                                            <td class="match-teams">
                                                                <div class="match-teams-team"><span class="logo-small-container"><img class="match-logo-small" src="http://localhost:8080/loputoo/images/team_logos/tarvastu.png"></span>FC Tarvastu</div>
                                                                <div><span class="logo-small-container"><img class="match-logo-small" src="http://localhost:8080/loputoo/images/team_logos/fcelva.jpg"></span>FC Elva</div>
                                                            </td>
                                                            <td class="match-score">
                                                                <div><span class="no-wrap-class">3</span></div>
                                                                <div><span class="no-wrap-class">0</span></div>
                                                            </td>
                                                            <td class="match-time">
                                                                <div>
                                                                    Finished
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="match-footer">
                                                <div><small><span></span><span class="match-footer-separator">-</span><span class="match-footer-class-name"><?php echo $row['class_name'] ;?></span></small></div>
                                            </div>
                                        </div>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="players">
                    <table class="table" id="team-players-table">
                        <thead>
                        <tr>
                            <td colspan="3">Players:
                            </td>
                            <td class="table-cell-content-center">Goals	</td>
                            <td class="table-cell-content-center">A	</td>
                            <td class="table-cell-content-center">Y	</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $player = mysqli_query($mysql, 'SELECT DISTINCT * FROM players WHERE team_id = "' . $teamId . '" AND class_id = "'.$classId.'";');
                        ?>
                        <?php while ($row = $player->fetch_assoc()){ ?>
                            <tr id="">
                                <td class="no-wrap-class">| <?php echo $row['player_nr'];?> |</td>
                                <td class="no-wrap-class"><a style="color:black;"  href="http://localhost:8080/loputoo/tournament_teams/teams/players/?id=<?php echo $tournamentId;?>&teamId=<?php echo $teamId;?>&playerId=<?php echo $row{'id'};?>&classId=<?php echo $classId; ?>"><?php echo $row['firstname'] .' '. $row['lastname'];?></a></td>
                                <td><?php echo $row['birthdate'];?></td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php
                    if ($user->is_logged_in()){
                        if($tournamentUser == $userId || $managerId == $userId ){ ?>
                        <div class="col-sm-12">
                            <h3>Add players to the team</h3>
                            <?php
                            if (isset($_POST['submit'])){
                                $firstname = mysqli_real_escape_string($mysql, $_POST['firstname']);
                                $lastname = mysqli_real_escape_string($mysql, $_POST['lastname']);
                                $playerNumber = mysqli_real_escape_string($mysql, $_POST['player_number']);
                                $birthdate = mysqli_real_escape_string($mysql, $_POST['birthdate']);
                                $positionId = mysqli_real_escape_string($mysql, $_POST['position_id']);
                                $teamId = $teamId;
                                $image=($_FILES['player_image']['name']);
                                if (!empty($_FILES['player_image'])) {
                                    include_once 'player_image.php';
                                }
                                $query = "INSERT INTO players (firstname, lastname, player_nr, birthdate, position_id, image, team_id, class_id)
                VALUES
                ('{$firstname}','{$lastname}','{$playerNumber}','{$birthdate}','{$positionId}','{$image}','{$teamId}', '{$classId}');";
                                $_POST = array();
                                if(!$mysql->query($query)){
                                    echo'Sisestus ebaõnnestus - ' . $mysql->error;
                                }
                                echo "<meta http-equiv='refresh' content='0'>";
                            }
                            ?>
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Firstname</label>
                                            <input required type="text" id ="firstname" name="firstname" class="form-control" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Lastname </label>
                                            <input required type="text" id ="lastname" name="lastname" class="form-control" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Player number</label>
                                            <input required type="text" id ="player_number" name="player_number" class="form-control" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Birthdate</label>
                                            <input type="date" class="form-control" name="birthdate" id="birthdate" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="position_id" value="">
                                            <?php

                                            $sql = mysqli_query($mysql, "SELECT DISTINCT id, position FROM player_positions");

                                            while ($row = $sql->fetch_assoc()){

                                                ?>
                                                <option id="position_id" name='position_id' value="<?php echo $row['id']; ?>">
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
                                    <button type="submit" id="submit" name="submit" value="Confirm" class="btn btn-primary form-submit" style="margin-bottom:10px;">Confirm</button>
                                </div>
                            </form>
                        </div>
                    <?php } else { } }?>
                </div>
            </div>
        </div>
        <?php
        $result = $mysql->query("SELECT DISTINCT * FROM tournament_settings WHERE tournament_id = '".$id."';");
        while ($row = $result->fetch_assoc()){
            if($row['sponsors_enabled'] == 1) {
        ?>
            <div class="col-sm-3">
                <h4><div style="text-align: center">Supporters</div></h4>
                <hr>
                <a href="http://www.turniir.ee" target="_blank"><img src="http://localhost:8080/loputoo/images/logos/turniir_new_0.png" style="max-width:200px; max-height:200px;" /></a>
                <?php
                $sql = $mysql->query('SELECT * FROM sponsors WHERE tournament_id = "27"');
                ?>
                <?php while ($row = $sql->fetch_assoc()){ ?>
                    <a href="<?php echo $row['sponsor_site_url'] ?>" target="_blank"><img src="http://localhost:8080/loputoo/images/sponsorImages/<?php echo $row['sponsor_logo_url']?>" style="max-width:200px; max-height:200px; margin-top:25px;" /></a>
                <?php } ?>
            </div>
        <?php } else { } }?>
    </div>
<?php }?>
<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>
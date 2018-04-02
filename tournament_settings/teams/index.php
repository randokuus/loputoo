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
$teamId = (int)$_GET['teamId'];
$tournamentId = (int)$_GET['id'];
$classId = (int)$_GET['classId'];

if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}

$result = $mysql->query('SELECT DISTINCT user_id FROM tournaments
                          WHERE id = "' . $id . '";');

if (isset($_GET['ajaxRequest'])) {
    $query = "UPDATE players SET player_nr = '". $_GET['playerNumber']."', firstname = '". $_GET['firstName']."', lastname = '". $_GET['lastName']."', birthdate = '". $_GET['birthdate']."', position_id = '". $_GET['positionId']."' WHERE id = '". $_GET['playerId']."'";
    $_POST = array();
    if (!$mysql->query($query)) {
        echo 'Sisestus ebaõnnestus - ' . $mysql->error;
    }
    exit();
}
if (isset($_GET['delete'])) {
    $query = "DELETE FROM players WHERE id = '". $_GET['playerId']."'";

    $mysql->query($query);
    exit();
}
?>
<?php
$sql = $mysql->query('SELECT * FROM teams_in_tournaments as tit 
                      LEFT JOIN teams_tournament as tt ON tit.team_id = tt.id 
                      WHERE tit.team_id = "'.$teamId.'" AND tit.class_id = "'.$classId.'"');

while ($row = $result->fetch_assoc()){
if($user->is_logged_in() && $row['user_id'] == $userId ) {
?>
<div class="col-sm-12" style="background-color: white;">
    <div class="col-md-2 col-sm-3">
        <?php include_once 'C:/xampp7/htdocs/loputoo/tournament_settings/sideMenu.php'?>
    </div>
    <?php while ($row = $sql->fetch_assoc()){

    if (isset($_POST['submit']) && !empty($_FILES['team_logo']['name'])) {
        ?>
        <div class="col-sm-6">
            <div class="alert alert-success">
                <strong>Success!</strong> Information has updated.
            </div>
        </div>
        <?php
        $teamName = $row['team_name'] = mysqli_real_escape_string($mysql, $_POST['team_name']);
        $contactName = $row['contact_name'] = mysqli_real_escape_string($mysql, $_POST['contact_name']);
        $email = $row['contact_email'] = mysqli_real_escape_string($mysql, $_POST['contact_email']);
        $contactPhone = $row['contact_phone'] = mysqli_real_escape_string($mysql, $_POST['contact_phone']);
        $image=($_FILES['team_logo']['name']);
        if (!empty($_FILES['team_logo'])) {
            include_once 'C:/xampp7/htdocs/loputoo/team_logos.php';
        }
        $query = "UPDATE teams_tournament SET team_name = '$teamName', contact_name = '$contactName', contact_email = '$email', contact_phone = '$contactPhone', logo_url ='$image' WHERE id = '$teamId'";
        $_POST = array();
        if (!$mysql->query($query)) {
            echo 'Sisestus ebaõnnestus - ' . $mysql->error;
        }
        echo "<meta http-equiv='refresh' content='0'>";

    } else if (isset($_POST['submit'])) { ?>
        <div class="col-sm-6">
            <div class="alert alert-success">
                <strong>Success!</strong> Information has updated.
            </div>
        </div>
        <?php
        $teamName = $row['team_name'] = mysqli_real_escape_string($mysql, $_POST['team_name']);
        $contactName = $row['contact_name'] = mysqli_real_escape_string($mysql, $_POST['contact_name']);
        $email = $row['contact_email'] = mysqli_real_escape_string($mysql, $_POST['contact_email']);
        $contactPhone = $row['contact_phone'] = mysqli_real_escape_string($mysql, $_POST['contact_phone']);
        $query = "UPDATE teams_tournament SET team_name = '$teamName', contact_name = '$contactName', contact_email = '$email', contact_phone = '$contactPhone' WHERE id = '$teamId'";
        $_POST = array();
        if (!$mysql->query($query)) {
            echo 'Sisestus ebaõnnestus - ' . $mysql->error;
        }
        echo "<meta http-equiv='refresh' content='0'>";
    } ?>
    <div class="col-md-10 col-sm-9">
            <div class="col-sm-6">
                <div class="panel panel-default" style="margin-top: 15px;">
                    <div class="panel-body team-info-container">
                        <div class="pull-right"><?php
                            $logo = 'c:/xampp7/htdocs/loputoo/images/team_logos/'. $row['logo_url'];
                            if ($row['logo_url'] != '' && file_exists($logo)) {?>
                                <img style="max-width:50px; max-height:50px; margin-right:8px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/<?php echo $row['logo_url']?>">
                            <?php }
                            else { ?><img style="max-width:50px; max-height:50px; margin-right:8px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/default-logo.png">
                            <?php } ?>
                            </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="team-info-edit-wrapper">
                                <label for="team-name-input">Team name:</label>
                                <input type="text" id="team_name" name="team_name" class="form-control" value="<?php echo $row['team_name']?>">
                            </div>
                            <div class="team-info-edit-wrapper">
                                <label for="contact-name-input">Contact name:</label>
                                <input type="text" id="contact_name" name="contact_name" class="form-control" value="<?php echo $row['contact_name']?>">
                            </div>
                            <div class="team-info-edit-wrapper">
                                <label for="contact-email-input">E-mail:</label>
                                <input type="text" id="contact_email" name="contact_email" class="form-control" value="<?php echo $row['contact_email']?>">
                            </div>
                            <div class="team-info-edit-wrapper">
                                <label for="contact-phone-input">Contact phone:</label>
                                <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="<?php echo $row['contact_phone']?>">
                            </div>
                            <div class="team-info-edit-wrapper">
                                <label for="team_logo">Team logo:</label>
                                <input type="file" id="team_logo" name="team_logo" class="form-control" value="">
                            </div>
                            <div>
                                <button style="margin-top:15px;" type="submit" name="submit" class="btn btn-primary"> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php
        $sql = $mysql->query('SELECT DISTINCT pp.id, pp.position, c.max_players, p.id as p_id, p.firstname, p.lastname, p.player_nr, p.birthdate, p.position_id, p.class_id FROM players as p
                              LEFT JOIN player_positions as pp ON p.position_id = pp.id
                              LEFT JOIN classes as c ON p.class_id = c.id
                      WHERE team_id = "'.$teamId.'" AND class_id = "'.$classId.'"');
        ?>
        <div class="col-sm-12">
            <div class="alert update alert-success alert-dismissable" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Success! Player updated.
            </div>
            <div class="alert delete alert-danger alert-dismissable" style="display:none;">
                <button type="text" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Danger! Player deleted.
            </div>
            <div class="panel panel-default" id="playerTable">
                <div class="panel-heading">Players</div>
                <div class="panel-body">
                    <table id="players-table" class="table table-bordered">
                        <tbody id="tabelBody"><tr>
                            <td>Nr</td>
                            <td>First name</td>
                            <td>Last name</td>
                            <td>Birth date</td>
                            <td>Position</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr class="team-player-row">
                            <?php
                            if (isset($_POST['submit2'])){
                                $firstname = mysqli_real_escape_string($mysql, $_POST['firstname']);
                                $lastname = mysqli_real_escape_string($mysql, $_POST['lastname']);
                                $playerNumber = mysqli_real_escape_string($mysql, $_POST['player_number']);
                                $birthdate = mysqli_real_escape_string($mysql, $_POST['birthdate']);
                                $positionId = mysqli_real_escape_string($mysql, $_POST['position_id']);
                                $query = "INSERT INTO players (firstname, lastname, player_nr, birthdate, position_id, team_id, class_id)
                                            VALUES
                                            ('{$firstname}','{$lastname}','{$playerNumber}','{$birthdate}','{$positionId}','{$teamId}','{$classId}');";
                                $_POST = array();
                                if(!$mysql->query($query)){
                                    echo'Sisestus ebaõnnestus - ' . $mysql->error;
                                }
                                echo "<meta http-equiv='refresh' content='0'>";
                            }
                            ?>
                            <form method="post" action="" enctype="multipart/form-data">
                                <td><input name="player_number" class="form-control" type="text" size="5"></td>
                                <td><input required name="firstname" class="form-control" type="text"></td>
                                <td><input required name="lastname" class="form-control" type="text"></td>
                                <td><input name="birthdate" placeholder="pp-kk-aaaa" type="date" value="1990-01-01" id=""></td>
                                <td>
                                    <select class="form-control" name="position_id" value="<?php echo $row['position_id']; ?>">
                                        <?php

                                        $result = mysqli_query($mysql, "SELECT DISTINCT id, position FROM player_positions");

                                        while ($row = $result->fetch_assoc()){

                                            ?>
                                            <option id="position_id" name='position_id' value="<?php echo $row['id']; ?>">
                                                <?php echo $row['position']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td class="center"><button type="submit" onclick="addPlayer()"; name="submit2" id="addPlayer" class="btn btn-default save-player-row">Add new</button></td>
                            </form>
                        </tr>
                        <?php while ($row = $sql->fetch_assoc()){
                        $playerId = $row['p_id'];
                        $playerPosition = $row['position_id'];
                            ?>
                                <tr class="team-player-row">
                                    <td><input name="player_nr" id="player_number_<?php echo $playerId; ?>" class="player-nr form-control" type="text" value="<?php echo $row['player_nr']; ?>" size="5"></td>
                                    <td><input name="first_name" id="first_name_<?php echo $playerId; ?>" class="player-first-name form-control" type="text" value="<?php echo $row['firstname']; ?>"></td>
                                    <td><input name="last_name" id="last_name_<?php echo $playerId; ?>" class="player-last-name form-control" type="text" value="<?php echo $row['lastname']; ?>"></td>
                                    <td><input name="birthdate" id="birthdate_<?php echo $playerId; ?>" type="date" value="<?php echo $row['birthdate']; ?>" id="birthdate"></td>
                                    <td>
                                        <select class="form-control" id="position_id_<?php echo $playerId; ?>" name="position_id" value="<?php echo $row['position_id']; ?>">
                                            <?php

                                            $result = mysqli_query($mysql, "SELECT DISTINCT id, position FROM player_positions");

                                            while ($row = $result->fetch_assoc()){ ?>
                                                <option <?php if($playerPosition == $row['id']){?> Selected <?php } ?> id="position_id" name='position_id' value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['position']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td class="center"><button type="submit" id="playerIpdate" onclick="updatePlayer(<?php echo $playerId;?>)" class="btn btn-default save-player-row">Save</button></td>
                                    <td class="center"><button onclick="deletePlayer(<?php echo $playerId;?>)" class="btn btn-danger delete-player-row"><span class="glyphicon glyphicon-trash"></span> Delete</button></td>
                                </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else {} }?>
<div class="container">
</div>
<script>
    function updatePlayer (id){
        var playerNumber = document.getElementById('player_number_' + id).value;
        var firstName = document.getElementById('first_name_' + id).value;
        var lastName = document.getElementById('last_name_' + id).value;
        var birthdate = document.getElementById ('birthdate_' + id).value;
        var positionId = document.getElementById ('position_id_' + id).value;
        var url = '&playerId='+ id +'&playerNumber=' + playerNumber + '&firstName=' + firstName + '&lastName=' + lastName + '&birthdate=' + birthdate + '&positionId=' + positionId;
        $.ajax({
            type: "POST",
            url: 'http://localhost:8080/loputoo/tournament_settings/teams?ajaxRequest=1' + url
        });
        location.href=location.href

    }
    $("#playerUpdate").click(function() {
        alert("update");
    });
    function deletePlayer (id){
        var url = '&playerId=' + id;
        $.ajax({
            type: "POST",
            url: 'http://localhost:8080/loputoo/tournament_settings/teams?delete=1' + url
        });
        location.href=location.href
    }
</script>
<?php include_once 'C:/xampp7/htdocs/loputoo/footer.php'; ?>

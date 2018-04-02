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
if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$id = (int)$_GET['id'];

$result = $mysql->query('SELECT DISTINCT user_id FROM tournaments
                          WHERE id = "' . $id . '";');

$sql = $mysql->query('SELECT tt.id, tt.logo_url, tt.team_name, tit.class_id, tit.team_id, c.class_name, c.id as c_id FROM teams_in_tournaments as tit 
                                          LEFT JOIN teams_tournament as tt ON tit.team_id = tt.id
                                          LEFT JOIN classes as c ON tit.class_id = c.id 
                                          WHERE tit.tournament_id = "'.$id.'" ORDER BY c.id');
while ($row = $result->fetch_assoc()){
    if($user->is_logged_in() && $row['user_id'] == $userId ) {
?>
<div class="col-sm-12 col-xs-12" style="background-color: white;">
    <div class="col-sm-3 col-xs-12">
        <?php include_once 'sideMenu.php'?>
    </div>
    <div class="col-sm-9 col-xs-12">
        <h2>Teams</h2>
        <hr>
        <?php
        while ($row = $sql->fetch_assoc()) { ?>
            <div class="tournament_teams" style="margin-left:30px;">
            <?php $logo = 'c:/xampp7/htdocs/loputoo/images/team_logos/'. $row['logo_url'];
            if ($row['logo_url'] != '' && file_exists($logo)) {?>
            <span><img style="max-width:50px; max-height:50px; margin-right:8px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/<?php echo $row['logo_url']?>"></span>
        <?php }
    else { ?> <span><img style="max-width:50px; max-height:50px; margin-right:8px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/default-logo.png"></span>
        <?php } ?>
                <span style="font-size: 1.5em; margin-bottom:20px;"><a style="color:black;" href="http://localhost:8080/loputoo/tournament_settings/teams/?id=<?php echo $id;?>&teamId=<?php echo $row['id'];?>&classId=<?php echo $row['c_id'];?>"><?php echo $row['team_name'].' ('. $row['class_name'] . ')' ?></a></span> <br/>
            </div>
        <?php } ?>
    </div>
</div>
    <?php } else {} }?>        
<div class="container">
</div>
<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>
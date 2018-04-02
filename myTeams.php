<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'db.php';
include_once 'header.php';
if($user->is_logged_in()) {
    $result = $mysql->query("SELECT memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$sql = $mysql->query('SELECT * FROM classes');?>

<body style="font-family: 'Lato', sans-serif;">
<div class="container">
    <div class="row">
        <div class="col-sm-6 table-cell-content-center">
            <div>
                <a href="http://localhost:8080/loputoo/" title="Trniir" rel="home">
                    <img class="img-responsive center-block" src="http://localhost:8080/loputoo/images/logos/turniir_new_0.png" alt="Trniir">
                </a>
            </div>
        </div>
        <div class="col-sm-6">
            <h3 class="to-upper"><a href="http://localhost:8080/loputoo/create.php">Create new tournament</a></h3>
        </div>
        <div style="font-size:2.0em;border-bottom:12px solid;border-top:3px solid #FDAC43;clear:both;"></div>
    </div>
    <div class="accountTournaments">
        <h3>My teams:</h3>
        <?php while ($row = $sql->fetch_assoc()) {

            $classId = $row['id'];
            $className = $row['class_name'];
        }?>
                <hr>
                <?php
                $result = $mysql->query('SELECT t.name, t.id as tournamentId, t.start_date,  tt.id as t_id, tt.logo_url, tt.team_name, tit.class_id, tit.team_id, c.class_name, c.id as c_id FROM teams_tournament as tt
                        LEFT JOIN teams_in_tournaments as tit ON tt.id = tit.team_id
                        LEFT JOIN classes as c ON tit.class_id = c.id
                        LEFT JOIN tournaments as t ON tit.tournament_id = t.id
                        WHERE tt.manager_id = "'.$userId.'"');?>
                <?php while ($row = $result->fetch_assoc()){
                    if ($row['team_id'] == $row['t_id']) {
                    ?>
                <h3><?php echo $row['name'] . ' ('. $row['class_name'] . ')' . ' - ' . $row['start_date'];?></h3>
                <?php
                    $logo = 'c:/xampp7/htdocs/loputoo/images/team_logos/'. $row['logo_url'];
                    if ($row['logo_url'] != '' && file_exists($logo)) {?>
                        <span><img style="max-width:50px; max-height:50px; margin-right:8px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/<?php echo $row['logo_url']?>"></span>
                    <?php }
                    else { ?> <span><img style="max-width:50px; max-height:50px; margin-right:8px; margin-bottom:15px;" src="http://localhost:8080/loputoo/images/team_logos/default-logo.png"></span>
                    <?php } ?>
                    <span style="font-size: 1.5em; margin-bottom:20px;">
                            <a style="color:black;" href="http://localhost:8080/loputoo/tournament_teams/teams/?id=<?php echo $row['tournamentId'];?>&teamId=<?php echo $row['t_id'];?>&classId=<?php echo $row['c_id'];?>"><?php echo $row['team_name']?></a></span><br/>
        <?php } else { }}?>

    </div>
</div>
<?php include_once 'footer.php'; ?>
</body>
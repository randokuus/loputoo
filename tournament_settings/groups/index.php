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
$groupId = (int)$_GET['groupId'];
$tournamentId = (int)$_GET['id'];

if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$result = $mysql->query('SELECT DISTINCT user_id FROM tournaments
                          WHERE id = "' . $tournamentId . '";');
while ($row = $result->fetch_assoc()){
if($user->is_logged_in() && $row['user_id'] == $userId ) {
?>
<div class="col-sm-12" style="background-color: white;">
    <div class="col-sm-3">
        <?php include_once 'C:/xampp7/htdocs/loputoo/tournament_settings/sideMenu.php'?>
    </div>
    <div class="col-sm-9">
        <?php $result = $mysql->query('SELECT DISTINCT * FROM groups WHERE id = "'.$groupId.'"');
        while ($row = $result->fetch_assoc()){?>
        <h3>Manage group <span class="to-upper"><?php echo $row['name'];?></span></h3>
            <table id="group-content" class="table table-bordered table-sm table-hover">
                <thead class="tournament-custom">
                <tr>
                    <td class="bold" colspan="3"></td>
                    <td class="table-cell-content-center">W</td>
                    <td class="table-cell-content-center">D</td>
                    <td class="table-cell-content-center">L</td>
                    <td class="table-cell-content-center">+/-</td>
                    <td class="table-cell-content-center">P</td>
                </tr>
                </thead>
                <tbody class="group-table-body">
                <tr class="group-team-row ">
                    <td class="table-cell-content-center js-team-position team-position">1.</td>
                    <td colspan="2" class="table-cell-content">
                                    <span class="group-team-logo-container">
                        <img style="max-height: 40px; width: auto;" class="group-team-logo" src="">
                    </span>
                        <a data-page="" data-id="" class="team-link" target="_blank">Add team 1</a>
                    </td>
                    <td class="table-cell-content-center">0</td>
                    <td class="table-cell-content-center">0</td>
                    <td class="table-cell-content-center">0</td>
                    <td class="table-cell-content-center">0</td>
                    <td class="table-cell-content-center">0</td>
                </tr>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
    <?php } else {} }?>
<div class="container">
</div>
<?php include_once 'C:/xampp7/htdocs/loputoo/footer.php'; ?>

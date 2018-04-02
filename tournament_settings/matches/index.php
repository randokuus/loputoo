<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'C:/xampp7/htdocs/loputoo/db.php';
include_once 'C:/xampp7/htdocs/loputoo/header.php';
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
        <?php include_once 'C:/xampp7/htdocs/loputoo/tournament_settings/sideMenu.php'?>
    </div>
    <div class="col-sm-9">
        <form id="match-form" data-match-id="" class="form-horizontal match-form">
            <div class="form-group">
                <label class="col-sm-4 control-label">Match is finished:</label>
                <div class="col-sm-8">
                    <input class="form-control" name="is_finished" type="checkbox" value="1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Home score:</label>
                <div class="col-sm-8">
                    <input class="form-control js-home-team-score" name="team_score_home" type="number" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Away score:</label>
                <div class="col-sm-8">
                    <input class="form-control js-away-team-score" name="team_score_away" type="number" value="">
                </div>
            </div>
            <div class="tournament-class-selector-wrapper">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Class:</label>
                    <div class="col-sm-8">
                        <select name="class_id" class="form-control js-match-class-selector">
                            <option selected="" value="661">2009 a poisid</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="group-selector-wrapper">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Group:</label>
                    <div class="col-sm-8">
                        <select name="group_id" class="form-control js-match-group-selector">
                            <option value="0">Pick a group</option>
                            <option value="1843">A</option>
                            <option value="1856"></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="teams-selector-wrapper">
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Match number:</label>
                <div class="col-sm-8">
                    <input class="form-control js-match-number" name="match_nr" type="number" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Match date:</label>
                <div class="col-sm-8">
                    <input class="form-control date-picker hasDatepicker" name="match_date" type="text" value="26-03-2018" id="dp1522075325795">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Match time:</label>
                <div class="col-sm-8">
                    <input placeholder="hh:mm:ss" class="form-control" name="match_time" type="text" value="17:00:00">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Home is forfeited:</label>
                <div class="col-sm-8">
                    <input class="form-control" name="home_forfeited" type="checkbox" value="1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Away is forfeited:</label>
                <div class="col-sm-8">
                    <input class="form-control" name="away_forfeited" type="checkbox" value="1">
                </div>
            </div>
            <div>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary js-save-match-data">
                        Save                    </button>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
<?php } else {} }?>
<div class="container">
</div>
<?php include_once 'C:\xampp7\htdocs\loputoo\footer.php' ?>
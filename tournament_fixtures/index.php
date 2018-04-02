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
$id = (int)$_GET['id'];
?>
<div class="container" style="background-color: white;">
    <div class="col-sm-9 col-xs-12">
        <div class="fixtures">
            <h2>Fixtures</h2>
            <hr>
            <div id="games">
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
                                    <div><small><span></span><span class="match-footer-separator">-</span><span class="match-footer-class-name">2008 poisid (saaliturniir)</span></small></div>
                                </div>
                            </div>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $result = $mysql->query("SELECT DISTINCT * FROM tournament_settings WHERE tournament_id = '".$id."';");
    while ($row = $result->fetch_assoc()){
        if($row['sponsors_enabled'] == 1) {
            ?>
    <div class="col-sm-3 col-xs-12">
        <h4><div style="text-align: center">Supporters</div></h4>
        <hr>
        <a href="http://www.turniir.ee" target="_blank"><img src="http://localhost:8080/loputoo/images/logos/turniir_new_0.png" style="max-width:200px; max-height:200px;" /></a>
        <?php
        $sql = $mysql->query('SELECT * FROM sponsors WHERE tournament_id = "'.$id.'"');
        ?>
        <?php while ($row = $sql->fetch_assoc()){ ?>
            <a href="<?php echo $row['sponsor_site_url'] ?>" target="_blank"><img src="http://localhost:8080/loputoo/images/sponsorImages/<?php echo $row['sponsor_logo_url']?>" style="max-width:200px; max-height:200px; margin-top:25px;" /></a>
        <?php } ?>
    </div>
    <?php } else { } }?>
</div>
<?php include_once 'C:/xampp7/htdocs/loputoo/footer.php'; ?>

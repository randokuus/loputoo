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

$sql = $mysql->query('SELECT * FROM classes WHERE tournament_id = "'.$id.'"');?>
    <div class="container" style="background-color: white;">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="teams">
                    <?php while ($row = $sql->fetch_assoc()){
                            if($row['tournament_id'] == $id ){

                            $classId = $row['id'];
                            $className = $row['class_name'];
                            ?><h2><?php echo $className ;?></h2>
                            <hr><?php
                            $team_id = $row['id'];
                            ?> <?php
                            $result = $mysql->query('SELECT tt.id as t_id, tt.logo_url, tt.team_name, tit.class_id, tit.team_id, c.class_name, c.id as c_id FROM teams_in_tournaments as tit
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
                            <a style="color:black;" href="http://localhost:8080/loputoo/tournament_teams/teams/?id=<?php echo $id;?>&teamId=<?php echo $row['t_id'];?>&classId=<?php echo $classId;?>"><?php echo $row['team_name']?></a></span><br/>
                                <?php }
                            } else {?>
                                <p>kalake</p>
                           <?php }
                    } ?>
            </div>
        </div>
        <?php
        $result = $mysql->query("SELECT DISTINCT * FROM tournament_settings WHERE tournament_id = '".$id."';");
        while ($row = $result->fetch_assoc()){
            if($row['sponsors_enabled'] == 1) {
        ?>
            <div class=" col-md-3 col-sm-12 col-xs-12" style="text-align: center">
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
    <script type="text/javascript">
        jQuery(function ($) {
            $("#tournament_menu ul li a")
                .click(function(e) {
                    var link = $(this);

                    var item = link.parent("li");

                    if (item.hasClass("active")) {
                        item.removeClass("active").children("a").removeClass("active");
                    } else {
                        item.addClass("active").children("a").addClass("active");
                    }

                })
                .each(function() {
                    var link = $(this);
                    if (link.get(0).href === location.href) {
                        link.addClass("active").parents("li").addClass("active");
                        return false;
                    }
                });
        });
    </script>
<?php include_once 'C:/xampp7/htdocs/loputoo/footer.php'; ?>
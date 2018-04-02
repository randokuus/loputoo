<?php
/**
 * Header  for the tournament information
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 */
include_once 'db.php';
$id = (int)$_GET['id'];
if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$result = $mysql->query('SELECT t.id, t.logo, t.user_id, ts.background_color, ts.banner_path FROM tournaments as t
                        LEFT JOIN tournament_settings as ts ON t.id = ts.tournament_id
                        LEFT JOIN members as m ON t.user_id = m.memberID
WHERE id = "' . $id . '";');

?>
<?php while ($row = $result->fetch_assoc()){?>
<style>
    #tournament_menu ul li.active {
        background-color: <?php echo $row['background_color'];?> !important;
    }
</style>
<body style="background-color: <?php echo $row['background_color'];?>; font-family: 'Lato', sans-serif;">
<div class="header" style="background-color: <?php echo $row['background_color'];?>;">
    <div class="container" style="padding:0px;">
        <div class="col-sm-12" style="padding:0px;">
            <?php
            $logo = 'c:/xampp7/htdocs/loputoo/images/tournament_banners/'. $row['banner_path'];
            if ($row['banner_path'] != '' && file_exists($logo)) {?>
                <img class="tournament_banner" src="http://localhost:8080/loputoo/images/tournament_banners/<?php echo $row['banner_path'];?>"/>
            <?php }
            else { ?>
            <?php } ?>
            <?php
            if ($row['banner_path'] != '') {
            $logo2 = 'c:/xampp7/htdocs/loputoo/images/logos/'. $row['logo'];
            if ($row['logo'] != '' && file_exists($logo2)) {?>
                <a href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id'];?>"><img class="img-responsive center-block max-height trn_logo" style="width:15%" src="http://localhost:8080/loputoo/images/logos/<?php echo $row['logo']; ?>" alt="Home"></a>
            <?php }
            else { ?> <a href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id'];?>"><img class="img-responsive center-block max-height trn_logo" style="max-width:170px; max-height:140px; margin-top:25px;" src="http://localhost:8080/loputoo/images/logos/turniir_new_0.png" alt="Home"><a>
            <?php } } else {
                $logo2 = 'c:/xampp7/htdocs/loputoo/images/logos/'. $row['logo'];
                if ($row['logo'] != '' && file_exists($logo2)) {?>
                    <a href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id'];?>"><img class="img-responsive center-block max-height trn_logo2" style="width:15%" src="http://localhost:8080/loputoo/images/logos/<?php echo $row['logo']; ?>" alt="Home"></a>
            <?php }
            else { ?> <a href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id'];?>"><img class="img-responsive center-block max-height trn_logo2" style="max-width:170px; max-height:140px; margin-top:25px;" src="http://localhost:8080/loputoo/images/logos/turniir_new_0.png" alt="Home"></a>
            <?php } }?>
            <nav class="navbar navbar-default tournament_menu" style=" background-color: rgba(255,255,255,0.8); width:100%; margin-top:-55px; font-size: 1.5em;">
                <ul class="nav nav-pills nav-justified navmenu">
                    <li><a href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id'];?>">Home</a></li>
                    <li><a href="http://localhost:8080/loputoo/tournament_info/index.php?id=<?php echo $row['id'];?>">Info</a></li>
                    <li><a href="http://localhost:8080/loputoo/tournament_teams/index.php?id=<?php echo $row['id'];?>">Teams</a></li>
                    <li><a href="http://localhost:8080/loputoo/tournament_fixtures/index.php?id=<?php echo $row['id'];?>">Fixtures/results</a></li>
                    <!--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle menu" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Fixtures/results
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="http://localhost:8080/loputoo/tournament_fixtures?id=<?php echo $row['id'];?>">All fixtures/results</a>
                            <a class="dropdown-item" href="#">2008 (poisid)</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">2006 (poisid)</a>
                        </div>
                    </li>-->
                    <li><a href="http://localhost:8080/loputoo/tournament_registration.php?id=<?php echo $row['id'];?>">Registration</a></li>
                    <?php
                    if($user->is_logged_in() && $row['user_id'] == $userId ){ ?>
                        <li><a href="http://localhost:8080/loputoo/tournament_settings/general.php?id=<?php echo $row['id'];?>">Settings</a></li>
                    <?php } else { }?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php }?>
<script type="text/javascript">
    jQuery(function ($) {
        $(".tournament_menu ul li a")
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

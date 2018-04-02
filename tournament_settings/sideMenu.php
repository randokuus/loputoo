<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'C:/xampp7/htdocs/loputoo/db.php';

$id = (int)$_GET['id'];
?>
<h1>Settings</h1>

<div class="vertical-menu">
    <a href="http://localhost:8080/loputoo/tournament_settings/general.php?id=<?php echo $id;?>">General</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/design.php?id=<?php echo $id;?>">Design</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/teams.php?id=<?php echo $id;?>">Teams</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/classes.php?id=<?php echo $id;?>">Classes</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/groups.php?id=<?php echo $id;?>">Groups</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/matches.php?id=<?php echo $id;?>">Matches</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/sponsors.php?id=<?php echo $id;?>">Sponsors</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/venue.php?id=<?php echo $id;?>">Venues</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/accommodation.php?id=<?php echo $id;?>">Accommodation</a>
    <a href="http://localhost:8080/loputoo/tournament_settings/leisure.php?id=<?php echo $id;?>">Leisure</a>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        $(".vertical-menu a")
            .click(function(e) {
                var link = $(this);

                var item = link.parent("div");

                if (item.hasClass("active")) {
                    item.removeClass("active").children("a").removeClass("active");
                } else {
                    item.addClass("active").children("a").addClass("active");
                }

            })
            .each(function() {
                var link = $(this);
                if (link.get(0).href === location.href) {
                    link.addClass("active").parents("div").addClass("active");
                    return false;
                }
            });
    });
</script>

<?php
/**
 * Header  for the tournament information
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 */
include_once 'db.php';
$id = (int)$_GET['id'];
$result = $mysql->query('SELECT t.id, ts.background_color, ts.banner_path FROM tournaments as t
                        LEFT JOIN tournament_settings as ts ON t.id = ts.tournament_id
WHERE id = "' . $id . '";');

?>
<?php while ($row = $result->fetch_assoc()){?>
<body style="background-color: <?php echo $row['background_color'];?>; font-family: 'Lato', sans-serif;">
<div class="header" style="height:0px;">
    <div class="container">
        <div class="col-sm-12">
            <nav class="navbar navbar-default tournament_menu" style="width:100%; margin-left:-30px; font-size: 1.5em;">
                <ul class="nav nav-pills nav-justified">
                    <li><a class="menu "  href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id'];?>">Home</a></li>
                    <li><a class="menu" href="http://localhost:8080/loputoo/tournament_info?id=<?php echo $row['id'];?>">Info</a></li>
                    <li><a class="menu" href="http://localhost:8080/loputoo/tournament_teams?id=<?php echo $row['id'];?>">Teams</a></li>
                    <li><a class="menu" href="http://localhost:8080/loputoo/tournament_fixtures?id=<?php echo $row['id'];?>">Fixtures/results</a></li>
                    <li><a class="menu" href="http://localhost:8080/loputoo/tournament_registration.php?id=<?php echo $row['id'];?>">Registration</a></li>
                    <li class="active"><a class="menu" href="http://localhost:8080/loputoo/tournament_settings/general.php?id=<?php echo $row['id'];?>">Settings</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php }?>
<script type="text/javascript">
    jQuery(function ($) {
        $("#tournament_menu ul li a")
            .click(function(e) {
                var link = $(this);

                var item = link.parent("li");

                if (item.hasClass("active")) {
                    item.removeClass("active").children("li").removeClass("active");
                } else {
                    item.addClass("active").children("li").addClass("active");
                }

                if (item.children("ul").length > 0) {
                    var href = link.attr("href");
                    link.attr("href", "#");
                    setTimeout(function () {
                        link.attr("href", href);
                    }, 300);
                    e.preventDefault();
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

<?php
/**
 * Header  for the turniir
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 */
require('C:/xampp7/htdocs/loputoo/loginandregister/includes/config.php');
$id = (int)$_GET['id'];
if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$sql = $mysql->query('SELECT DISTINCT user_id FROM tournaments
                          WHERE id = "' . $id . '";');

$result = $mysql->query('SELECT background_color FROM tournament_settings 
WHERE tournament_id = "' . $id . '";');
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:8080/loputoo/styles.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
</head>
<div class="mobile_header">
    <div class="container">
        <div class="main_menu">
            <div class="col-sm-12" style="margin: 20px 0;">
                <ul>
                    <li><a href="http://localhost:8080/loputoo/search.php">Search</a></li>
                    <li><a href="http://localhost:8080/loputoo/tournament.php">Tournaments</a></li>
                    <li><a href="http://localhost:8080/loputoo/create.php">Create New</a></li>
                    <?php if(!$user->is_logged_in()){ ?>
                        <li><a href="http://localhost:8080/loputoo/loginandregister/login.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-log-in orange"></span>Login</a></li>
                        <li><a href="http://localhost:8080/loputoo/loginandregister/"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-user orange"></span>Sign Up</a></li>
                    <?php } else {?>
                        <li><a href="http://localhost:8080/loputoo/myAccount.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-user orange"></span>My Account (<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?>)</a></li>
                        <li><a href="http://localhost:8080/loputoo/myTeams.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-th orange"></span>My Teams</a></li>
                        <li><a href="http://localhost:8080/loputoo/loginandregister/logout.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-log-out orange"></span>Logout</a></li>
                    <?php } ?>
                    <li><a href="http://localhost:8080/loputoo"><img style="margin-top: -3px;" src="http://localhost:8080/loputoo/images/logos/trniir_logo_small.png"</a>
                    <li></li>
                    <li><a style="padding-top:2px;" target="_blank" href="https://facebook.com/turniir"><img src="http://localhost:8080/loputoo/images/facebook_blue.png" /></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="burgermenu" style="height:0px;">
    <button class="burgermenu1">
        <?php while ($row = $result->fetch_assoc()){?>
        <div class="burx" style="background-color: <?php echo $row['background_color'];?>;"></div>
        <div class="burx" style="background-color: <?php echo $row['background_color'];?>;"></div>
        <div class="burx1" style="background-color: <?php echo $row['background_color'];?>;"></div>
        <?php } ?>
        <div style="font-size:0.8em; margin-bottom:3px;">Menu<div>
    </button>
    <div class="dropdown-burger">
        <ul>
            <li><a href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $id;?>">Home</a></li>
            <li><a href="http://localhost:8080/loputoo/tournament_info?id=<?php echo $id;?>">Info</a></li>
            <li><a href="http://localhost:8080/loputoo/tournament_teams?id=<?php echo $id;?>">Teams</a></li>
            <li><a href="http://localhost:8080/loputoo/tournament_fixtures?id=<?php echo $id;?>">Fixtures/results</a></li>
            <li><a href="http://localhost:8080/loputoo/tournament_registration.php?id=<?php echo $id;?>">Registration</a></li>
            <?php
            while ($row = $sql->fetch_assoc()){
            if($user->is_logged_in() && $row['user_id'] == $userId ){ ?>
                <li><a class="menu" href="http://localhost:8080/loputoo/tournament_settings/general.php?id=<?php echo $id;?>">Settings</a></li>
            <?php } else { } }?>
        </ul>
        <ul style="color:lightgrey;">
            <li><a href="http://localhost:8080/loputoo/search.php">Search</a></li>
            <li><a href="http://localhost:8080/loputoo/tournament.php">Tournaments</a></li>
            <li><a href="http://localhost:8080/loputoo/create.php">Create New</a></li>
            <?php if(!$user->is_logged_in()){ ?>
                <li><a href="http://localhost:8080/loputoo/loginandregister/login.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-log-in orange"></span>Login</a></li>
                <li><a href="http://localhost:8080/loputoo/loginandregister/"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-user orange"></span>Sign Up</a></li>
            <?php } else {?>
                <li><a href="http://localhost:8080/loputoo/myAccount.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-user orange"></span>My Account (<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?>)</a></li>
                <li><a href="http://localhost:8080/loputoo/myTeams.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-th orange"></span>My Teams</a></li>
                <li><a href="http://localhost:8080/loputoo/loginandregister/logout.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-log-out orange"></span>Logout</a></li>
            <?php } ?>
            <li><a href="http://localhost:8080/loputoo"><img style="margin-top: -3px;" src="http://localhost:8080/loputoo/images/logos/trniir_logo_small.png"</a>
            <li></li>
            <li><a style="padding-top:2px;" target="_blank" href="https://facebook.com/turniir"><img src="http://localhost:8080/loputoo/images/facebook_blue.png" /></a></li>
        </ul>
    </div>
</div>


<script>
    (function($){
        $(".burgermenu1").click(function(){
            //$(".dropdown-burger").hide();
            $(this).next("div").toggle();
        })
    })(jQuery);
</script>
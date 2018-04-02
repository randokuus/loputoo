<?php require('includes/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }
//include header template
require('layout/header.php');
?>
    <div class="header">
        <div class="container">
            <div class="main_menu">
                <div class="col-sm-6" style="margin: 20px 0;">
                    <ul>
                        <li><a href="http://localhost:8080/loputoo/search.php">Search</a></li>
                        <li><a href="http://localhost:8080/loputoo/tournament.php">Tournaments</a></li>
                        <li><a href="http://localhost:8080/loputoo/create.php">Create New</a></li>
                    </ul>
                </div>
                <div class="col-sm-6" style="margin: 20px 0;">
                    <ul>
                        <li><a href="#"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-user orange"></span>My Account (<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?>)</a></li>
                        <li><a href="logout.php"><span style="color:orange; margin-right: 3px;" class="glyphicon glyphicon-log-out orange"></span>Logout</a></li>
                        <li><a href="http://localhost:8080/loputoo"><img style="margin-top: -3px;" src="http://localhost:8080/loputoo/images/logos/trniir_logo_small.png"</a>
                        <li></li>
                        <li><a style="padding-top:2px;" target="_blank" href="https://facebook.com/turniir"><img src="http://localhost:8080/loputoo/images/facebook_blue.png" /></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="row">

            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <h2>Member only page - Welcome <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></h2>
                <hr>

            </div>
        </div>


    </div>

<?php
//include header template
require('layout/footer.php');
?>
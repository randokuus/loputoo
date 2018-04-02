<?php
ob_start();
session_start();
//set timezone
date_default_timezone_set('Europe/Tallinn');
//database credentials
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','turniir');
//application address
define('DIR','http://localhost:8080/loputoo/');
define('SITEEMAIL','loputoovikk@gmail.com');
try {
    //create PDO connection
    $db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    //show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}
//include the user class, pass in the database connection
include('C:/xampp7/htdocs/loputoo/loginandregister/classes/user.php');
include('C:/xampp7/htdocs/loputoo/loginandregister/classes/phpmailer/mail.php');
$user = new User($db);
?>
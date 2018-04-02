<?php
$host = 'localhost';
$db = 'turniir';
$user = 'root';
$password = '';
// mysqli_connect(host,username,password,database);
$mysql = mysqli_connect($host,$user,$password,$db);
if(!$mysql){
    die('Andmebaasi ühendus ei toimi');
}
//mysqli_set_charset($mysql,'utf8');
if(!$mysql->set_charset('utf8')){
    echo 'Error - utf8 rakendamine ebaõnnestus';
    exit();
}
?>
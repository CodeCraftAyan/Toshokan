<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "toshokan";

$connect = mysqli_connect($server, $user, $pass, $db);

if(!$connect){
    die("Connection Error :  ". mysqli_connect_error());
}

?>
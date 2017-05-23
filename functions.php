<?php

require("../../../config.php");
//functions.php

$database = "if16_Aaviste_praktika";
$mysqli = new mysqli( $serverHost, $serverUsername, $serverPassword, $database);
mysqli_set_charset($mysqli, "utf8");

require("class/vari.class.php");
$Vari = new Vari($mysqli);

require("class/tudeng.class.php");
$Tudeng = new Tudeng($mysqli);

require("class/admin.class.php");
$Admin = new Admin($mysqli);

require("class/pair.class.php");
$Pair = new Pair($mysqli);

require("class/helper.class.php");
$Helper = new Helper($mysqli);

$password=$mailPassword;

//alustan sessiooni
//$_SESSION muutujad
session_start();

?>
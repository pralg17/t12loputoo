<?php

	require("/home/ingomagi/config.php");
	$database = "if16_veinipood";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	session_start();
	
	require("../Class/Helper.class.php");
	$Helper = new Helper();
	
		
	
	
?>
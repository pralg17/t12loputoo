<?php
	
	require("/home/karojyrg/config.php");

	/* ALUSTAN SESSIOONI */
	session_start();
		
	/* ÜHENDUS */
	$database = "if16_karojyrg_2";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
	/* KLASSID */
	
	require("class/Helper.class.php");
	$Helper = new Helper();

?>
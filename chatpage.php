<?php

	//FUNKTSIOONID
	require("function.php");
	
	//LOG OUT
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}

?>

<html>
blabla
<a href="?logout=1">LOGI VÄLJA</a>
</html>
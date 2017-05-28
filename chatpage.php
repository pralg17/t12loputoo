<?php

	//FUNKTSIOONID
	require("function.php");
	
	//LOG OUT
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	//POSTITUSE LOOMINE
	if (isset($_POST["Pealkiri"])&&
		isset($_POST["Kommentaar"]) &&
		isset($_POST["Kategooria"]) &&
		!empty($_POST["Pealkiri"])&&
		!empty($_POST["Kommentaar"])&&
		!empty($_POST["Kategooria"])
		)
	{
	postitus($_POST["Pealkiri"],$_POST["Kommentaar"], $_POST["Kategooria"], $_SESSION["userKasutaja"]);
	}
	
	$people = kasutajainfo();
?>

<html>

	<head>
	<title>Forum page</title>
	
		<style>		
		</style>
	
	</head>

	<body>
		
		<div class="Loo uue postituse">
			<form method="POST" >
		
				<br><label for="Pealkiri">Pealkiri</label></br>
				<input name="Pealkiri" type ="text" placeholder="Postituse pealkiri"><br>
				
				<br><label for="Kommentaar">Kommentaar</label></br>
				<input name="Kommentaar" type ="text" placeholder="Postituse Kommentaar"><br>
				
				<p><label for="Kategooria">Vali kategooria:</label><br>
					<select name = "Kategooria"  id="Kategooria" required><br><br>
					<option value="">Vali kategooria:</option>
					<option value="PC games">PC games</option>
					<option value="Xbox games">Xbox games</option>
					<option value="Nintendo games">Nintendo games</option>
					<option value="PlayStation games">PlayStation games</option>
					<option value="Mobile gamess">Mobile games</option>
				</select><br><br>
		
				<input type="submit" value="Loo uue postituse">
				
			</form>
		</div>
	
		<a href="?logout=1">LOGI VÄLJA</a>
		<a href="user_info.php">Minu andmed</a>
		
	</body>
</html>
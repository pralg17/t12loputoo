<?php
	//edit.php
	require("functions.php");
	require("editFunctions.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updateMovie(cleanInput($_POST["id"]), $_POST["rent"]);
		
	header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
					
	}
	
	elseif(isset($_POST["delete"])){
		deleteMovie ($_POST["id"]);
		header("Location: edit.php");
		exit();
	}
	
	// kui ei ole id'd siis suunan tagasi data.php lehele
	if(!isset($_GET["id"])){
		header("Location: data.php");
		exit();
	}
	
	//saadan kaasa id
	$s = getSingleMovieData($_GET["id"]);
	//var_dump($s);
	
	//hetek kuupäev
	$timezone = "Europe/Tallinn";
	date_default_timezone_set($timezone);
	$today = date("Y-m-d");

?>
<br><br>
<a href="data.php"> tagasi </a>

<h2>Filmi andmed</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<h3> <?=$s->title;?> </h3>
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" >
	<body> Kestvus: <?=$s->runtime;?> min </body><br>
	<body> Rendi hind: <?=$s->price;?> &euro; </body><br>
  	<br>
	<label for="rent" >Rendi film</label><br>
	<!--<input id="rent" name="rent" type="date" value=""<?=$today;?>""><br><br>-->
	<input type="date" name="rent" id="rent" value="<?=$today;?>">
  	
	<input type="submit" name="update" value="Salvesta"><br><br>
	<input type="submit" name="delete" value="Kustuta">
  </form>
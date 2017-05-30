<?php

	if (isset($_GET["logout"])) {	
		session_destroy();
		header("Location: data.php");
		exit();
	}

	/*if(!isset($_GET["id"])){
		header("Location: login.php");
		exit();
	}*/

	require("functions.php");
	$movieError = "";

	if(isset($_POST["title"]) &&
		isset($_POST["runtime"]) &&
		isset($_POST["price"]) 
	) {
		if(!empty($_POST["title"]) &&
		!empty($_POST["runtime"]) &&
		!empty($_POST["price"])){
			saveMovies( cleanInput($_POST["title"]), cleanInput($_POST["runtime"]), cleanInput($_POST["price"]));

		}else{
			$movieError = "Palun täida kõik väljad!";
		}
	}
		
	
	//sorteerimine
	if(isset($_GET["sort"]) && isset($_GET["direction"])){
		$sort = $_GET["sort"];
		$direction = $_GET["direction"];
	}else{
		//kui ei ole määratud siis vaikimisi id ja ASC
		$sort = "id";
		$direction = "ascending";
	}
	
	//kas otsib
	if(isset($_GET["q"])){
	
		$q = cleanInput($_GET["q"]);
	
		$movieData = getAllMovies($q, $sort, $direction);
	
	} else {
		$q = "";
		$movieData = getAllMovies($q, $sort, $direction);
		
	}
		
		if(!isset($_GET["all"])){
			getMovies ($_GET[""]);
						
		}else {
			$all = "";
			$movieData = getMovies($all);			
		}
?>

<h1>Tere tulemast Filmirenti!</h1>

<a href="login.php"> Logi sisse </a>
<!--<a href="?logout=1">Logout</a>-->

<h2>Sisesta film</h2>
<p style="color:red;"><?=$movieError;?></p>

<form method="POST">
<br>
	<label>Filmi nimi<label>
	<input name="title" type="text"> 
	<br><br>
	<label>Filmi kestus<label>
	<input name="runtime" type="text">
	<br><br>
	<label>Filmi hind<label>
	<input name="price" type="text">
	<br><br>
		
		<input type="submit" value="Sisesta">
</form>		

<h2>Saadaval olevad filmid</h2>

	<form>
			<input type="search" name="q" value="<?=$q;?>">
			<input type="submit" value="Otsi">
			<input type="submit" name="all" value="Kõik filmid">
	</form>

<?php
	
	
	$direction = "ascending";
	if (isset($_GET["direction"])){
		if($_GET["direction"] == "ascending"){
			$direction = "descending";
		}
	}
	
	$html = "<table border ='1'>";
	
	$html .= "<tr>";
		/* $html .= "<th>
					<a href='?q=".$q."&sort=id&direction=".$direction."'>
						id
					</a>
				</th>"; */
		$html .= "<th>
					<a href='?q=".$q."&sort=title&direction=".$direction."'>
						Film
					</a>
				</th>";
		/* $html .= "<th>
					<a href='?q=".$q."&sort=runtime&direction=".$direction."'>
						Kestvus(min)
					</a>
				</th>";
		$html .= "<th>
					<a href='?q=".$q."&sort=price&direction=".$direction."'>
						Rendi hind(&euro;)
					</a>
				</th>"; */
		$html .= "<th>
					<a href='?q=".$q."&sort=rent&direction=".$direction."'>
						Väljarenditud kuni:
					</a>
				</th>";
	$html .= "</tr>";
	
	//iga liikme kohta masiivis
	foreach($movieData as $s) {
		
		$html .= "<tr>";
			//$html .= "<td>".$s->id."</td>";
			$html .= "<td>".$s->title."</td>";
			//$html .= "<td>".$s->runtime."</td>";
			//$html .= "<td>".$s->price."</td>";
			$html .= "<td>".$s->rent."</td>";
			$html .= "<td><a href='edit.php?id=".$s->id."'>Vaata/Rendi</a></td>";
		$html .= "</tr>";
	}
	$html .= "</table>";
	

	
	echo $html;
?>

<!--function getMovies($id){

	$database = "if16_johan_kodused";

	$mysqli = new mysql($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

	$stmt = $mysqli->prepare("SELECT title, rent FROM movies");

	$stmt->bind_param("i", $id);
	}-->
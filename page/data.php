<?php

	require("../functions.php");

	require("../class/Flower.class.php");
	$Flower = new Flower($mysqli);

	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){

		//suunan sisselogimise lehele
		header("Location: login.php");
		exit();
	}

	if (isset($_GET["logout"])) {

		session_destroy();
		header("Location: login.php");
		exit();
	}

	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];

		unset($_SESSION["message"]);
	}


	if ( isset($_POST["flower"]) &&
		isset($_POST["flower"]) &&
		!empty($_POST["color"]) &&
		!empty($_POST["color"])
	  ) {

		$Flower->save($Helper->cleanInput($_POST["flower"]), $Helper->cleanInput($_POST["color"]));

	}

	// sorteerib
	if(isset($_GET["sort"]) && isset($_GET["direction"])){
		$sort = $_GET["sort"];
		$direction = $_GET["direction"];
	}else{
		// kui ei ole määratud siis vaikimis id ja ASC
		$sort = "id";
		$direction = "ascending";
	}

	//kas otsib
	if(isset($_GET["q"])){

		$q = $Helper->cleanInput($_GET["q"]);

		$flowerData = $Flower->get($q, $sort, $direction);

	} else {
		$q = "";
		$flowerData = $Flower->get($q, $sort, $direction);

	}
?>
<?php require("../header.php"); ?>

<div class="container">

	<?=$msg;?>
	<p>
		Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?>!</a>
		<a href="?logout=1">Logi välja</a>
	</p>


	<h2>Salvesta lill</h2>
	<form method="POST">

		<label>Lille nimi</label><br>
		<input name="flower" type="text">
		<br><br>

		<label>Lille värv</label><br>
		<input type="color" name="color" >
		<br><br>

		<input type="submit" value="Salvesta">
	</form>

	<h2>Lilled</h2>

	<form>
		<input type="search" name="q" value="<?=$q;?>">
		<input type="submit" value="Otsi">
	</form>

	<?php

		$direction = "ascending";
		if (isset($_GET["direction"])){
			if ($_GET["direction"] == "ascending"){
				$direction = "descending";
			}
		}

		$html = "<table class='table table-striped table-bordered'>";

		$html .= "<tr>";
			$html .= "<th>
						<a href='?q=".$q."&sort=id&direction=".$direction."'>
							id
						</a>
					</th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=flower&direction=".$direction."'>
							flower
						</a>
					</th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=color&direction=".$direction."'>
							color
						</a>
					</th>";
		$html .= "</tr>";

		//iga liikme kohta massiivis
		foreach($flowerData as $c){

			$html .= "<tr>";
				$html .= "<td>".$c->id."</td>";
				$html .= "<td>".$c->flower."</td>";
				$html .= "<td style='background-color:".$c->flowerColor."'>".$c->flowerColor."</td>";
				$html .= "<td>
							<a href='edit.php?id=".$c->id."' class='btn btn-default'>

								<span class='glyphicon glyphicon-pencil'></span>
								Muuda

							</a>
						</td>";

			$html .= "</tr>";
		}

		$html .= "</table>";

		echo $html;
	?>

	<br>
	<br>
	<br>
	<br>
	<br>
</div>
<?php require("../footer.php"); ?>

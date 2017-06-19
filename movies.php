<?php

	require("../../config.php");
	require("functions.php");

	if(!isset($_SESSION["userId"])){
		

		header("Location: loginpb.php");
		
	}



	if(isset($_GET["logout"])){
		
		session_destroy();
		header("Location:loginpb.php");
		
	}
	
	$user=$_SESSION["userEmail"];
	if(isset($_POST["nimi"]) && 
		isset($_POST["staatus"]) &&
		isset($_POST["kuup"]) &&
		!empty($_POST["nimi"]) && 
		!empty($_POST["staatus"]) &&
		!empty($_POST["kuup"])
		) {
		
		savecontact($_POST["nimi"], $_POST["staatus"], $_POST["kuup"], $user);
		
		
	}

	if(isset($_GET["sort"]) && isset($_GET["direction"])){
		$sort=$_GET["sort"];
		$direction=$_GET["direction"];
		
	}else{
		$sort="nimi";
		$direction="ascending";
	}
	
	
	if(isset($_GET["q"])){
		
		$q = $_GET["q"];
		
		$contactdata=getallcontacts($user, $q, $sort, $direction);
		
	}else{
		
		$q="";
		$contactdata=getallcontacts($user, $q, $sort, $direction);
		
	}
	
?>
<h1>Filmide märkmik</h1>

<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>
	<a href="?logout=1">Logi valja</a>

</p>
	<h3>Salvesta uus film</h3>
	<form method="POST">
		<label>Filmi nimi</label><br>
		<input name="nimi" type="text" placeholder=""><br><br>
	
		<label>Staatus</label><br>
		<input name="staatus" type="text" placeholder=""><br><br>
		
		<label>Kuupaev</label><br>
		<input name="kuup" type="text" placeholder="">

		<br><br>
		<input type="submit" value="Salvesta">
	</form>
	
	Vaadatud: <?php getStaatus($user); ?><br>
	
<h2>Filmid</h2>
	<form>
		<input type="search" name="q" value="<?=$q;?>">
		<input type="submit" value="Otsi"><br><br>
	</form>
<?php

	$direction="ascending";
	if(isset($_GET["direction"])){
		if($_GET["direction"] == "ascending"){
			$direction = "descending";
		}
	}

	$html = "<table border='1'>";
	
	$html .= "<tr>";
		$html .= "<th><a href='?q=".$q."&sort=nimi&direction=".$direction."'>Nimi</a></th>";
		$html .= "<th><a href='?q=".$q."&sort=staatus&direction=".$direction."'>Staatus</a></th>";
		$html .= "<th><a href='?q=".$q."&sort=kuup&direction=".$direction."'>Kuupaev</a></th>";
		$html .= "<th><a href='?q=".$q."&sort=reiting&direction=".$direction."'>Reiting</a></th>";
	$html .= "</tr>";
	
	foreach($contactdata as $c) {
		
		
		$html .= "<tr>";
			$html .= "<td>".$c->nimi."</td>";
			$html .= "<td>".$c->staatus."</td>";
			$html .= "<td>".$c->kuup."</td>";
			$html .= "<td>".$c->reiting."</td>";
			$html .= "<td><a href='edit.php?nimi=".$c->nimi."'>Muuda</a></td>";
		$html .= "</tr>";
		
	}

	$html .= "</table>";

	echo $html;


?>
		
		
		
		
		
		
		
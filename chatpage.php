<?php

	//FUNKTSIOONID
	require("function.php");
	require("style.php");
	
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
	
	//SORTIREERIMINE JA OTSING
	if (isset($_GET["q"])) {
		$q = $_GET["q"];
	
	} else {
		//otsing ei toimu
		$q = "";
	}
	//Kui midagi pole vajutatud
	$sort = "kasutaja";
	$order = "ASC";
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
	
	$postitus = postinfo($q, $sort, $order);
	$kokku = kokkupost();
?>

<html>

	<head>
	<title>Forum page</title>
	
	</head>

	<body>
		
		<center>
		
		<div class="Loo uue postituse">
			<form method="POST" >
				
				<h1>Loo uue postituse: </h1>
				<br><label for="Pealkiri">Pealkiri</label></br>
				<input name="Pealkiri" type ="text" placeholder="Postituse pealkiri" required><br>
				
				<br><label for="Kommentaar">Kommentaar</label></br>
				<input name="Kommentaar" type ="text" placeholder="Postituse Kommentaar" maxlength="50" required><br>
				
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
		<a href="user_info.php">MINU ANDMED</a>
		
		<br><br>
		
		<form>
		<input type="text" name="q" value="<?=$q;?>" placeholder="Otsi postituses">
		<input type="submit" value="Otsi postituse">
		</form>
		
<h1>Kasutaja kokku postitused: </h1>		
<?php 
$html1 = "<table>";
	
	$html1 .= "<tr>";
		$html1 .= "<th>Kasutaja</th>";
		$html1 .= "<th>Kokku</th>";
	$html1 .= "</tr>";
	
	foreach ($kokku as $p) {
	$html1 .= "<tr>";
		$html1 .= "<td>".$p->kasutaja."</td>";
		$html1 .= "<td>".$p->counting."</td>";
	$html1 .= "</tr>";
	}

	$html1 .= "</table>";
	
echo $html1
?>
		
<h1>Video-mängude foorum: </h1>
<?php 
$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>Postituse ID</th>";
		$html .= "<th>pealkiri</th>";
		$html .= "<th>komment</th>";
		$html .= "<th>kategooria</th>";
		$html .= "<th>kellaaeg</th>";
		$html .= "<th>kasutaja</th>";
		$html .= "<th></th>";
	$html .= "</tr>";
	
	foreach ($postitus as $p) {
	$html .= "<tr>";
		$html .= "<td>".$p->id."</td>";
		$html .= "<td>".$p->pealkiri."</td>";
		$html .= "<td>".$p->komment."</td>";
		$html .= "<td>".$p->kategooria."</a></td>";
		$html .= "<td>".$p->kellaaeg."</td>";
		$html .= "<td>".$p->kasutaja."</a></td>";
		$html .= "<td><a href='comment.php?id=".$p->id."'>Vasta</a></td>";
	$html .= "</tr>";
	}

	$html .= "</table>";
	
echo $html
?>

		</center>
		
	</body>
</html>
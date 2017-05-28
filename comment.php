<?php
	
	require("function.php");
	require("style.php");
	
	//SALVESTAMINE
	if (isset ($_POST["tagasiside"]) &&
		!empty ($_POST["tagasiside"])
		)
	
	//KOMMENTAARI SAAMINE
	{
	kommentaar($_POST["tagasiside"],$_SESSION["userKasutaja"],$_GET["id"]);
	}
	
	$comment = kommentaarinfo();
	
	$p = getsingleId($_GET["id"]);

?>

<html>
	
<body>	
	<center>
	
	<!--TAGASISIDE-->
	<div class="Kommentaar">
		
		<form method="POST">
		
		<input name="tagasiside" class="text" placeholder="Jäta kommentaar" maxlength="50" required>
		
		<br><input type="submit" value="Saada"></br>

		</form>
		
	</div>



<?php 
$html = "<table>";

	$html .= "<tr>";
		$html .= "<td>".$p->pealkiri."</td>";
		$html .= "<td>".$p->komment."</td>";
		$html .= "<td>".$p->kategooria."</td>";
		$html .= "<td>".$p->kellaaeg."</a></td>";
		$html .= "<td>".$p->kasutaja."</a></td>";	
	$html .= "</tr>";

$html .= "</table>";
echo $html
?>

<br><br>	
	
<?php 
$html1 = "<table>";
	foreach ($comment as $p) {
	$html1 .= "<tr>";
		$html1 .= "<td>".$p->tagasiside."</td>";
		$html1 .= "<td>".$p->kasutaja."</a></td>";
		$html1 .= "<td>".$p->kellaaeg."</a></td>";
	$html1 .= "</tr>";
	}
$html1 .= "</table>";
echo $html1
?>
	<a href="chatpage.php">GO BACK</a>
</center>
</body>
</html>
<?php
	
	require("function.php");
		
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
<a href="chatpage.php"> go back </a>
	
<body>	
	
	<!--TAGASISIDE-->
	<div class="Kommentaar">
		
		<form method="POST">
		
		<input name="tagasiside" class="text" placeholder="Jäta kommentaar">
		
		<br><input type="submit" value="Saada"></br>

		</form>
		
	</div>

</body>
</html>

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
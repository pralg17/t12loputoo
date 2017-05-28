<?php
	
	require("function.php");
	
	$p = getsingleId($_GET["id"]);

?>

<html>
<a href="chatpage.php"> go back </a>
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
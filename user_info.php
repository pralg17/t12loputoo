<?php
	
	//FUNKTSIOONID
	require("function.php");
	
	$people = kasutajainfo();
	
?>

<html>
<a href="chatpage.php"> GO BACK </a>
</html>

<?php 
$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>Kasutaja ID</th>";
		$html .= "<th>Kasutaja</th>";
		$html .= "<th>Sugu</th>";
		$html .= "<th>Kellaaeg</th>";
		$html .= "<th></th>";
	$html .= "</tr>";
	
	foreach ($people as $p) {
	$html .= "<tr>";
		$html .= "<td>".$p->id."</td>";
		$html .= "<td>".$p->kasutaja."</td>";
		$html .= "<td>".$p->sugu."</td>";
		$html .= "<td>".$p->timestamp."</a></td>";
	$html .= "</tr>";
	}

	$html .= "</table>";
	
echo $html
?>
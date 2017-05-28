<?php
	
	require("function.php");
	
	//NÄITAB ÜHE POSTITUSE KOGU INFOT
		function getsingleId2($show_id){
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("
			SELECT pealkiri, komment, kategooria
			FROM loputoo_post 
			WHERE id = ?");
			
			$stmt->bind_param("i", $show_id);
			$stmt->bind_result($pealkiri, $komment, $kategooria);
			$stmt->execute();

			$singleId = new Stdclass();
			
			if($stmt->fetch()){
				$singleId->pealkiri = $pealkiri;
				$singleId->komment = $komment;
				$singleId->kategooria = $kategooria;
			}else{
				header("Location: changepost.php");
				exit();
			}
			$stmt->close();
			return $singleId;
		}
		

	$p = getsingleId2($_GET["id"]);
?>
<h1>Muuda andmed</h1>

<?php 
$html = "<table>";

	$html .= "<tr>";
		$html .= "<td>".$p->pealkiri."</td>";
		$html .= "<td>".$p->komment."</td>";
		$html .= "<td>".$p->kategooria."</td>";
	$html .= "</tr>";

$html .= "</table>";
echo $html
?>
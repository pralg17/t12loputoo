<?php
	
	//FUNKTSIOONID
	require("function.php");
	
	//NÄITAB ÜHE KASUTAJA INFOT
	function kasutajainfo(){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT id, kasutaja, sugu
		FROM loputoo_kasutaja
		WHERE kasutaja = ?
		");
		
		$stmt->bind_param("s", $_SESSION["userKasutaja"]);
		$stmt->bind_result($id, $kasutaja, $sugu);
		$stmt->execute();
		$results = array();
		
		while ($stmt->fetch()) {
			$kasutajainf = new StdClass();
			$kasutajainf->id = $id;
			$kasutajainf->kasutaja = $kasutaja;
			$kasutajainf->sugu = $sugu;
			array_push($results, $kasutajainf);	
		}
		return $results;
	}
	
	//NÄITAB KASUTAJA KOMMENTAARID
	function kommentaaridinfo(){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT tagasiside, post_id, kellaaeg
		FROM loputoo_komment
		WHERE kasutaja = ?
		");
		
		$stmt->bind_param("s", $_SESSION["userKasutaja"]);
		$stmt->bind_result($tagasiside, $post_id, $kellaaeg);
		$stmt->execute();
		$results = array();
		
		while ($stmt->fetch()) {
			$userkomm = new StdClass();
			$userkomm->tagasiside = $tagasiside;
			$userkomm->post_id = $post_id;
			$userkomm->kellaaeg = $kellaaeg;
			array_push($results, $userkomm);	
		}
		return $results;
	}
	//NÄITAB KASUTAJA POSTITUSED
	function postituseinfo(){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		SELECT pealkiri, komment, kategooria, kellaaeg
		FROM loputoo_post
		WHERE kasutaja = ?
		");
		$stmt->bind_param("s", $_SESSION["userKasutaja"]);
		$stmt->bind_result($pealkiri, $komment, $kategooria, $kellaaeg);
		$stmt->execute();
		$results = array();
		
		while ($stmt->fetch()) {
			$postinfo = new StdClass();
			$postinfo->pealkiri = $pealkiri;
			$postinfo->komment = $komment;
			$postinfo->kategooria = $kategooria;
			$postinfo->kellaaeg = $kellaaeg;
			array_push($results, $postinfo);	
		}
		return $results;
	}
	
	
	// NÄITAB TABELS
	$people = kasutajainfo();
	$comments = kommentaaridinfo();
	$postitused = postituseinfo();
	
?>

<html>
<a href="chatpage.php"> GO BACK </a>
</html>
<h1>MINU ANDMED</h1>
<?php 
$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>Kasutaja ID</th>";
		$html .= "<th>Kasutaja</th>";
		$html .= "<th>Sugu</th>";
		$html .= "<th></th>";
	$html .= "</tr>";
	
	foreach ($people as $p) {
	$html .= "<tr>";
		$html .= "<td>".$p->id."</td>";
		$html .= "<td>".$p->kasutaja."</td>";
		$html .= "<td>".$p->sugu."</td>";
	$html .= "</tr>";
	}

	$html .= "</table>";
	
echo $html
?>
<h1>MINU KOMMENTAARID</h1>
<?php 
$html1 = "<table>";
	
	$html1 .= "<tr>";
		$html1 .= "<th>tagasiside</th>";
		$html1 .= "<th>post_id</th>";
		$html1 .= "<th>kellaaeg</th>";
		$html1 .= "<th></th>";		
	$html1 .= "</tr>";
	
	foreach ($comments as $p) {
	$html1 .= "<tr>";
		$html1 .= "<td>".$p->tagasiside."</a></td>";
		$html1 .= "<td>".$p->post_id."</a></td>";
		$html1 .= "<td>".$p->kellaaeg."</a></td>";
	}
$html1 .= "</table>";
echo $html1
?>
<h1>MINU POSTITUSED</h1>

<?php 
$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>pealkiri</th>";
		$html .= "<th>komment</th>";
		$html .= "<th>kategooria</th>";
		$html .= "<th>kellaaeg</th>";
		$html .= "<th></th>";
	$html .= "</tr>";
	
	foreach ($postitused as $p) {
	$html .= "<tr>";
		$html .= "<td>".$p->pealkiri."</td>";
		$html .= "<td>".$p->komment."</td>";
		$html .= "<td>".$p->kategooria."</td>";
		$html .= "<td>".$p->kellaaeg."</a></td>";
	$html .= "</tr>";
	}

	$html .= "</table>";
	
echo $html
?>
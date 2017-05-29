<?php	

	require("../config.php");
	session_start();
	
	$database = "if16_ksenbelo_4";
	
	//KASUTAJA REGISTEERIMINE TABELISE
		function registration($kasutaja, $parool, $sugu) {
			
			$mysqli = new mysqli($GLOBALS["serverHost"],
			$GLOBALS["serverUsername"],
			$GLOBALS["serverPassword"],
			$GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("INSERT INTO loputoo_kasutaja(kasutaja, parool,sugu) VALUE (?, ?, ?)");
			echo $mysqli->error;
			$stmt->bind_param("sss",$kasutaja, $parool, $sugu);
			
			if ( $stmt->execute() ) {
				echo "Registreeritud!";
			} else {
				echo "ERROR ".$stmt->error;
			}	
		}
	
	//LOOGIMINE SISSE
		function login($kasutaja,$parool) {
			
			$error = "";
			$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("
			SELECT id, kasutaja, parool
			FROM loputoo_kasutaja
			WHERE kasutaja = ?");
			
			echo $mysqli->error;
			
			$stmt->bind_param("s", $kasutaja);
			$stmt->bind_result($id, $kasutajaFromDb, $paroolFromDb);
			$stmt->execute();
			
			if($stmt->fetch()) {
				$hash = hash("sha512", $parool);
			
			if ($hash == $paroolFromDb) {
				$_SESSION["userId"] = $id;
				$_SESSION["userKasutaja"] = $kasutajaFromDb;
				header("Location: chatpage.php");
					} else {
					$error = "Vale parool";}	
					} else {
					$error = "Kasutajat selle nimega ".$kasutaja." ei leitud.";}
				return $error;
		}
		
	//POSTITUSE LOOMINE
		function postitus($pealkiri, $komment, $kategooria) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO loputoo_post (pealkiri, komment, kategooria, kasutaja) VALUE (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss",$pealkiri, $komment , $kategooria, $_SESSION["userKasutaja"]);
		if ( $stmt->execute() ) {
		} else {
			echo "ERROR ".$stmt->error;
			}	
		}
		
	//TABELID
		
		//POSTITUSE TABLE
		function postinfo($q, $sort, $order){
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		 
		$allowedSort = ["id", "pealkiri", "komment", "kategooria","kellaaeg", "kasutaja"];
		
		if(!in_array($sort, $allowedSort)){
			$sort = "kellaaeg";}
		
		$orderBy = "ASC";	
		
		if($order == "DESC"){
			$orderBy = "DESC";}
		//OTSING
		
		if ($q != "") {
		$stmt = $mysqli->prepare("
			SELECT id, pealkiri, komment, kategooria, kellaaeg, kasutaja
			FROM loputoo_post
			WHERE id LIKE ? 
			OR pealkiri LIKE ?
			OR komment LIKE ?
			OR kategooria LIKE ?
			OR kellaaeg LIKE ?
			OR kasutaja LIKE ?
			ORDER BY $sort $orderBy
			");
			
		$searchWord = "%".$q."%";
		$stmt->bind_param("ssssss",$searchWord, $searchWord, $searchWord, $searchWord, $searchWord, $searchWord );
		
		} else {
		//otsing ei toimu
		$stmt = $mysqli->prepare("
			SELECT id, pealkiri, komment, kategooria, kellaaeg, kasutaja 
			FROM loputoo_post
			ORDER BY $sort $orderBy
			");
		}
			
			$stmt->bind_result($id, $pealkiri, $komment, $kategooria, $kellaaeg, $kasutaja);
			$stmt->execute();
			$results = array();
			
			while ($stmt->fetch()) {
				$postitus = new StdClass();
				$postitus->id = $id;
				$postitus->pealkiri = $pealkiri;
				$postitus->komment = $komment;
				$postitus->kategooria = $kategooria;
				$postitus->kellaaeg = $kellaaeg;
				$postitus->kasutaja = $kasutaja;
				array_push($results, $postitus);	
			}
			return $results;
		}
		
		//NДITAB ЬHE POSTITUSE KOGU INFOT
		function getsingleId($show_id){
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("
			SELECT pealkiri, komment, kategooria, kellaaeg, kasutaja
			FROM loputoo_post 
			WHERE id = ?");
			
			$stmt->bind_param("i", $show_id);
			$stmt->bind_result($pealkiri, $komment, $kategooria , $kellaaeg, $kasutaja);
			$stmt->execute();

			$singleId = new Stdclass();
			
			if($stmt->fetch()){
				$singleId->pealkiri = $pealkiri;
				$singleId->komment = $komment;
				$singleId->kategooria = $kategooria;
				$singleId->kellaaeg = $kellaaeg;
				$singleId->kasutaja = $kasutaja;
			}else{
				header("Location: chatpage.php");
				exit();
			}
			$stmt->close();
			return $singleId;
		}
		
		//SAADA KOMMENTAARE
		function kommentaar($tagasiside){
		
			$mysqli = new mysqli($GLOBALS["serverHost"], 
			$GLOBALS["serverUsername"], 
			$GLOBALS["serverPassword"], 
			$GLOBALS["database"]);
			
			$tagasiside = $_POST["tagasiside"];
			
			$stmt = $mysqli ->prepare("INSERT INTO loputoo_komment (tagasiside, kasutaja, post_id) VALUE(?, ?, ?)");
			echo $mysqli->error;
			$stmt->bind_param("ssi", $tagasiside, $_SESSION["userKasutaja"],$_GET["id"]);
		
			if($stmt->execute() ) {			
			}
		}
		
		//NДITAB KOMMENTARI IGA POSTITUSE
			function kommentaarinfo(){
			
			$mysqli = new mysqli($GLOBALS["serverHost"], 
			$GLOBALS["serverUsername"], 
			$GLOBALS["serverPassword"], 
			$GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("
			SELECT tagasiside, kasutaja, kellaaeg
			FROM loputoo_komment
			WHERE post_id = ?
			");
			
			$stmt->bind_param("s", $_GET["id"]);
			$stmt->bind_result($tagasiside, $kasutaja, $kellaaeg );
			$stmt->execute();
			$results = array();
			
			while ($stmt->fetch()) {
				$comment = new StdClass();
				$comment->tagasiside = $tagasiside;
				$comment->kasutaja = $kasutaja;
				$comment->kellaaeg = $kellaaeg;
				array_push($results, $comment);	
			}
			return $results;
		}
		
		//FUNKTSIOON LOEB KOKKU KUI PALJU POSTITUSI TEGI IGA USER
			function kokkupost(){
		
			$mysqli = new mysqli($GLOBALS["serverHost"], 
			$GLOBALS["serverUsername"], 
			$GLOBALS["serverPassword"], 
			$GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("
			SELECT kasutaja,
			COUNT(*) FROM loputoo_post
			GROUP by kasutaja 
			");
			
			$stmt->bind_result($kasutaja,$COUNT);
			$stmt->execute();
			
			$results = array();
			while ($stmt->fetch()) {
				
				$kokku = new StdClass();
				$kokku->kasutaja = $kasutaja;
				$kokku->counting = $COUNT;

				array_push($results, $kokku);	
			}
			return $results;
		}
		
?>
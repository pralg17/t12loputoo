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
			echo "Õnnestus!";
		} else {
			echo "ERROR ".$stmt->error;
			}	
		}
		
	//TABELID
		//KASUTAJA TABLE
			function kasutajainfo(){$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("
			SELECT id, kasutaja, sugu, timestamp
			FROM loputoo_kasutaja 
			");
			
			$stmt->bind_result($id, $kasutaja, $sugu, $timestamp);
			$stmt->execute();
			
			$results = array();
			while ($stmt->fetch()) {
				$inimene = new StdClass();
				$inimene->id = $id;
				$inimene->kasutaja = $kasutaja;
				$inimene->sugu = $sugu;
				$inimene->timestamp = $timestamp;
				array_push($results, $inimene);	
			}
			return $results;
		}
?>
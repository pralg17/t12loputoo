<?php

	session_start();
	
	
	function signUp ($email, $password) {
		
		$database = "if16_georg";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("INSERT INTO eksam(email, password) VALUES(?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if($stmt->execute()) {
			
			echo "salvestamine onnestus";
			
		} else {
			
			echo "ERROR".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}

	function login($email, $password) {
		
		$error="";
		
		$database = "if16_georg";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT id, email, password FROM eksam WHERE email=?");
	
		echo $mysqli->error;
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb,$passwordFromDb);
		
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$hash=hash("sha512", $password);
			if($hash==$passwordFromDb){
				
				echo"Kasutaja logis sisse ".$id;
				
				$_SESSION["userId"]=$id;
				$_SESSION["userEmail"]=$emailFromDb;
				
				header("Location: movies.php");
				
			}else {
				$error="vale parool";
			}
			
		}else{
			
			$error="ei ole sellist emaili";
			
		}
		
		return $error;
	
	}

	function savecontact ($nimi, $staatus, $kuup, $user) {
		
		$database = "if16_georg";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("INSERT INTO filmid(nimi, staatus, kuup, kasutaja) VALUES(?, ?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $nimi, $staatus, $kuup, $user);
		
		if($stmt->execute()) {
			
			echo "salvestamine onnestus";
			
		} else {
			
			echo "ERROR".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}

	function getallcontacts($user, $q, $sort, $direction) {
		
		$allowedSortOptions=["nimi","staatus","kuup","reiting"];
		if(!in_array($sort, $allowedSortOptions)){
			$sort = "nimi";
		}
	
		
		$orderBy="ASC";
		if($direction == "descending"){
			$orderBy="DESC";
		}
		
		
		
		$database = "if16_georg";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		if($q==""){
			
			$stmt=$mysqli->prepare("
			SELECT nimi, staatus, kuup, reiting
			FROM filmid
			WHERE kasutaja = ?
			ORDER BY $sort $orderBy
		");
		
		$stmt->bind_param("s", $user);
		
		} else {
			
			$searchword="%".$q."%";
			$stmt=$mysqli->prepare("
			SELECT nimi, staatus, kuup, reiting
			FROM filmid
			WHERE kasutaja = ? AND (nimi LIKE ? OR staatus LIKE ? OR kuup LIKE ? OR reiting LIKE ?)
			ORDER BY $sort $orderBy
		");
		
		$stmt->bind_param("sssss", $user, $searchword, $searchword, $searchword, $searchword);
		
		}
		
	
		$stmt->bind_result($nimi, $staatus, $kuup, $reiting);
		$stmt->execute();
		
		$result=array();
		
		while($stmt->fetch()) {
			
			$contact= new stdclass();
			
			$contact->nimi=$nimi;
			$contact->staatus=$staatus;
			$contact->kuup=$kuup;
			$contact->reiting=$reiting;
		
			
			array_push($result, $contact);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}

	function getSingleContactData($nimi){
    
        $database = "if16_georg";
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT staatus, kuup, reiting FROM filmid WHERE nimi=?");
		$stmt->bind_param("s", $nimi);
		$stmt->bind_result($staatus, $kuup, $reiting);
		$stmt->execute();
		
		
		$contact = new Stdclass();
		
		
		if($stmt->fetch()){
			
			$contact->nimi = $nimi;
			$contact->staatus = $staatus;
			$contact->kuup = $kuup;
			$contact->reiting = $reiting;
			
			
		}else{
		
			header("Location: functions.php");
			exit();
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $contact;
		
	}
	function updatecontact($nimi, $staatus, $kuup, $uusnimi, $reiting){
    	
        $database = "if16_georg";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE filmid SET nimi=?, staatus=?, kuup=?, reiting=? WHERE nimi=?");
		$stmt->bind_param("sssss",$uusnimi, $staatus, $kuup, $reiting, $nimi);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function deletecontact($nimi){
    	
        $database = "if16_georg";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("DELETE FROM filmid WHERE nimi=?");
		$stmt->bind_param("s", $nimi);
		
		
		if($stmt->execute()){
			
		}
		
		$stmt->close();
		$mysqli->close();
		
	}



	function getStaatus($user) {
		
		$database = "if16_georg";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
			
		$stmt=$mysqli->prepare(" SELECT COUNT(staatus) FROM filmid WHERE kasutaja = ? AND (staatus LIKE 'vaadatud'); ");
		
		$stmt->bind_param("s", $user);
		
	
		$stmt->bind_result($vaadatud);
		$stmt->execute();
		
		if($stmt->execute()){
			echo "korras";
			echo $vaadatud;
		}
		

		$stmt->close();
		$mysqli->close();
		
		
		
	}










?>
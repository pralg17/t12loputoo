<?php

	require("../../../config.php");	
	// see fail peab olema kõigil lehtedel, kus
	// tahan kasutada SESSION muutujat
	session_start();
	
	//Signup
	function signUp ($email, $password, $gender, $age) {
		
		$database = "if16_johan_kodused";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("INSERT INTO users (email, password, gender, age) VALUES (?, ?, ?, ?)");
		
		echo $mysqli->error;		
		
		$stmt->bind_param("ssss", $email, $password, $gender, $age);
		
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus";
			
		} else {
			echo "ERROR ".$stmt->error;
		}

		$stmt->close();
		$mysqli->close();
	}
	
	//Login
	function login ($email, $password) {
		
		$error = "";
		
		$database = "if16_johan_kodused";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT id, email, password
		FROM users 
		WHERE email = ?");
		
		echo $mysqli->error;
		
		$stmt->bind_param("s", $email);
		
		// määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		
		$stmt->execute();
		
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				echo "Kasutaja logis sisse ".$id;
			
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: data.php");
				exit();
			}else{
				$error = "Vale parool";
			}
			
		} else {
			
			$error = "Ei ole sellist emaili";
		}
		
		return $error;
		
	}
	//Salvestab aktsia andmed
	function saveMovies ($title, $runtime, $price) {
		
		$database = "if16_johan_kodused";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("INSERT INTO movies (title, runtime, price) VALUES (?, ?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("sss", $title, $runtime, $price);
		
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus";
			
		} else {
			echo "ERROR ".$stmt->error;
		}

		$stmt->close();
		$mysqli->close();
	}
	
	//Toob aktsia andmed tagasi
	function getAllMovies($q, $sort, $direction) {
		
		//mis sort ja järjekord
		$allowedSortOptions = ["id", "title", "runtime", "price", "rent"];
		//kas sort on lubatud valikute sees
		if(!in_array($sort, $allowedSortOptions)){
			$sort = "id";
		}
		echo "Sorteerin: ".$sort." ";
		
		$orderBy = "ASC";
		if($direction == "descending"){
			$orderBy = "DESC";
		}
		echo "Järjekord: ".$orderBy." ";
		
		if($q == ""){
			echo "Ei otsi";
		
		$database = "if16_johan_kodused";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $mysqli->prepare("
			SELECT id, title, runtime, price, rent
			FROM movies WHERE rent is NULL 
			ORDER BY $sort $orderBy
		");
		echo $mysqli->error;
		//$stmt->bind_param("i", $_SESSION["userId"]);
		}else{
			echo "Otsib: ".$q;
			
			//teen otsisõna
			//lisan mõlemale poole %
			$searchword = "%".$q."%";
			
			$database = "if16_johan_kodused";
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

			$stmt = $mysqli->prepare("
				SELECT id, title, runtime, price, rent
				FROM movies WHERE 
				(title LIKE ? OR runtime LIKE ? OR price LIKE ?)
				ORDER BY $sort $orderBy
			");
			echo $mysqli->error;
			$stmt->bind_param("sss", $searchword, $searchword, $searchword);
		
		}
		//$stmt->bind_param("i", $_SESSION["userId"]);
		
		

		//
		echo $mysqli->error;
		
		$stmt->bind_result($id, $title, $runtime, $price, $rent);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab SELECT lausele
		while($stmt->fetch()) {
			
			//tekitan objekti
			$Movies = new StdClass();
			
			$Movies->id = $id;
			$Movies->title = $title;
			$Movies->runtime = $runtime;
			$Movies->price = $price;
			$Movies->rent = $rent;
			
			array_push($result, $Movies);
		}
		
		$stmt->close();
		$mysqli->close();
	
		return $result;
	}

	function getMovies() {
		
		$database = "if16_johan_kodused";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $mysqli->prepare("
			SELECT id, title, rent
			FROM movies
		");
		
		$stmt->bind_result($id, $title, $rent);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab SELECT lausele
		while($stmt->fetch()) {
			
			//tekitan objekti
			$Movies = new StdClass();
			
			$Movies->id = $id;
			$Movies->title = $title;
			$Movies->rent = $rent;
			
			//echo $plate."<br>";
			//iga kord massiivi lisan juurde nr m�rgi
			array_push($result, $Movies);
		}
		
		$stmt->close();
		$mysqli->close();
	
		return $result;
	}
	
	function cleanInput($input){
		
		$input = trim($input);
		$input = stripcslashes($input);
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
	
	
?>
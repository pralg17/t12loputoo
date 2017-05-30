<?php

	require_once("../../../config.php");
	
	function getSingleMovieData($edit_id){
    
        $database = "if16_johan_kodused";

		//echo "id on ".$edit_id;
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT title, runtime, price FROM movies WHERE id=?");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($movieDB, $runtime, $price);
		$stmt->execute();
		
		//tekitan objekti
		$movie = new StdClass();
		
		//saime �he rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			//$Stock->id = $id;
			$movie->title = $movieDB;
			$movie->runtime = $runtime;
			$movie->price = $price;
			
			
		}else{
			// ei saanud rida andmeid k�tte
			// sellist id'd ei ole olemas
			// see rida v�ib olla kustutatud
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $movie;
		
	}


	function updateMovie($id, $rent){
    	
        $database = "if16_johan_kodused";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE movies SET rent=? WHERE id=?");
		$stmt->bind_param("si",$rent, $id);
		
		// kas �nnestus salvestada
		if($stmt->execute()){
			// �nnestus
			echo "salvestus �nnestus!";
		}
		
		$stmt->close();
		$mysqli->close();
		
	}

		function deleteMovie($id){
    	
        $database = "if16_johan_kodused";

		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("DELETE FROM movies WHERE movies.id=?");
		$stmt->bind_param("i", $id);
		
		// kas �nnestus salvestada
		if($stmt->execute()){
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
?>
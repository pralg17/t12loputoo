<?php
class Event {
    
    private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}


	function getAllPeople($q, $sort, $order) {
		
		$allowedSort = ["id", "age", "color"];
		
		// sort ei kuulu lubatud tulpade sisse 
		if(!in_array($sort, $allowedSort)){
			$sort = "id";
		}
		
		$orderBy = "ASC";
		
		if($order == "DESC") {
			$orderBy = "DESC";
		}
		
		echo "Sorteerin: ".$sort." ".$orderBy." ";
		
		
		if ($q != "") {
			//otsin
			echo "otsin: ".$q;
			
			$stmt = $this->connection->prepare("
				SELECT id, age, color
				FROM whistle
				WHERE deleted IS NULL
				AND ( age LIKE ? OR color LIKE ? )
				ORDER BY $sort $orderBy
			");
			
			$searchWord = "%".$q."%";
			
			$stmt->bind_param("ss", $searchWord, $searchWord);
			
		} else {
			// ei otsi
			$stmt = $this->connection->prepare("
				SELECT id, age, color
				FROM whistle
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
			");
		}
		
		$stmt->bind_result($id, $age, $color);
		$stmt->execute();
		
		$results = array();
		
		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->age = $age;
			$human->lightColor = $color;
			
			
			//echo $color."<br>";
			array_push($results, $human);
			
		}
		
		return $results;
		
	}
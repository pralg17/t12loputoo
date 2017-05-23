<?php
class Flower {
	private $connection;
	function __construct($mysqli){
		$this->connection = $mysqli;
	}

	function delete($id){

		$stmt = $this->connection->prepare("UPDATE flowers_and_colors SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);

		if($stmt->execute()){
			echo "kustutamine õnnestus!";
		}
		$stmt->close();
	}

	function get($q, $sort, $direction) {

		//mis sort ja järjekord
		$allowedSortOptions = ["id", "flower", "color"];
		if(!in_array($sort, $allowedSortOptions)){
			$sort = "id";
		}
		echo "Sorteerin: ".$sort." ";

		$orderBy= "ASC";
		if($direction == "descending"){
			$orderBy= "DESC";
		}
		echo "Järjekord: ".$orderBy." ";

		if($q == ""){

			echo "ei otsi";

			$stmt = $this->connection->prepare("
				SELECT id, flower, color
				FROM flowers_and_colors
				WHERE deleted IS NULL
				ORDER BY $sort $orderBy
			");
			echo $this->connection->error;
		}else{

			echo "Otsib: ".$q;

			$searchword = "%".$q."%";

			$stmt = $this->connection->prepare("
				SELECT id, flower, color
				FROM flowers_and_colors
				WHERE deleted IS NULL AND
				(flower LIKE ? OR color LIKE ?)
				ORDER BY $sort $orderBy
			");
			$stmt->bind_param("ss", $searchword, $searchword);

		}

		echo $this->connection->error;

		$stmt->bind_result($id, $flower, $color);
		$stmt->execute();

		$result = array();

		while ($stmt->fetch()) {

			$lilled = new StdClass();

			$lilled->id = $id;
			$lilled->flower = $flower;
			$lilled->flowerColor = $color;

			array_push($result, $lilled);
		}

		$stmt->close();

		return $result;
	}

	function getSingle($edit_id){

		$stmt = $this->connection->prepare("SELECT flower, color FROM flowers_and_colors WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($flowers, $color);
		$stmt->execute();

		$lilled = new Stdclass();

		if($stmt->fetch()){
			$lilled->flower = $flowers;
			$lilled->color = $color;
		}else{
			header("Location: data.php");
			exit();
		}

		$stmt->close();
		return $lilled;

	}
	function save ($flower, $color) {

		$stmt = $this->connection->prepare("INSERT INTO flowers_and_colors (flower, color) VALUES (?, ?)");

		echo $this->connection->error;

		$stmt->bind_param("ss", $flower, $color);

		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}

		$stmt->close();


	}

	function update($id, $flower, $color){

		$stmt = $this->connection->prepare("UPDATE flowers_and_colors SET flower=?, color=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("ssi",$flower, $color, $id);

		if($stmt->execute()){
			echo "Uuendused salvestatud!";
		}
		$stmt->close();
	}
}
?>

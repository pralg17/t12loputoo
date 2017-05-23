<?php
class NewFlower {

	private $connection;

	function __construct($mysqli){

		$this->connection = $mysqli;

	}

	/*TEISED FUNKTSIOONID */
	function get() {

		$stmt = $this->connection->prepare("
			SELECT id, newflower
			FROM newflowers
		");
		echo $this->connection->error;

		$stmt->bind_result($id, $newflower);
		$stmt->execute();


		//tekitan massiivi
		$result = array();

		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {

			//tekitan objekti
			$i = new StdClass();

			$i->id = $id;
			$i->newflower = $newflower;

			array_push($result, $i);
		}

		$stmt->close();


		return $result;
	}

	function getUser() {

		$stmt = $this->connection->prepare("
			SELECT newflower FROM newflowers
			JOIN user_newflowers
			ON newflowers.id=user_newflowers.newflower_id
			WHERE user_newflowers.user_id = ?
		");
		echo $this->connection->error;
		$stmt->bind_param("i", $_SESSION["userId"]);

		$stmt->bind_result($newflower);
		$stmt->execute();


		//tekitan massiivi
		$result = array();

		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {

			//tekitan objekti
			$i = new StdClass();

			$i->newflower = $newflower;

			array_push($result, $i);
		}

		$stmt->close();


		return $result;
	}

	function save ($newflower) {

		$stmt = $this->connection->prepare("INSERT INTO newflowers (newflower) VALUES (?)");

		echo $this->connection->error;

		$stmt->bind_param("s", $newflower);

		if($stmt->execute()) {
			echo "salvestamine �nnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}

		$stmt->close();


	}

	function saveUser ($newflower) {

		$stmt = $this->connection->prepare("
			SELECT id FROM user_newflowers
			WHERE user_id=? AND newflower_id=?
		");
		$stmt->bind_param("ii", $_SESSION["userId"], $newflower);
		$stmt->bind_result($id);

		$stmt->execute();

		if ($stmt->fetch()) {
			// oli olemas juba selline rida
			echo "juba olemas";
			// p�rast returni midagi edasi ei tehta funktsioonis
			return;

		}

		$stmt->close();

		// kui ei olnud siis sisestan

		$stmt = $this->connection->prepare("
			INSERT INTO user_newflowers
			(user_id, newflower_id) VALUES (?, ?)
		");

		echo $this->connection->error;

		$stmt->bind_param("ii", $_SESSION["userId"], $newflower);

		if ($stmt->execute()) {
			echo "salvestamine �nnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

	}

}
?>

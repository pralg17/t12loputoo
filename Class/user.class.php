<?php
class User {
	private $connection;
	public $name;
	function __construct($mysqli){
		
		$this->connection=$mysqli; //this on user
			
	}

	function signUp ($email, $password, $name, $roll, $age, $county) {
		$this->connection->set_charset("utf8");
		$stmt = $this->connection->prepare("INSERT INTO user_sample (email, password, name, roll, vanus, elukoht) VALUES (?, ?, ?, ?, ?, ?)");
	
		echo $this->connection->error;
		
		$stmt->bind_param("ssssss", $email, $password, $name, $roll, $age, $county);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		//$this->connection->close();
		
	}
	function login ($email, $password) {
		
		$error = "";
		
		$stmt = $this->connection->prepare("
		SELECT id, email, password, created 
		FROM user_sample
		WHERE email = ?");
	
		echo $this->connection->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		// on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				
				echo "Kasutaja logis sisse ".$id;
				
				//määran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: frontpage.php");
				exit();
				
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
		return $error;
		
	}
	
	
	
}
?>
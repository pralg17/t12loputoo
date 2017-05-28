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
		
?>
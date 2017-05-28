<?php
	
	require("function.php");
	require("style.php");

	
	//NÄITAB ÜHE POSTITUSE KOGU INFOT
		function getsingleId3($show_id){
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("
			SELECT tagasiside
			FROM loputoo_komment 
			WHERE id = ?");
			
			$stmt->bind_param("i", $show_id);
			$stmt->bind_result($tagasiside);
			$stmt->execute();

			$singleId = new Stdclass();
			
			if($stmt->fetch()){
				$singleId->tagasiside = $tagasiside;
			}else{
				header("Location: changecomment.php");
				exit();
			}
			$stmt->close();
			return $singleId;
		}
	//KOMMENTAARI UUENDAMINE
		//UUENDA KOMMENTAARI
	function uuendaKomm($tagasiside){
		$mysqli = new mysqli($GLOBALS["serverHost"],
		$GLOBALS["serverUsername"],
		$GLOBALS["serverPassword"],
		$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE loputoo_komment SET tagasiside=? WHERE id=?");
		$stmt->bind_param("si", $tagasiside, $_GET["id"]);

		if($stmt->execute()){
			header("Location: user_info?id=". $_GET["id"]."&success=true");
		}
		$stmt->close();
		$mysqli->close();	
	}

	
	//KOMMENTAARI UUENDAMINE
		if(isset($_POST["uuendaKomm"])){	
			uuendaKomm($_POST["tagasiside"]);
			exit();	
		}
		

	$p = getsingleId3($_GET["id"]);
?>
<html>
	
	<style>
	</style>

	<body>

		<div style="changecomment">
			<center>
				<form method= "POST" >
				
				<label for="tagasiside" >Kommentaar:</label><br>
				<input id="tagasiside" name="tagasiside" class="text" value="<?php echo $p->tagasiside;?>" required> <br>
				
				<input type="submit" name="uuendaKomm" value="Uuenda">
				
				</form>
			</center>
		</div>

	</body>
</html>
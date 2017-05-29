<?php
	
	require("function.php");
	require("style.php");
	
	//NÄITAB ÜHE POSTITUSE KOGU INFOT
		function getsingleId2($show_id){
			
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("
			SELECT pealkiri, komment, kategooria
			FROM loputoo_post 
			WHERE id = ?");
			
			$stmt->bind_param("i", $show_id);
			$stmt->bind_result($pealkiri, $komment, $kategooria);
			$stmt->execute();

			$singleId = new Stdclass();
			
			if($stmt->fetch()){
				$singleId->pealkiri = $pealkiri;
				$singleId->komment = $komment;
				$singleId->kategooria = $kategooria;
			}else{
				header("Location: changepost.php");
				exit();
			}
			$stmt->close();
			return $singleId;
		}
	//POSTI UUENDAMINE
		//UUENDA
		function uuendaPost($pealkiri, $komment, $kategooria){
			$mysqli = new mysqli($GLOBALS["serverHost"],
			$GLOBALS["serverUsername"],
			$GLOBALS["serverPassword"],
			$GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("UPDATE loputoo_post SET pealkiri=?, komment=?, kategooria=?  WHERE id=?");
			$stmt->bind_param("sssi", $pealkiri, $komment, $kategooria, $_GET["id"]);

			if($stmt->execute()){
				header("Location: user_info?id=". $_GET["id"]."&success=true");
			}
			$stmt->close();
			$mysqli->close();	
		}

	
	//POSTI UUENDAMINE
		if(isset($_POST["uuendaPost"])){	
			uuendaPost($_POST["pealkiri"], $_POST["komment"], $_POST["kategooria"]);
			exit();	
		}
	
	//POSTITUSE KUSTUTAMINE
	function deletepost($id){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"], 
		$GLOBALS["serverPassword"], 
		$GLOBALS["database"]);		
		
		$stmt = $mysqli->prepare("
		DELETE from loputoo_post WHERE id=?");
		$stmt->bind_param("i", $id);

		if($stmt->execute()){
		}
		
		$stmt->close();
		
	}
		//KUI ISSET DELETE
		if(isset($_GET["delete"])){
			deletepost($_GET["id"]);
			header("Location: user_info.php");
			exit();
		}

	$p = getsingleId2($_GET["id"]);
?>
<html>
	
	<style>
	</style>

	<body>

		<div style="changepost">
			<center>
				<form method= "POST" >
				
				<label for="pealkiri" >Pealkiri:</label><br>
				<input id="pealkiri" name="pealkiri" class="text" value="<?php echo $p->pealkiri;?>" required> <br>
				
				<label for="komment" >Kommentaar:</label><br>
				<input id="komment" name="komment" class="text" value="<?php echo $p->komment;?>" required> <br>
				
				<p><label for="kategooria">Sinu kategooria <?php echo $p->kategooria;?></label><br>
					<select name = "kategooria"  id="kategooria" required><br><br>
					<option value="">Vali kategooria:</option>
					<option value="PC games">PC games</option>
					<option value="Xbox games">Xbox games</option>
					<option value="Nintendo games">Nintendo games</option>
					<option value="PlayStation games">PlayStation games</option>
					<option value="Mobile gamess">Mobile games</option>
				</select><br><br>
				
				<input type="submit" name="uuendaPost" value="Uuenda">
				
				<a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a>
				
				</form>
			</center>
		</div>

	</body>
</html>
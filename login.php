<?php

	//FUNKTSIOON
	require("../config.php");
	require("function.php");
	require("style.php");

	
	//SISSE
	//SESSION
	if (isset($_SESSION["userId"]))
	{
		header("Location: chatpage.php");
	}
	
	//MUUTUAJD
	$regKasutaja = $regKasutajaError = $regParool = $regParoolError = $regSugu = "" ;
	$logKasutaja = $logKasutajaError = $logParool = $logParoolError = $error = "";
	
	//KASUTAJA REGISTREERIMINE
	//KASUTAJA
	if (isset ($_POST["regKasutaja"])) {
		if (empty ($_POST["regKasutaja"])) {
			$regKasutajaError = "* Väli on kohustuslik!";
		} else {
			$regKasutaja = $_POST["regKasutaja"];
		}
		if (strlen ($_POST["regKasutaja"]) >15)
		$regKasutajaError = "* Nimi ei tohi olla rohkem kui 15 tähemärki pikk!";
	}
	//PAROOL
	if(isset ($_POST["regParool"])) {
		if (empty ($_POST["regParool"])) {
		$regParoolError = "See väli on kohustuslik!";
		} else {
		if (strlen ($_POST["regParool"]) <6)
		$regParoolError = "Parool peab olema vähemalt 6 tähemärki!";
		}
	}
	
	//LOOGIMINE SISSE
	//KASUTAJA
	if (isset ($_POST["logKasutaja"])) {
		if (empty ($_POST["logKasutaja"])) {
			$logKasutajaError = "* Väli on kohustuslik!";
		}else {
		//kui Email on korras
		$logKasutaja = $_POST["logKasutaja"];
		}
	}
	
	
	//PAROOL
	if (isset ($_POST["logParool"])) {
		if (empty ($_POST["logParool"])) {
			$logParoolError = "* Väli on kohustuslik!";
		} 
	}
	
		//REGISTREERIMISE LÕPP
		if ( $regKasutajaError == "" AND
			$regParoolError == "" &&
			isset($_POST["regKasutaja"]) &&
			isset($_POST["regParool"])
		)
		if (isset($_POST["regKasutaja"])&&
			!empty($_POST["regParool"])
			)
		//SALVESTAMINE JA FUNKTSIOON
		{
		$regParool = hash("sha512", $_POST["regParool"]);
		registration($regKasutaja, $regParool, $_POST["regSugu"]);
		}
		
		//LOOGIMISE LQPP
		if (isset ($_POST["logKasutaja"]) &&
			isset ($_POST["logParool"])  &&
			!empty ($_POST["logKasutaja"]) &&
			!empty ($_POST["logParool"])
		)
		{
		$error = login($_POST["logKasutaja"], $_POST["logParool"]);
		}
		
?>

<!DOCTYPE html>

<html>
		
	<head>
	<title>Sisselogimise leht</title>
	</head>
	
		<body>
			<center>
	
				<div class="Sisse loogimine">
					<h1>Logi sisse</h1>
					<form method="POST" >
					
						<?=$error;?>
						<label for="logKasutaja">Kasutaja</label></br>
						<input name="logKasutaja" type = "logKasutaja" placeholder="Kasutaja" value="<?=$logKasutaja;?>"><br>
						<font color="white"><?php echo $logKasutajaError; ?></font>
						
						<br><label for="logParool">Parool</label></br>
						<input name="logParool" type = "password" placeholder="Parool"><br> 
						<font color="white"><?php echo $logParoolError; ?></font><br>
						
						<input type="submit" value="Logi sisse">
					
					</form>

			
					<h1>Loo kasutaja</h1>
					<form method="POST" >
						
						<label for="regKasutaja">Kasutaja</label></br>
						<input name="regKasutaja" placeholder="Kasutaja" value="<?=$regKasutaja;?>"> 
						<br><font color="white"><?php echo $regKasutajaError; ?></font>
						
						<br><label for="regParool">Parool</label></br>
						<input name="regParool" type = "password" placeholder="Parool"> 
						<br><font color="white"><?php echo $regParoolError; ?></font>
						
						<p><label for="regSugu">Sugu:</label><br>
						<select name = "regSugu"  id="regSugu" required><br><br>
						<option value="">Näita</option>
						<option value="Mees">Mees</option>
						<option value="Naine">Naine</option>
						<option value="Muu">Muu</option>
						</select><br><br>
						
					<input type="submit" value="Loo kasutaja">
						
					</form>
				</div>
				
			</center>
		</body>

</html>
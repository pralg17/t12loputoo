<?php

	//MUUTUAJD
	$regKasutaja = $regKasutajaError = $regParool = $regParoolError = $regSugu = "" ;
	$logKasutaja = $logKasutajaError = $logParool = $logParoolError = "";
	
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
	if (isset ($_POST["regParool"])) {
		if (empty ($_POST["regParool"])) {
			$regParoolError = "* Väli on kohustuslik!";
			} else {
		}if (strlen ($_POST["regParool"]) <8)
			$regParoolError = "* Parool peab olema vähemalt 8 tähemärki pikk!";
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
		
?>

<!DOCTYPE html>

<html>
		
	<head>
	<title>Sisselogimise leht</title>
	</head>
	
		<body>
			<center>
	
				<h1>Logi sisse</h1>
				<form method="POST" >
				
					<input name="logKasutaja" type = "logKasutaja" placeholder="Kasutaja" value="<?=$logKasutaja;?>"><br>
					<font color="red"><?php echo $logKasutajaError; ?></font></br>
					
					<input name="logParool" type = "password" placeholder="Parool"><br> 
					<font color="red"><?php echo $logParoolError; ?></font><br>
					
					<input type="submit" value="Logi sisse">
				
				</form>

				
				<h1>Loo kasutaja</h1>
				<form method="POST" >
				
					<label></label><br>	
					
					<input name="regKasutaja" placeholder="Kasutaja" value="<?=$regKasutaja;?>"> 
					<br><font color="red"><?php echo $regKasutajaError; ?></font></br>
					
					<input name="regParool" type = "password" placeholder="Parool"> 
					<br><font color="red"><?php echo $regParoolError; ?></font></br>
					
					<p><label for="regSugu">Sugu:</label><br>
					<select name = "regSugu"  id="regSugu" required><br><br>
					<option value="">Näita</option>
					<option value="1">Mees</option>
					<option value="2">Naine</option>
					<option value="2">Muu</option>
					</select><br><br>
					

				<input type="submit" value="Loo kasutaja">
					
				</form>
				</center>	
				
			
		</body>
		

</html>
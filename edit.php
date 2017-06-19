<?php
	
	require("../../config.php");
	require("functions.php");
	
	
	

	

	if(isset($_POST["update"])){
		
		updatecontact($_POST["nimi"], $_POST["staatus"], $_POST["kuup"], $_POST["uusnimi"], $_POST["reiting"] );
		
	
		
		header("Location:movies.php");
        exit();	
		
	}
	
	if(isset($_POST["delete"])){
		
		deletecontact($_POST["nimi"]);
		
		header("Location:movies.php");
        exit();	
		
	}
	
	
	$c = getSingleContactData($_GET["nimi"]);
	
	
?>

<br><br>
<a href="movies.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="reiting" >Reiting</label><br>
	<input id="reiting" type="integer" name="reiting"  ><br><br>
  	<label for="nimi" >Filmi nimi</label><br>
	<input type="hidden" name="nimi" value="<?=$_GET["nimi"];?>" >
	<input id="nimi" name="uusnimi" type="text" value="<?php echo $c->nimi;?>" ><br><br>
  	<label for="staatus" >Staatus</label><br>
	<input id="staatus" name="staatus" type="text" value="<?=$c->staatus;?>"><br><br>
	<label for="kuup" >Kuupaev</label><br>
	<input id="kuup" name="kuup" type="text" value="<?=$c->kuup;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
	<br><br><br>
	<input type="submit" name="delete" value="Kustuta Film">
  </form>

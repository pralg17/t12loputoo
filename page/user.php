<?php

	require("../functions.php");

	require("../class/Helper.class.php");
$Helper = new Helper();

require("../class/Rides.class.php");
$Rides = new Rides($mysqli);

	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){

		//suunan sisselogimise lehele
		header("Location: login.php");
		exit();
	}


	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {

		session_destroy();
		header("Location: login.php");
		exit();
	}

?>

<?php require("../header.php"); ?>

<div class="container">


	<div class="col-sm-4 col-md-3">

<h2> TLU CarPooling</h2>
<h5>
	<a href="?logout=1">Log out</a>
</h5>

<h5><a href="data.php"> Back</a></h5>

<br>
<h4><a href="youDrive.php">Driver page</a></h4>

<h4><a href="youPassenger.php">Passenger page</a></h4>

	</div>
</div>
<?php require("../footer.php"); ?>

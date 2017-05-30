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

  if(isset($_GET["delete"]) && isset($_GET["id"])) {

      $Rides->deleteRide($_GET["id"]);
      header("Location: youDrive.php");
      exit();
    }

?>

<?php require("../header.php"); ?>

<div class="container">


	<div class="col-centered">
    <h2> Are you sure you want to cancel ride number <?=$_GET["id"];?>? </h2>

          <a class='btn' href='?id=<?=$_GET["id"];?>&delete=true'>
          Confirm
          <span class='glyphicon glyphicon-trash'></span>
          </a>


  </div>
</div>
<?php require("../footer.php"); ?>

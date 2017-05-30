<?php

	require("../functions.php");

	require("../class/Helper.class.php");
$Helper = new Helper();

require("../class/User.class.php");
$User = new User($mysqli);

	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){

		//suunan sisselogimise lehele
		header("Location: login.php");
		exit();
	}

	if (isset($_GET["id"])) {
		 $id = ($_GET["id"]);}




	if ( isset($_POST["rating"]) &&
		 isset($_POST["feedback"]) &&
		 !empty($_POST["rating"]) &&
		 !empty($_POST["feedback"])
	) {

		$rating = $Helper->cleaninput($_POST["rating"]);
		$feedback = $Helper->cleaninput($_POST["feedback"]);

		$User->userFeedback($id, $rating, $feedback);

		header("Location: youPassengerPast.php");
		exit();

	}

?>

<?php require("../header.php"); ?>

<div class="container">


	<div class="col-centered col-md-8">
    <h2> Give feedback to the driver:</h2>

		<form method="POST" >
    <div class ="form-group">
      <textarea class = "form-control" name="feedback" rows = "10"></textarea>
    </div>

		<label>Leave a rating:</label>
		<div class ="form-group">
		<input class = "form-control" name="rating" type="number" value=
		</div>
<br>
  <input class="btn btn-sm hidden-xs" type="submit" value="Submit">
  <input class="btn btn-sm btn-block visible-xs-block" type="submit" value="Submit">
</form>
    <h3><a href="youPassengerPast.php">Never mind...BACK!!!</a></h3>

  </div>
</div>
<?php require("../footer.php"); ?>

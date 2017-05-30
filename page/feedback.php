<?php

require("../functions.php");

require("../class/Helper.class.php");
$Helper = new Helper();

require("../class/User.class.php");
$User = new User($mysqli);

if (!isset($_SESSION["userId"])) {
  header("Location: login.php");
  exit();
}

if (isset($_GET["logout"])) {

  session_destroy();

  header("Location: login.php");
  exit();

}


?>
<?php require("../header.php"); ?>

<div class="container">


	<div class="col-sm-4 col-md-3">


<h2>Feedback page</h2>

<h4><a href="data.php"> Back</a></h4>

<form>
	<h2>Search </h2>
	<div class ="form-group">
	<input class = "form-control" type="search" name="r" value="<?=$r;?>">
	</div>
	<input class="btn btn-sm hidden-xs" type="submit" value="Search">
	<input class="btn btn-sm btn-block visible-xs-block" type="submit" value="Search">
</form>

</div>

  <?php


	$html = "<div class='col-md-8'>";
		$html = "<div class='table'>";
		$html = "<table class='table-striped table-condensed'>";
		$html .= "<h2>Feedback</h2>";




  	$html .= "</table>";
		$html .= "</div>";
	$html .= "</div>";

  	echo $html;

  ?>
</div>
<?php require("../footer.php"); ?>

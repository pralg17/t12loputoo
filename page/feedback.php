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


 if ( isset($_POST["getFeedback"]) &&
   !empty($_POST["getFeedback"])
   ) {

   echo $_POST["getFeedback"];
   $feedback->getFeedback($Helper->cleaninput($_POST["getFeedback"]));

 }

 if(isset($_GET["r"])) {
   $r = $_GET["r"];

 } else {
   //ei otsi
   $r = "";
 }

 $sort = "id";
 $order = "ASC";

 if (isset($_GET["sort"]) && isset($_GET["order"])) {
   $sort = $_GET["sort"];
   $order = $_GET["order"];

 }

$feedback = $User->getFeedback($r, $sort, $order);

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

  		$html .= "<tr>";

  			$orderID= "ASC";
  			$arr="&darr;";

  			if (isset($_GET["order"]) &&
  			$_GET["order"] == "ASC" &&
  			$_GET["sort"] == "id") {

  				$orderID= "DESC";
  				$arr="&uarr;";
  			}

  				$html .= "<th>
  				<a href='?q=".$r."&sort=id&order=".$orderID."'>

  				User ".$arr."
  				</a>

  				</th>";

					//Start_time related

						//Guest_id related
	  				$orderRating = "ASC";
						$arr="&darr;";
	  				if (isset($_GET["order"]) &&
	  				$_GET["order"] == "ASC" &&
	  				$_GET["sort"] == "rating") {

	  					$orderRating = "DESC";
							$arr="&uarr;";

	  				}

	  					$html .= "<th>
	  					<a href='?q=".$r."&sort=rating&order=".$orderRating."'>

	  					Rating ".$arr."
	  					</a>

	  					</th>";

							$orderFeedback= "ASC";
							$arr="&darr;";
							if (isset($_GET["order"]) &&
							$_GET["order"] == "ASC" &&
							$_GET["sort"] == "feedback") {

								$orderFeedback= "DESC";
								$arr="&uarr;";

							}

								$html .= "<th>
								<a href='?q=".$r."&sort=feedback&order=".$orderFeedback."'>

								Feedback".$arr."
								</a>

								</th>";

								$orderAdded= "ASC";
								$arr="&darr;";
								if (isset($_GET["order"]) &&
								$_GET["order"] == "ASC" &&
								$_GET["sort"] == "added") {

									$orderAdded = "DESC";
									$arr="&uarr;";

								}

									$html .= "<th>
									<a href='?q=".$r."&sort=added&order=".$orderAdded."'>

									Added".$arr."
									</a>

									</th>";



  		$html .= "</tr>";

  		//iga liikme kohta massiivis
  		foreach ($feedback as $r) {

  			$html .= "<tr>";
  				$html .= "<td>".$r->user_email."</td>";
					$html .= "<td>".$r->rating."</td>";
					$html .= "<td>".$r->feedback."</td>";
					$html .= "<td>".$r->added."</td>";


  			$html .= "</tr>";

  		}

  	$html .= "</table>";
		$html .= "</div>";
	$html .= "</div>";

  	echo $html;

  ?>
</div>
<?php require("../footer.php"); ?>

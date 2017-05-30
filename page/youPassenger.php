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


  $msg = "";

	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];

		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}

  if ( isset($_POST["getPassenger"]) &&
		!empty($_POST["getPassenger"])
	  ) {

		echo $_POST["getPassenger"];
		$Rides->getPassenger($Helper->cleaninput($_POST["getPassenger"]));

	}

	if(isset($_GET["r"])) {
		$r = $_GET["r"];

	} else {
		//ei otsi
		$r = "";
	}

	$sort = "ride_id";
	$order = "ASC";

	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];

	}

    $rides = $Rides->getPassenger($r, $sort, $order);


?>

<?php require("../header.php"); ?>

<div class="container">


	<div class="col-sm-4 col-md-3">


<h2> Passenger page</h2>

<h4><a href="user.php"> Back</a></h4>
<?=$msg;?>

<h4><a href="youPassengerPast.php"> Past rides</a></h4>
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
		$html .= "<h2>Upcoming rides</h2>";

  		$html .= "<tr>";
			//User ID related
	  		$orderId = "ASC";
	  		$arr="&darr;";
	  		if (isset($_GET["order"]) &&
		  		$_GET["order"] == "ASC" &&
		  		$_GET["sort"] == "id") {

	  			$orderId = "DESC";
	  			$arr="&uarr;";
  			}


  			$html .= "<th>
				<a href='?q=".$r."&sort=id&order=".$orderId."'>

				Ride ID ".$arr."

				</a>

				</th>";

				//start_location related

  			$orderStart_location = "ASC";
  			$arr="&darr;";

  				if (isset($_GET["order"]) &&
		  			$_GET["order"] == "ASC" &&
		  			$_GET["sort"] == "start_location") {

  					$orderStart_location = "DESC";
  					$arr="&uarr;";
  				}

  				$html .= "<th>
  						<a href='?q=".$r."&sort=start_location&order=".$orderStart_location."'>

  						Start location ".$arr."
  					</a>

  				</th>";

					//Start_time related
  				$orderStart_time = "ASC";
					$arr="&darr;";
  				if (isset($_GET["order"]) &&
  				$_GET["order"] == "ASC" &&
  				$_GET["sort"] == "start_time") {

  					$orderStart_time = "DESC";
						$arr="&uarr;";

  				}

  					$html .= "<th>
  					<a href='?q=".$r."&sort=start_time&order=".$orderStart_time."'>

  					Start time ".$arr."
  					</a>

  					</th>";

						//Guest_id related
	  				$orderArrival_location = "ASC";
						$arr="&darr;";
	  				if (isset($_GET["order"]) &&
	  				$_GET["order"] == "ASC" &&
	  				$_GET["sort"] == "arrival_location ") {

	  					$orderArrival_location = "DESC";
							$arr="&uarr;";

	  				}

	  					$html .= "<th>
	  					<a href='?q=".$r."&sort=arrival_location &order=".$orderArrival_location ."'>

	  					Arrival location ".$arr."
	  					</a>

	  					</th>";

							$orderArrival_time= "ASC";
							$arr="&darr;";
							if (isset($_GET["order"]) &&
							$_GET["order"] == "ASC" &&
							$_GET["sort"] == "arrival_time") {

								$orderArrival_time = "DESC";
								$arr="&uarr;";

							}

								$html .= "<th>
								<a href='?q=".$r."&sort=arrival_time&order=".$orderArrival_time."'>

								Time of arrival ".$arr."
								</a>

								</th>";

								$orderFree_seats= "ASC";
								$arr="&darr;";
								if (isset($_GET["order"]) &&
								$_GET["order"] == "ASC" &&
								$_GET["sort"] == "free_seats") {

									$orderFree_seats = "DESC";
									$arr="&uarr;";

								}

									$html .= "<th>
									<a href='?q=".$r."&sort=free_seats&order=".$orderFree_seats."'>

									Free seats ".$arr."
									</a>

									</th>";

									$orderDriver_name= "ASC";
									$arr="&darr;";
									if (isset($_GET["order"]) &&
									$_GET["order"] == "ASC" &&
									$_GET["sort"] == "driver_name") {

										$orderDriver_name= "DESC";
										$arr="&uarr;";

									}

										$html .= "<th>
										<a href='?q=".$r."&sort=driver_name&order=".$orderDriver_name."'>

									 Driver ".$arr."
										</a>

										</th>";

										$orderDriver_email = "ASC";
										$arr="&darr;";
										if (isset($_GET["order"]) &&
										$_GET["order"] == "ASC" &&
										$_GET["sort"] == "driver_email") {

											$orderDriver_email = "DESC";
											$arr="&uarr;";

										}

										$html .= "<th>
										<a href='?q=".$r."&sort=driver_email&order=".$orderDriver_email."'>

									 Driver email ".$arr."
										</a>

										</th>";

										$html .= "<th>

									 Cancel registration
										</a>

										</th>";

  		$html .= "</tr>";

  		//iga liikme kohta massiivis
  		foreach ($rides as $r) {

  			$html .= "<tr>";
					$html .= "<td>".$r->ride_id."</td>";
  				$html .= "<td>".$r->start_location."</td>";
  				$html .= "<td>".$r->start_time."</td>";
					$html .= "<td>".$r->arrival_location."</td>";
					$html .= "<td>".$r->arrival_time."</td>";
					$html .= "<td>".$r->free_seats."</td>";
					$html .= "<td>".$r->driver_name."</td>";
					$html .= "<td>".$r->driver_email."</td>";

          $html .= "<td>


  							<a class='btn' href='editRegistration.php?id=".$r->ride_id."'>
  							Cancel
  							<span class='glyphicon glyphicon-trash'></span>
  							</a>
  							</td>";

  			$html .= "</tr>";

  		}

		$html .= "</table>";
		$html .= "</div>";
	$html .= "</div>";

  	echo $html;

  ?>
</div>
<?php require("../footer.php"); ?>

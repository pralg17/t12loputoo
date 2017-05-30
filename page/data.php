<?php

require("../functions.php");

require("../class/Helper.class.php");
$Helper = new Helper();

require("../class/Rides.class.php");
$Rides = new Rides($mysqli);

if (!isset($_SESSION["userId"])) {
  header("Location: login.php");
  exit();
}

if (isset($_GET["logout"])) {

  session_destroy();

  header("Location: login.php");
  exit();

}

$Rides->autoArchiveRides();
//Check if forms are filled
$start_location = "";
$start_time = "";
$arrival_location = "";
$arrival_time = "";
$free_seats = "";
$price = "";

$emptyStartL = "*";
$emptyStartT = "*";
$emptyArrivalL = "*";
$emptyArrivalT = "*";
$emptySeats = "*";

if(isset($_GET["register"])){

  $Rides->registertoride($_GET["register"]);

  header("Location: data.php");
  exit();

}

if (isset ($_POST["start_location"])) {
    if (empty ($_POST["start_location"])) {
        $emptyStartL = "* Please fill in starting location!";
    } else {
        $start_location = $Helper->cleanInput($_POST["start_location"]);
    }
}

if (isset ($_POST["start_time"])) {
    if (empty ($_POST["start_time"])) {
        $emptyStartT = "* Please fill in start time!";
    } else {
        $start_time = $Helper->cleanInput($_POST["start_time"]);
    }
}

if (isset ($_POST["arrival_location"])) {
    if (empty ($_POST["arrival_location"])) {
        $emptyArrivalL = "* Please fill in arrival location!";
    } else {
        $arrival_location = $Helper->cleanInput($_POST["arrival_location"]);
    }
}

if (isset ($_POST["arrival_time"])) {
    if (empty ($_POST["arrival_time"])) {
        $emptyArrivalT = "* Please fill in arrival time!";
    } else {
        $arrival_time = $Helper->cleanInput($_POST["arrival_time"]);
    }
}

if (isset ($_POST["free_seats"])) {
    if (empty ($_POST["free_seats"])) {
        $emptySeats = "* Please fill in number of seats!";
    } else {
        $free_seats = $Helper->cleanInput($_POST["free_seats"]);
    }
}

if(isset ($_POST["price"])) {

  $price = $Helper->cleanInput($_POST["price"]);
}

//If forms are filled
if (isset($_POST["start_location"]) &&
isset($_POST["start_time"]) &&
isset($_POST["arrival_location"]) &&
isset($_POST["arrival_time"]) &&
isset($_POST["free_seats"]) &&

!empty($_POST["start_location"]) &&
!empty($_POST["start_time"]) &&
!empty($_POST["arrival_location"]) &&
!empty($_POST["arrival_time"]) &&
!empty($_POST["free_seats"]))


{
    //echo = "Saved";
    $Rides->save($start_location, $start_time, $arrival_location,
    $arrival_time, $free_seats, $price);
    header("Location: data.php");
    exit();
 }

 if ( isset($_POST["get"]) &&
   !empty($_POST["get"])
   ) {

   echo $_POST["get"];
   $upcomingRides->get($Helper->cleaninput($_POST["get"]));

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

$upcomingRides = $Rides->get($r, $sort, $order);

?>
<?php require("../header.php"); ?>

<div class="container">


  <div class="col-sm-4 col-md-3 col-md-8">

    <h1>TLU CarPooling</h1>

    <p>

        Welcome <?=$_SESSION["userEmail"];?>!
        <br>
        <h5><a href="?logout=1">Log out</a></h5>

        <h5><a href="user.php">User page</a></h5>

        <h5><a href="feedback.php">View feedback</a></h5>
    </p>

    <form>
      <h2>Search </h2>
      <div class ="form-group">
      <input class = "form-control" type="search" name="r" value="<?=$r;?>">
      </div>
      <input class="btn btn-sm hidden-xs" type="submit" value="Search">
      <input class="btn btn-sm btn-block visible-xs-block" type="submit" value="Search">
    </form>

    <h2>Register a ride</h2>
    <form method="POST" >

    <label>Start location</label> <?php echo $emptyStartL; ?>
    <div class ="form-group">
      <input class = "form-control" name="start_location" type="text" value="<?=$start_location;?>">
    </div>

    <label>Start time</label> <?php echo $emptyStartT; ?>
    <div class ="form-group">
    <input class = "form-control" id="datetimepicker" name="start_time" type="text" value="<?=$start_time;?>">
    </div>

    <label>Arrival location</label> <?php echo $emptyArrivalL; ?>
    <div class ="form-group">
    <input class = "form-control" name="arrival_location" type="text" value="<?=$arrival_location;?>">
    </div>

    <label>Arrival time</label> <?php echo $emptyArrivalT; ?>
    <div class ="form-group">
    <input class = "form-control" id="datetimepickerarrival" name="arrival_time" type="text" value="<?=$arrival_time;?>">
    </div>

    <label>Free seats</label> <?php echo $emptySeats; ?>
    <div class ="form-group">
    <input class = "form-control" name="free_seats" type="number" value="<?=$free_seats;?>">
    </div>

    <label>Price</label>
    <div class ="form-group">
    <input class = "form-control" name="price" type="number">
    </div>

      <input class="btn btn-sm hidden-xs" type="submit" value="Submit">
      <input class="btn btn-sm btn-block visible-xs-block" type="submit" value="Submit">
    <br><br>
    </form>
    <script type="text/javascript">

        jQuery('#datetimepicker').datetimepicker({
      lang:'et',
    });
        jQuery('#datetimepickerarrival').datetimepicker();
    </script>


</div>


<?php

  $html = "<div class='col-md-8'>";
    $html = "<div class='table'>";
    $html = "<table class='table-striped table-condensed'>";
      $html .= "<h2>Find a ride</h2>";
    //$html .= "<br>";
        $html .= "<tr>";
            //User Email related
        		$orderEmail = "ASC";
        		$arr="&darr;";
        		if (isset($_GET["order"]) &&
        		$_GET["order"] == "ASC" &&
        		$_GET["sort"] == "email") {

        			$orderEmail = "DESC";
        			$arr="&uarr;";
        		}

        			$html .= "<th>
        			<a href='?q=".$r."&sort=email&order=".$orderEmail."'>

        			Email ".$arr."

        			</a>

        			</th>";

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

      	  				$orderArrival_location = "ASC";
      						$arr="&darr;";
      	  				if (isset($_GET["order"]) &&
      	  				$_GET["order"] == "ASC" &&
      	  				$_GET["sort"] == "arrival_location ") {

      	  					$orderArrival_location  = "DESC";
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

      									$orderPrice= "ASC";
      									$arr="&darr;";
      									if (isset($_GET["order"]) &&
      									$_GET["order"] == "ASC" &&
      									$_GET["sort"] == "price") {

      										$orderPrice = "DESC";
      										$arr="&uarr;";
                        }
                          $html .= "<th>
        									<a href='?q=".$r."&sort=price&order=".$orderPrice."'>

        								  Price ".$arr."
        									</a>

        									</th>";

                          $html .= "<th>

        								  Register

        									</a>

        									</th>";



        $html .= "</tr>";

        //iga liikme kohta massiivis
        foreach ($upcomingRides as $r) {

            $html .= "<tr>";
                $html .= "<td>".$r->email."</td>";
                $html .= "<td>".$r->start_location."</td>";
                $html .= "<td>".$r->start_time."</td>";
                $html .= "<td>".$r->arrival_location."</td>";
                $html .= "<td>".$r->arrival_time."</td>";
                $html .= "<td>".$r->free_seats."</td>";
                $html .= "<td>".$r->price."</td>";
                $html .= "<td><a href='?register=".$r->id."'>Ride ".$r->id."
                <span class='glyphicon glyphicon-plus-sign'></span></a></td>";
            $html .= "</tr>";

        }

        $html .= "</table>";
      $html .= "</div>";
  $html .= "</div>";

    echo $html;

    ?>
</div>
<?php require("../footer.php"); ?>

<?php
class Rides {

  private $connection;

  //käivitatakse siis kui on = new User(see j6uab siia)
  function __construct($mysqli) {
    //this viitab sellele klassile ja selle klassi muutujale

    $this->connection = $mysqli;
  }
/*
      SELECT id, user_id, start_location, start_time, arrival_location,
      arrival_time, free_seats, price, added
      FROM cp_rides

*/

  function get($r, $sort, $order) {

    $allowedSort = ["email", "start_location", "start_time",
    "arrival_location", "arrival_time", "free_seats", "price"];

    if(!in_array ($sort, $allowedSort)) {
      $sort = "id";
    }

    $orderBy = "ASC";


  if($order == "DESC") {
    $orderBy = "DESC";
  }


    if ($r != "") {
      //echo "Otsin: ".$r;
      $stmt = $this->connection->prepare("
      SELECT cp_rides.id, cp_rides.user_id, cp_rides.start_location,
      cp_rides.start_time, cp_rides.arrival_location, cp_rides.arrival_time,
      cp_rides.free_seats, cp_rides.price, cp_rides.added, cp_users.email
      FROM cp_rides
      JOIN cp_users ON cp_rides.user_id=cp_users.id
      WHERE cp_rides.id = ? OR (cp_rides.user_id LIKE ? OR cp_rides.start_location LIKE ?
      OR cp_rides.start_time LIKE ? OR cp_rides.arrival_location LIKE ? OR
      cp_rides.arrival_time LIKE ? OR cp_rides.free_seats LIKE ? OR cp_rides.price LIKE ?
      OR cp_rides.added LIKE ? OR cp_users.email LIKE ?) AND deleted IS NULL
      ORDER BY $sort $orderBy
      ");

      $searchWord = "%".$r."%";
      $stmt->bind_param("ssssssssss", $searchWord, $searchWord,
      $searchWord, $searchWord, $searchWord, $searchWord,
      $searchWord, $searchWord, $searchWord, $searchWord);

    } else {
    $stmt = $this->connection->prepare("
    SELECT cp_rides.id, cp_rides.user_id, cp_rides.start_location,
    cp_rides.start_time, cp_rides.arrival_location, cp_rides.arrival_time,
    cp_rides.free_seats, cp_rides.price, cp_rides.added, cp_users.email
    FROM cp_rides
    JOIN cp_users ON cp_rides.user_id=cp_users.id
    WHERE deleted is NULL
    ORDER BY $sort $orderBy
    ");
  }
    echo $this->connection->error;

    $stmt->bind_result($id, $user_id, $start_location, $start_time,
    $arrival_location, $arrival_time, $free_seats, $price, $added, $email);
    $stmt->execute();

    //tekitan massiivi
    $result = array();

    // tee seda seni, kuni on rida andmeid
    // mis vastab select lausele
    while ($stmt->fetch()) {

      //tekitan objekti
      $upcomingRides = new StdClass();

      $upcomingRides->id = $id;
      $upcomingRides->user_id = $user_id;
      $upcomingRides->start_location = $start_location;
      $upcomingRides->start_time = $start_time;
      $upcomingRides->arrival_location = $arrival_location;
      $upcomingRides->arrival_time = $arrival_time;
      $upcomingRides->free_seats = $free_seats;
      $upcomingRides->price = $price;
      $upcomingRides->added = $added;
      $upcomingRides->email = $email;

      array_push($result, $upcomingRides);
    }

    $stmt->close();

    return $result;
  }




  function getUser($r, $sort, $order) {

    $allowedSort = ["id", "start_location", "start_time",
    "arrival_location", "arrival_time", "free_seats", "price",
    "name", "email"];

    if(!in_array ($sort, $allowedSort)) {
      $sort = "id";
    }

    $orderBy = "ASC";


  if($order == "DESC") {
    $orderBy = "DESC";
  }

  //echo "Sorteerin: ".$sort." ".$orderBy." ";

    if ($r != "") {

      $stmt = $this->connection->prepare("
      SELECT cp_rides.id, cp_rides.start_location,
      cp_rides.start_time, cp_rides.arrival_location,
      cp_rides.arrival_time, cp_rides.free_seats, cp_rideusers.user_id,
      cp_users.name, cp_users.email
      FROM cp_rides
      LEFT JOIN cp_rideusers ON cp_rides.id=cp_rideusers.ride_id
      LEFT JOIN cp_users ON cp_users.id=cp_rideusers.user_id
      WHERE cp_rides.user_id = ? AND cp_rides.deleted IS NULL AND cp_rideusers.deleted IS NULL
        AND (cp_rides.id LIKE ? OR cp_rides.start_location LIKE ? OR cp_rides.start_time LIKE ?
        OR cp_rides.arrival_location LIKE ? OR cp_rides.arrival_time LIKE ?
        OR cp_rides.free_seats LIKE ? OR cp_users.name LIKE ? OR cp_users.email LIKE ?)
        ORDER BY $sort $orderBy
      ");

      $searchWord = "%".$r."%";
      $stmt->bind_param("issssssss", $_SESSION["userId"], $searchWord, $searchWord, $searchWord, $searchWord,
      $searchWord, $searchWord, $searchWord, $searchWord);

    } else {

    $stmt = $this->connection->prepare("
    SELECT cp_rides.id, cp_rides.start_location,
    cp_rides.start_time, cp_rides.arrival_location,
    cp_rides.arrival_time, cp_rides.free_seats, cp_rideusers.user_id,
    cp_users.name, cp_users.email
    FROM cp_rides
    LEFT JOIN cp_rideusers ON cp_rides.id=cp_rideusers.ride_id
    LEFT JOIN cp_users ON cp_users.id=cp_rideusers.user_id
    WHERE cp_rides.user_id = ? AND cp_rides.deleted IS NULL AND cp_rideusers.deleted IS NULL
    ORDER BY $sort $orderBy
    ");

    echo $this->connection->error;
    $stmt->bind_param("i", $_SESSION["userId"]);
  }
    $stmt->bind_result($ride_id, $start_location, $start_time, $arrival_location,
    $arrival_time, $free_seats, $guest_id, $guest_name, $guest_email);
    $stmt->execute();

    //tekitan objekti
    $results = array();
    //tsykli sisu tehakse nii mitu korda, mitu rida
    //SQL lausega tuleb
    while ($stmt->fetch()) {

      $r = new StdClass();
      $r->ride_id = $ride_id;
      $r->start_location = $start_location;
      $r->start_time = $start_time;
      $r->arrival_location = $arrival_location;
      $r->arrival_time = $arrival_time;
      $r->free_seats = $free_seats;
      $r->guest_id = $guest_id;
      $r->guest_name = $guest_name;
      $r->guest_email = $guest_email;

      array_push($results, $r);
    }

    $stmt->close();
    return $results; }

    function getUserPastRides($r, $sort, $order) {

      $allowedSort = ["id", "start_location", "start_time",
      "arrival_location", "arrival_time", "free_seats", "price",
      "name", "email"];

      if(!in_array ($sort, $allowedSort)) {
        $sort = "id";
      }

      $orderBy = "ASC";


    if($order == "DESC") {
      $orderBy = "DESC";
    }

    //echo "Sorteerin: ".$sort." ".$orderBy." ";

      if ($r != "") {

        $stmt = $this->connection->prepare("
        SELECT cp_rides.id, cp_rides.start_location,
        cp_rides.start_time, cp_rides.arrival_location,
        cp_rides.arrival_time, cp_rides.free_seats, cp_rideusers.user_id,
        cp_users.name, cp_users.email
        FROM cp_rides
        LEFT JOIN cp_rideusers ON cp_rides.id=cp_rideusers.ride_id
        LEFT JOIN cp_users ON cp_users.id=cp_rideusers.user_id
        WHERE cp_rides.user_id = ? AND cp_rides.start_time < NOW() AND cp_rides.deleted IS NOT NULL
          AND (cp_rides.id LIKE ? OR cp_rides.start_location LIKE ? OR cp_rides.start_time LIKE ?
          OR cp_rides.arrival_location LIKE ? OR cp_rides.arrival_time LIKE ?
          OR cp_rides.free_seats LIKE ? OR cp_users.name LIKE ? OR cp_users.email LIKE ?)
          ORDER BY $sort $orderBy
        ");

        $searchWord = "%".$r."%";
        $stmt->bind_param("issssssss", $_SESSION["userId"], $searchWord, $searchWord, $searchWord, $searchWord,
        $searchWord, $searchWord, $searchWord, $searchWord);

      } else {

      $stmt = $this->connection->prepare("
      SELECT cp_rides.id, cp_rides.start_location,
      cp_rides.start_time, cp_rides.arrival_location,
      cp_rides.arrival_time, cp_rides.free_seats, cp_rideusers.user_id,
      cp_users.name, cp_users.email
      FROM cp_rides
      LEFT JOIN cp_rideusers ON cp_rides.id=cp_rideusers.ride_id
      LEFT JOIN cp_users ON cp_users.id=cp_rideusers.user_id
      WHERE cp_rides.user_id = ? AND cp_rides.start_time < NOW() AND cp_rides.deleted IS NOT NULL
      ORDER BY $sort $orderBy
      ");

      echo $this->connection->error;
      $stmt->bind_param("i", $_SESSION["userId"]);
    }
      $stmt->bind_result($ride_id, $start_location, $start_time, $arrival_location,
      $arrival_time, $free_seats, $guest_id, $guest_name, $guest_email);
      $stmt->execute();

      //tekitan objekti
      $results = array();
      //tsykli sisu tehakse nii mitu korda, mitu rida
      //SQL lausega tuleb
      while ($stmt->fetch()) {

        $r = new StdClass();
        $r->ride_id = $ride_id;
        $r->start_location = $start_location;
        $r->start_time = $start_time;
        $r->arrival_location = $arrival_location;
        $r->arrival_time = $arrival_time;
        $r->free_seats = $free_seats;
        $r->guest_id = $guest_id;
        $r->guest_name = $guest_name;
        $r->guest_email = $guest_email;

        array_push($results, $r);
      }

      $stmt->close();
      return $results; }

  function getPassenger($r, $sort, $order) {

    $allowedSort = ["rde_id", "start_location", "start_time",
    "arrival_location", "arrival_time", "free_seats", "price",
    "name", "email"];

    if(!in_array ($sort, $allowedSort)) {
      $sort = "ride_id";
    }

    $orderBy = "ASC";


  if($order == "DESC") {
    $orderBy = "DESC";
  }

  if ($r != "") {

    $stmt = $this->connection->prepare("
    SELECT cp_rideusers.ride_id, cp_rides.start_location,
    cp_rides.start_time, cp_rides.arrival_location,
    cp_rides.arrival_time, cp_rides.free_seats, cp_users.name, cp_users.email
    FROM cp_rides
    JOIN cp_users ON cp_users.id=cp_rides.user_id
    JOIN cp_rideusers ON cp_rideusers.ride_id=cp_rides.id
    WHERE cp_rideusers.user_id = ? AND cp_rideusers.deleted IS NULL AND cp_rides.deleted IS NULL
      AND (cp_rideusers.ride_id LIKE ? OR cp_rides.start_location LIKE ? OR cp_rides.start_time LIKE ?
      OR cp_rides.arrival_location LIKE ? OR cp_rides.arrival_time LIKE ?
      OR cp_rides.free_seats LIKE ? OR cp_users.name LIKE ? OR cp_users.email LIKE ?)
      ORDER BY $sort $orderBy
    ");

    $searchWord = "%".$r."%";
    $stmt->bind_param("issssssss", $_SESSION["userId"], $searchWord, $searchWord, $searchWord, $searchWord,
    $searchWord, $searchWord, $searchWord, $searchWord);

  } else {

    $stmt = $this->connection->prepare("
    SELECT cp_rideusers.ride_id, cp_rides.start_location,
    cp_rides.start_time, cp_rides.arrival_location,
    cp_rides.arrival_time, cp_rides.free_seats, cp_users.name, cp_users.email
    FROM cp_rides
    JOIN cp_users ON cp_users.id=cp_rides.user_id
    JOIN cp_rideusers ON cp_rideusers.ride_id=cp_rides.id
    WHERE cp_rideusers.user_id = ? AND cp_rideusers.deleted IS NULL AND cp_rides.deleted IS NULL
    ORDER BY $sort $orderBy
    ");

    echo $this->connection->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
    }
    $stmt->bind_result($ride_id, $start_location, $start_time, $arrival_location,
    $arrival_time, $free_seats, $driver_name, $driver_email);
    $stmt->execute();

    //tekitan objekti
    $results = array();
    //tsykli sisu tehakse nii mitu korda, mitu rida
    //SQL lausega tuleb
    while ($stmt->fetch()) {

      $r = new StdClass();
      $r->ride_id = $ride_id;
      $r->start_location = $start_location;
      $r->start_time = $start_time;
      $r->arrival_location = $arrival_location;
      $r->arrival_time = $arrival_time;
      $r->free_seats= $free_seats;
      $r->driver_name= $driver_name;
      $r->driver_email = $driver_email;

      //echo $age."<br>";
      //echo $color."<br>";
      array_push($results, $r);
    }

    $stmt->close();
    return $results;
  }


  function getPassengerPastRides($r, $sort, $order) {

    $allowedSort = ["rde_id", "start_location", "start_time",
    "arrival_location", "arrival_time", "free_seats", "price",
    "name", "email"];

    if(!in_array ($sort, $allowedSort)) {
      $sort = "ride_id";
    }

    $orderBy = "ASC";


  if($order == "DESC") {
    $orderBy = "DESC";
  }

  if ($r != "") {

    $stmt = $this->connection->prepare("
    SELECT cp_rideusers.ride_id, cp_rides.start_location,
    cp_rides.start_time, cp_rides.arrival_location,
    cp_rides.arrival_time, cp_rides.free_seats, cp_users.name, cp_users.email
    FROM cp_rides
    JOIN cp_users ON cp_users.id=cp_rides.user_id
    JOIN cp_rideusers ON cp_rideusers.ride_id=cp_rides.id
    WHERE cp_rideusers.user_id = ? AND cp_rides.start_time < NOW() AND cp_rides.deleted IS NOT NULL
      AND (cp_rideusers.ride_id LIKE ? OR cp_rides.start_location LIKE ? OR cp_rides.start_time LIKE ?
      OR cp_rides.arrival_location LIKE ? OR cp_rides.arrival_time LIKE ?
      OR cp_rides.free_seats LIKE ? OR cp_rides.user_id LIKE ? OR cp_users.name LIKE ? OR cp_users.email LIKE ?)
      ORDER BY $sort $orderBy
    ");

    $searchWord = "%".$r."%";
    $stmt->bind_param("isssssssss", $_SESSION["userId"], $searchWord, $searchWord, $searchWord, $searchWord, $searchWord,
    $searchWord, $searchWord, $searchWord, $searchWord);

  } else {

    $stmt = $this->connection->prepare("
    SELECT cp_rideusers.ride_id, cp_rides.start_location,
    cp_rides.start_time, cp_rides.arrival_location,
    cp_rides.arrival_time, cp_rides.free_seats, cp_rides.user_id, cp_users.name, cp_users.email
    FROM cp_rides
    JOIN cp_users ON cp_users.id=cp_rides.user_id
    JOIN cp_rideusers ON cp_rideusers.ride_id=cp_rides.id
    WHERE cp_rideusers.user_id = ? AND cp_rides.start_time < NOW() AND cp_rides.deleted IS NOT NULL
    ORDER BY $sort $orderBy
    ");

    echo $this->connection->error;
    $stmt->bind_param("i", $_SESSION["userId"]);
    }
    $stmt->bind_result($ride_id, $start_location, $start_time, $arrival_location,
    $arrival_time, $free_seats, $driver_id, $driver_name, $driver_email);
    $stmt->execute();

    //tekitan objekti
    $results = array();
    //tsykli sisu tehakse nii mitu korda, mitu rida
    //SQL lausega tuleb
    while ($stmt->fetch()) {

      $r = new StdClass();
      $r->ride_id = $ride_id;
      $r->start_location = $start_location;
      $r->start_time = $start_time;
      $r->arrival_location = $arrival_location;
      $r->arrival_time = $arrival_time;
      $r->free_seats= $free_seats;
      $r->driver_id= $driver_id;
      $r->driver_name= $driver_name;
      $r->driver_email = $driver_email;

      //echo $age."<br>";
      //echo $color."<br>";
      array_push($results, $r);
    }

    $stmt->close();
    return $results;
  }


  function save ($start_location, $start_time, $arrival_location,
  $arrival_time, $free_seats, $price) {

		$stmt = $this->connection->prepare("INSERT INTO cp_rides (user_id, start_location, start_time, arrival_location,
    arrival_time, free_seats, price) VALUES (?, ?, ?, ?, ?, ?, ?)");

		echo $this->connection->error;

		$stmt->bind_param("issssii", $_SESSION["userId"], $start_location, $start_time, $arrival_location,
    $arrival_time, $free_seats, $price);

		if($stmt->execute()) {
			echo "Success";
		} else {
		 	echo "ERROR ".$stmt->error;
		}

		$stmt->close();

	}


  function registertoride($id){


    $stmt = $this->connection->prepare("SELECT ride_id FROM cp_rideusers WHERE user_id=? AND ride_id = ? AND deleted IS NULL");
    echo $this->connection->error;
    $stmt->bind_param("ii", $_SESSION["userId"], $id );
    $stmt->execute();

    if($stmt->fetch()){
      echo "Already registered";
      return;
    }

    $stmt = $this->connection->prepare("INSERT INTO cp_rideusers (user_id, ride_id) VALUES(?,?)");
    echo $this->connection->error;
    $stmt->bind_param("ii", $_SESSION["userId"], $id );

    if(!$stmt->execute()){
      echo "Unsuccessful";
      return;
    }

    $stmt->close();

    $stmt = $this->connection->prepare("UPDATE cp_rides SET free_seats=free_seats-1
      WHERE id=?");

    $stmt->bind_param("i", $id);
    // kas õnnestus salvestada
    if($stmt->execute()){
      // õnnestus
      echo "Success!";
    }

    $stmt->close();

  }

  function autoArchiveRides() {

    $stmt = $this->connection->prepare("UPDATE cp_rides SET deleted=NOW() WHERE start_time < NOW() AND deleted IS NULL");
    echo $this->connection->error;
    $stmt->execute();

    $stmt->close();

  }

  function deleteRide($ride_id){


      $stmt = $this->connection->prepare("UPDATE cp_rides SET deleted=NOW() WHERE id=? AND user_id = ? AND deleted IS NULL");
      $stmt->bind_param("ii",$ride_id, $_SESSION["userId"]);

      $stmt->execute();

      $stmt->close();

      $stmt = $this->connection->prepare("UPDATE cp_rideusers SET deleted=NOW() WHERE ride_id=? AND deleted IS NULL");
      $stmt->bind_param("i",$ride_id);

      $stmt->execute();

      $stmt->close();

    }

  function cancelRegistration($ride_id){

    $stmt = $this->connection->prepare("UPDATE cp_rideusers SET deleted=NOW() WHERE ride_id=? AND user_id=? AND deleted IS NULL");
    $stmt->bind_param("ii",$ride_id, $_SESSION["userId"]);

    $stmt->execute();

    $stmt->close();

    $stmt = $this->connection->prepare("UPDATE cp_rides SET free_seats=free_seats+1
    WHERE id=?");
    $stmt->bind_param("i", $ride_id);

    $stmt->execute();

    $stmt->close();

  }
}
?>

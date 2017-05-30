<?php
class User
{

    private $connection;

    function __construct($mysqli)
    {

        $this->connection = $mysqli;
    }

    //Program functions

    function signup($email, $password, $name, $surname) {

        $stmt = $this->connection->prepare("INSERT INTO cp_users (email, password, name, surname) VALUES (?, ?, ?, ?)");
        echo $this->connection->error;

        $stmt->bind_param("ssss", $email, $password, $name, $surname);

        if ( $stmt->execute() ) {
            echo "Success!";
        } else {
            echo "ERROR ".$stmt->error;


    }
}
    function login($email, $password) {

        $notice = "";


        $stmt = $this->connection->prepare("
			SELECT id, email, password, created
			FROM cp_users
			WHERE email = ?
		");

        echo $this->connection->error;

        //asendan küsimärgi
        $stmt->bind_param("s", $email);

        //rea kohta tulba väärtus
        $stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);

        $stmt->execute();

        //ainult SELECT'i puhul
        if($stmt->fetch()) {
            // oli olemas, rida käes
            //kasutaja sisestas sisselogimiseks
            $hash = hash("sha512", $password);

            if ($hash == $passwordFromDb) {
                echo "User $id logged in";

                $_SESSION["userId"] = $id;
                $_SESSION["userEmail"] = $emailFromDb;
                //echo "ERROR";

                header("Location: data.php");
                exit();

            } else {
                $notice = "Incorrect password!";
            }


        } else {

            //ei olnud ühtegi rida
            $notice = "Username linked with ".$email." doesn't exist";
        }

        $stmt->close();

        return $notice;

    }

    function userFeedback($user_id, $rating, $feedback) {
      $stmt = $this->connection->prepare("INSERT INTO cp_feedback (user_id, poster_id, rating, feedback) VALUES (?, ?, ?, ?)");
      echo $this->connection->error;
      $stmt->bind_param("iiis", $user_id, $_SESSION["userId"], $rating, $feedback);

      if ( $stmt->execute() ) {
          echo "Success!";
      } else {
          echo "ERROR ".$stmt->error;
        }

      }

    function getFeedback($r, $sort, $order) {

      $allowedSort = ["id", "user_id", "user_email", "poster_id",
      "rating", "feedback", "added"];

      if(!in_array ($sort, $allowedSort)) {
        $sort = "id";
      }

      $orderBy = "ASC";


    if($order == "DESC") {
      $orderBy = "DESC";
    }

    if ($r != "") {

      $stmt = $this->connection->prepare("
      SELECT cp_feedback.id, cp_feedback.user_id, cp_users.email,
      cp_feedback.poster_id, cp_feedback.rating,
      cp_feedback.feedback, cp_feedback.added
      FROM cp_feedback
      LEFT JOIN cp_users ON cp_users.id=cp_feedback.user_id
      WHERE cp_feedback.deleted IS NULL
        AND (cp_feedback.id LIKE ? OR cp_feedback.user_id LIKE ? OR cp_users.email LIKE ? OR cp_feedback.poster_id LIKE ? OR cp_feedback.rating LIKE ?
        OR cp_feedback.feedback LIKE ? OR cp_feedback.added LIKE ?)
        ORDER BY $sort $orderBy
      ");

      $searchWord = "%".$r."%";
      $stmt->bind_param("sssssss", $searchWord, $searchWord, $searchWord, $searchWord, $searchWord,
      $searchWord, $searchWord);

    } else {

    $stmt = $this->connection->prepare("
    SELECT cp_feedback.id, cp_feedback.user_id, cp_users.email,
    cp_feedback.poster_id, cp_feedback.rating,
    cp_feedback.feedback, cp_feedback.added
    FROM cp_feedback
    LEFT JOIN cp_users ON cp_users.id=cp_feedback.user_id
    WHERE cp_feedback.deleted IS NULL
    ORDER BY $sort $orderBy
    ");

    echo $this->connection->error;
  }
    $stmt->bind_result($feedback_id, $user_id, $user_email, $poster_id, $rating,
    $feedback, $added);
    $stmt->execute();

    //tekitan objekti
    $results = array();
    //tsykli sisu tehakse nii mitu korda, mitu rida
    //SQL lausega tuleb
    while ($stmt->fetch()) {

      $r = new StdClass();
      $r->feedback_id = $feedback_id;
      $r->user_id = $user_id;
      $r->user_email = $user_email;
      $r->poster_id = $poster_id;
      $r->rating = $rating;
      $r->feedback = $feedback;
      $r->added = $added;

      array_push($results, $r);
    }

    $stmt->close();
    return $results; }
}
?>

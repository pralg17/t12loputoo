<?php
	require("C:/xampp/config.php");

	session_start();
	$database = "if16_brigitta";
		//var_dump(hash('sha512', 'qwerty666')); exit;

	$loginEmailError = "";
	$loginEmail = "";

	if (empty($_POST["loginEmail"])) {

		$loginEmailError = "you have to enter your email";

	} else {

		$loginEmail = $_POST["loginEmail"];
	}
	function login($email, $password) {

		$notice = "";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, email, password FROM story_admin WHERE email=? ");

		$stmt->bind_param("s", $email);


		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);

		$stmt->execute();


		if ($stmt->fetch()) {



			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				//�nnestus
				echo "user ".$id." logged in";

				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;

				header("Location: short_story_dump.php");
				exit();

			} else {
				$notice = "wrong password";
			}



		} else {

			$notice = "you're not the admin..";

		}
		return $notice;
	}

$notice = "";
	if (  isset($_POST["loginEmail"]) &&
		  isset($_POST["loginPassword"]) &&
		  !empty($_POST["loginEmail"]) &&
		  !empty($_POST["loginPassword"])
		) {
			 $notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>admin</title>
	</head>
	<body>
	<h1>this is where the fun begins</h1>

		<p style="color:red;"><?php echo $notice; ?></p>
		<form method="POST">
			<input placeholder="username" name="loginEmail" type="text" value="<?php if(isset($_POST['loginEmail'])){ echo $_POST['loginEmail']; } ?>">

			<br><br>

			<input placeholder="password" name="loginPassword" type="password">

			<br><br>

			<input type="submit" value="log in">


		</form>
	</body>
</html>

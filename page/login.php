<?php

	require("../functions.php");

	require("../class/User.class.php");
	$User = new User($mysqli);

	// kui on juba sisse loginud siis suunan data lehele
	if (isset($_SESSION["userId"])){

		header("Location: data.php");
		exit();

	}

	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$signupGender = "";


	if( isset( $_POST["signupEmail"] ) ){

		if( empty( $_POST["signupEmail"] ) ){

			$signupEmailError = "See väli on kohustuslik";

		} else {

			$signupEmail = $_POST["signupEmail"];

		}

	}

	if( isset( $_POST["signupPassword"] ) ){

		if( empty( $_POST["signupPassword"] ) ){

			$signupPasswordError = "Parool on kohustuslik";

		} else {

			if ( strlen($_POST["signupPassword"]) < 8 ) {

				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
			}
		}
	}

	if( isset( $_POST["signupGender"] ) ){

		if(!empty( $_POST["signupGender"] ) ){

			$signupGender = $_POST["signupGender"];
		}
	}

	// peab olema email ja parool

	if ( isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&
		 $signupEmailError == "" &&
		 empty($signupPasswordError)
		) {

		// salvestame ab'i
		echo "Salvestan... <br>";

		echo "email: ".$signupEmail."<br>";
		echo "password: ".$_POST["signupPassword"]."<br>";

		$password = hash("sha512", $_POST["signupPassword"]);

		echo "password hashed: ".$password."<br>";

		// KASUTAN FUNKTSIOONI
		$signupEmail = $Helper->cleanInput($signupEmail);

		$User->signUp($signupEmail, $Helper->cleanInput($password));


	}


	$error ="";
	if ( isset($_POST["loginEmail"]) &&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"])
	  ) {

		$error = $User->login($Helper->cleanInput($_POST["loginEmail"]), $Helper->cleanInput($_POST["loginPassword"]));
	}


?>
<?php?>

<div class="container">

	<div class="row">

		<div class="col-sm-3">


			<h1>Logi sisse</h1>
			<form method="POST">

				<div class="alert alert-danger" role="alert"><?=$error;?></div>

				<label>E-post</label>
				<br>
				<div class="form-group">
					<input class="form-control" name="loginEmail" type="text">
				</div>
				<br><br>

				<input type="password" name="loginPassword" placeholder="Parool">
				<br><br>

				<input class="btn btn-success btn-block visible-xs-block" type="submit" value="Logi sisse">



			</form>

		</div>

		<div class="col-sm-3 col-sm-offset-3">

			<h1>Loo kasutaja</h1>
			<form method="POST">

				<label>E-post</label>
				<br>

				<input name="signupEmail" type="text" value="<?=$signupEmail;?>"> <?=$signupEmailError;?>
				<br><br>

				<?php if($signupGender == "male") { ?>
					<input type="radio" name="signupGender" value="male" checked> Male<br>
				<?php }else { ?>
					<input type="radio" name="signupGender" value="male"> Male<br>
				<?php } ?>

				<?php if($signupGender == "female") { ?>
					<input type="radio" name="signupGender" value="female" checked> Female<br>
				<?php }else { ?>
					<input type="radio" name="signupGender" value="female"> Female<br>
				<?php } ?>
				<br>
				<input type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError; ?>
				<br><br>

				<input type="submit" value="Loo kasutaja">

			</form>
		</div>
	</div>
</div>
<?php?>

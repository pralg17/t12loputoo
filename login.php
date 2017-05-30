<?php

	require("functions.php");	
	
	//kui on juba sisse loginud siis suunan data lehele
	if(isset($_SESSION["userId"])) {
		
		//suunan sisselogimise lehele
		header("Location: data.php");
		exit();
	}
	
	
	//MUUTUJAD
	$signupAge = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$signupGender = "";
	$loginEmailError = "";
	$loginPasswordError = "";
	$ageError = "";
	$loginEmail = "";
	$genderError = "";
	
	//Email
	if(isset($_POST["signupEmail"])){		
		if(empty($_POST["signupEmail"])){			
			$signupEmailError = "See väli on kohustuslik";
		} else {			
			$signupEmail = cleanInput ($_POST["signupEmail"]);			
		}
	}
	
	//Password
		if(isset($_POST["signupPassword"])){			
			if(empty($_POST["signupPassword"])){				
				$signupPasswordError = "Parool on kohustuslik";
			} else {
				if(strlen($_POST["signupPassword"]) < 8)  {					
					$signupPasswordError = "Parool peab vähemalt 8 tähemärki pikk olema";				
				}				
			}			
		}

		if(isset($_POST["signupUsername"])){			
			if(!empty( $_POST["signupUsername"])){
				$signupUsername = cleanInput ($_POST["signupUsername"]);
			}			
			if(empty($_POST["signupUsername"])){				
				$signupUsernameError = "Palun vali kasutajanimi";
			} else {
				if(strlen($_POST["signupUsername"]) < 4)  {					
					$signupUsernameError = "Kasutajanimi peab olema vähemalt 4 tähemärki pikk olema!";
				
				
				}
				
			}			
		
		}
		
		// GENDER
	if( isset( $_POST["signupGender"] ) ){		
		if(!empty( $_POST["signupGender"] ) ){		
			$signupGender = cleanInput ($_POST["signupGender"]);			
		}
		if(empty( $_POST["signupGender"])){
			$genderError = "Vali oma sugu!";
		}
	}

	//Age
	if( isset( $_POST["signupAge"] ) ){
		if(empty($_POST["signupAge"])){
			$ageError = "Palun sisesta oma vanus!";
		} else {
			$signupAge = cleanInput ($_POST["signupAge"]);
		}
	}
		
		if ( isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) &&
		isset($_POST["signupAge"]) &&
		$signupEmailError == "" &&
		empty($signupPasswordError)
		)  {
		
		//salvestame ab'i
		echo "email: ".$signupEmail."<br>";
		echo "password: ".cleanInput($_POST["signupPassword"])."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "password hashed: ".$password."<br>";
		echo "gender: ".$signupGender."<br>";
		echo "age: ".$signupAge."<br>";
			
		
		// KASUTAN FUNKTSIOONI
		signUp($signupEmail, cleanInput($password), $signupGender, $signupAge);
		
	}
		$error ="";
		if(isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) &&
			!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])
			){
				//error tuleb functions'ist siia
				$loginEmail = cleanInput($_POST["loginEmail"]);
				$loginPassword = cleanInput($_POST["loginPassword"]);
				$error = login($loginEmail, $loginPassword);
				
			}
		
		
?>


<!DOCTYPE html>
<html>
<head>
<title>Logi sisse või loo kasutaja</title>
</head>
<body>

	<h1>Logi sisse</h1>
	<form method="POST">
		<p style="color:red;"><?=$error;?></p>
				
		<input name="loginEmail" type="text" placeholder="E-post" value="<?=$loginEmail;?>">
		<br><br>
	
		<input name="loginPassword" placeholder="Parool" type="password">
		<br><br>
		
		<input type="submit" value="Logi sisse">
	
	
	</form>
	
	<h1>Loo kasutaja</h1>
	<form method="POST">
		
		
		<input name="signupEmail" type="text" placeholder="E-post" value="<?=$signupEmail;?>" placeholder="E-post"> <?=$signupEmailError;?>
		<br><br>
	
		<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
		<br><br>
		
		<?php if($signupGender == "Mees") { ?>
			<input type="radio" name="signupGender" value="Mees" checked> Mees<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Mees"> Mees<br>
		<?php } ?>
		
		<?php if($signupGender == "Naine") { ?>
			<input type="radio" name="signupGender" value="Naine" checked> Naine<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Naine"> Naine<br>
		<?php } ?>
		
		<?php if($signupGender == "Muu") { ?>
			<input type="radio" name="signupGender" value="Muu" checked> Muu<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Muu"> Muu<br>
		<?php } ?> <?php echo $genderError; ?>
		<br>
		
		Vanus: <input name="signupAge" type="text" size="3" maxlength="3" value="<?=$signupAge;?>"> <?php echo $ageError; ?>  <br><br>
		
		<input type="submit" value="Loo kasutaja">
		<br><br>
		
	
	
	</form>

</body>
</html>
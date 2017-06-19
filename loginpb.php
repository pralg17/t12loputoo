<?php

	require("../../config.php");
	require("functions.php");
	
	
	
	if(isset($_SESSION["userId"])){
		
		header("Location: movies.php");
		exit();
		
	}
	
	$signinemail= "";
	$signinEmailError= "";
	$signinPasswordError= "";
	
	$signupemail = "";
	$signupEmailError= "";
	$signupPasswordError= "";
	$reenterpasswordError= "";
	
	
	
	if(isset($_POST["signupemail"])){
		
		if(empty($_POST["signupemail"])){
			
			$signupEmailError= "See vali on kohustuslik";
			
		}else{
			
			$signupemail = $_POST["signupemail"];
			
		}
		
		
	}
	
	if(isset($_POST["signuppassword"])){
		
		if(empty($_POST["signuppassword"])){
			
			$signupPasswordError= "See vali on kohustuslik";
			
		} else {
			
			if( strlen($_POST["signuppassword"]) <8 ){
			
				$signupPasswordError = "Parool peab olema vahemalt 8 tahemarki pikk";
				
			}
		}
	}
	
	if(isset($_POST["reenterpassword"])){
		
		if($_POST["reenterpassword"] == $_POST["signuppassword"]){
			
			$reenterpasswordError= "";
			
		} else {
			
			$reenterpasswordError= "Parool ei olnud sama";
			
		}
	}
	

	
	
	if(isset($_POST["signupemail"]) &&
		isset($_POST["signuppassword"]) &&
		$signupEmailError=="" &&
		$signupPasswordError==""
		) {
		
		
		
		$password = hash("sha512", $_POST["signuppassword"]);
		
		
		signUp($signupemail, $password);
		
	}
	
	$error="";
	if(isset($_POST["loginemail"]) && isset($_POST["loginpassword"]) &&
		!empty($_POST["loginemail"]) && !empty($_POST["loginpassword"])
		) {
		
		login($_POST["loginemail"], $_POST["loginpassword"]);
		
		
	}
	
	if(isset($_POST["loginemail"])){
		
		if(empty($_POST["loginemail"])){
			
			$signinEmailError= "E-mail on sisestamata!";
			
		}else{
			
			$signinemail = $_POST["loginemail"];
			
		}
	}
	
	if(isset($_POST["loginpassword"])){
		
		if(empty($_POST["loginpassword"])){
			
			$signinPasswordError= "Parool on sisestamata!";
			
		}
	}
	
	
	
?>


<h1>Logi sisse</h1>
<form method="POST">
	<?php if($error!=""){ echo $error; } ?><br>
	
	<input name="loginemail" placeholder="Kasutaja" type="text" value="<?=$signinemail;?>"> <text style="color:red;"><?php echo $signinEmailError; ?></text>
	<br><br>

	<input name="loginpassword" placeholder="Parool" type="password"> <text style="color:red;"><?php echo $signinPasswordError; ?></text>
	<br><br>
		
	<input type="submit" value="Logi Sisse">
</form>

<h1>Loo Kasutaja</h1>
Tärniga väljad on kohustuslikud
<form method="POST">

	<br>
	<b><label>*E-mail:</label></b><br>
	<input name="signupemail" placeholder="example@mail.com" type="text" value="<?=$signupemail;?>"> <text style="color:red;"><?php echo $signupEmailError; ?></text>
	<br><br>

	<b><label>*Parool:</label></b><br>
	<input name="signuppassword" placeholder="********" type="password"> <text style="color:red;"><?php echo $signupPasswordError; ?></text>
	<br><br>
	
	<b><label>*Sisesta parool uuesti:</label></b><br>
	<input name="reenterpassword" placeholder="********" type="password"> <text style="color:red;"><?php echo $reenterpasswordError; ?></text>
	<br><br>
	
	<input type="submit" value="Loo Kasutaja">
	
	
	<br><br><br><br>
	
</form>
<?php 
	//require("../bootstrap.js");
	require("../functions.php");
	require("../Class/user.class.php");
	$user = new user($mysqli);
		
	// kui on juba sisse loginud siis suunan esilehele
	if (isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: frontpage.php");
		exit();
		
	}
		

	// MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$signupAge = "";
	$signupAgeError = "";
	$signupCounty = "";
	$signupCountyError = "";
	$signupRoll = "";
	$signupRollError = "";
	$signupName = "";
	$signupNameError = "";
	
	//Email
	if( isset( $_POST["signupEmail"] ) ){		
		if( empty( $_POST["signupEmail"] ) ){			
			$signupEmailError = "See väli on kohustuslik";			
		} else {
			$signupEmail = $_POST["signupEmail"];			
		}		
	} 
	
	//Password
	if( isset( $_POST["signupPassword"] ) ){		
		if( empty( $_POST["signupPassword"] ) ){			
			$signupPasswordError = "Parool on kohustuslik";			
		} else {
			if ( strlen($_POST["signupPassword"]) < 8 ) {				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";			
			}			
		}		
	}
	
	//Name
	if( isset($_POST["signupName"] ) ){
		if(empty($_POST["signupName"])){
			$signupNameError = "Palun sisesta oma nimi!";
		} else {
			$signupName = ($_POST["signupName"]);
		}
	}
	
	//Age
	if( isset($_POST["signupAge"] ) ){
		if(empty($_POST["signupAge"])){
			$signupAgeError = "Palun sisesta oma vanus!";
		} else {
			$signupAge = ($_POST["signupAge"]);
		}
	}
			
	//County
	if( isset($_POST["signupCounty"] ) ){		
		if(empty($_POST["signupCounty"] ) ){		
			$signupCountyError = "Palun vali maakond, kus asud!";		
		} else {
			$signupCounty = ($_POST["signupCounty"]);
		}
	}

	//Seller/Buyer
	if( isset($_POST["signupRoll"])){
		if(empty($_POST["signupRoll"])){
			$signupRollError = "Vali oma roll selles keskkonnas(Ostja/Müüa)";
		} else {
			$signupRoll = ($_POST["signupRoll"]);
		}		
	}
	
	if ( isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) && 
		 isset($_POST["signupAge"]) &&
		 isset($_POST["signupCounty"]) &&
		 isset($_POST["signupRoll"]) &&
		 isset($_POST["signupName"]) &&
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
		) {
			
				//echo "Salvestan... <br>";
				//echo "email: ".$signupEmail."<br>";
				//echo "password: ".$_POST["signupPassword"]."<br>";
				
				
				
				//echo "password hashed: ".$password."<br>";	
						
				//echo $serverUsername;
				
				// KASUTAN FUNKTSIOONI
				$signupEmail = $Helper->cleanInput($signupEmail);
				
				$password = hash("sha512", $_POST["signupPassword"]);		
				$user->signUp($signupEmail, $Helper->cleanInput($password), $Helper->cleanInput($signupName), $Helper->cleanInput($signupRoll), $Helper->cleanInput($signupAge), $Helper->cleanInput($signupCounty));
	
			}
		
	
	
	$error ="";
	if ( isset($_POST["loginEmail"]) && 
		isset($_POST["loginPassword"]) && 
		!empty($_POST["loginEmail"]) && 
		!empty($_POST["loginPassword"])
	  ) {
		 
		$error = $user->login($Helper->cleanInput($_POST["loginEmail"]), $Helper->cleanInput($_POST["loginPassword"]));		 
		
	}


?>
<?php require("../header.php"); ?>

<div class="container">
  <!-- Trigger the modal with a button -->
  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Logi sisse</button> -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h3>Logi sisse</h3>
        </div>
         <div class="modal-body">
			<div id="errors"></div>
			   <form method="post">
				 <p style="color:red;"><?=$error;?></p>
				 <p><input type="text" class="span3" name="loginEmail" id="email" placeholder="Email"></p>
				 <p><input type="password" class="span3" name="loginPassword" placeholder="Parool"></p>
				 <p><button type="submit" class="btn btn-primary">Logi sisse</button>
				   <a href="#">Unustasid parooli?</a>
				 </p>
			   </form>
         </div>
         <div class="modal-footer">
           Pole veel kasutaja?
           <a href="#" class="btn btn-primary">Registreeri</a>
         </div>
       </div>
	</div>
  </div>
</div>

<div class="container">
	<div class="row">

		<div class="col-md-8 col-md-offset-2">
			<form method="POST">

				<legend class="text-center">Registreeri</legend>



                <fieldset>
                        <div class="form-group col-md-12">

                            <label for="name">Nimi</label>
                            <input class="form-control" name="signupName" type="text" value="<?=$signupName;?>"> <?=$signupNameError;?>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="signupEmail" id="" value="<?=$signupEmail;?>"> <?=$signupEmailError;?>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password">Parool</label>
                            <input type="password" class="form-control" name="signupPassword" id="password" > <?=$signupPasswordError;?>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Age">Vanus</label>
                            <input type="date" class="form-control" name="signupAge" id="vanus" value="<?=$signupAge;?>"> <?=$signupAgeError;?>
                        </div>

					<div class="form-group col-md-6">
						<label for="county">Maakond, kus elate</label>
						<select class="form-control" name="signupCounty" id="county" value="<?=$signupCounty;?>"> <?=$signupCountyError;?>
							<option>Harjumaa</option>
							<option>Ida-Virumaa</option>
							<option>Tartumaa</option>
							<option>Pärnumaa</option>
							<option>Lääne-Virumaa</option>
							<option>Viljandimaa</option>
							<option>Raplamaa</option>
							<option>Võrumaa</option>
							<option>Saaremaa</option>
							<option>Jõgevamaa</option>
							<option>Järvamaa</option>
							<option>Valgamaa</option>
							<option>Põlvamaa</option>
							<option>Läänemaa</option>
							<option>Hiiumaa</option>
						</select>
					</div>

						

						<div class="form-group col-md-6">
							<label for="roll">Teie roll keskkonnas</label>
							<select class="form-control col-md-12" name="signupRoll" id="roll"> <?=$signupRollError;?>
							  <option>Müüa</option>
							  <option>Ostja</option>
							</select>
                        </div>
						<!--<div class="form-group col-md-6">
                            <label for="Roll">Roll (Müüa/Ostja)</label>
                            <input type="text" class="form-control" name="" id="first_name">-->
        


				</fieldset>

				<div class="form-group">
					<div class="col-md-12">
						<div class="checkbox">
							<label>
								<input type="checkbox" value="" id="">
								Nõustun <a href="#">tingimustega</a>.
							</label>
						</div>
					</div>
				</div>


				<div class="form-group">
					<div class="col-md-6">
						<button type="submit" class="btn btn-primary" name="submit" id="submit"> Registreeri <a href="forntpage.php"</a>
						</button>
					</div>
				</div>


			</form>
		</div>
	</div>
</div>
<?php require("../footer.php"); ?>

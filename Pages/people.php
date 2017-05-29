<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);
	
	$upgrade_error="";
	
	$workforce_input_error="";
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	$res=$Resources->getUser ($user_id);
	$levels=$Levels->getUser ($user_id);
	
	foreach($levels as $l){
		$population_work=$l->population_work;
	}
	
	$WorkRes=$Levels->getStep ($population_work);
	
	foreach($res as $r) {
		$workforce=$r->workforce;
		$food=$r->food;
		$stone=$r->stone;
		$coins=$r->coins;
		$iron=$r->iron;
		$wood=$r->wood;
	}
	
	if (isset($_GET["work"])) {
		
		if($stone >= $WorkRes->res*2 and $iron >= $WorkRes->res*2 and $wood >= $WorkRes->res*2){
			$Resources->updateStone($user_id, $WorkRes->res*-2);
			$Resources->updateIron($user_id, $WorkRes->res*-2);
			$Resources->updateWood($user_id, $WorkRes->res*-2);
			$Modifiers->update($user_id, 0, 0, 0, 0, 1, 0);
			$Levels->update($user_id, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0);
			header("Location: people.php");
		} else {
			$upgrade_error="Sul ei ole piisavalt ressursse.";
		}
		
	}
	
	if(isset($_POST['workforce_input']) and isset ($_POST['time_input'])){
		if ($_POST['workforce_input']>=1 and $_POST['workforce_input']<=$workforce and $_POST['workforce_input']*2*$_POST['time_input']<=$food and $_POST['workforce_input']*2*$_POST['time_input']<=$coins){
			$Actions->save($user_id, 'populate', cleanInput($_POST['workforce_input']), cleanInput($_POST['time_input']));
			$Resources->updateWorkforce($user_id, cleanInput($_POST['workforce_input'])*-1);
			$Resources->updateFood($user_id, cleanInput($_POST['workforce_input'])*-2*cleanInput($_POST['time_input']));
			$Resources->updateCoins($user_id, cleanInput($_POST['workforce_input'])*-2*cleanInput($_POST['time_input']));
			header("Location: data.php");
		} else {
			$workforce_input_error="min=1, max=(toojoud voi toit/2 voi raha/2)*sisestatud aeg";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Your people</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>

		<h1>Your people</h1>

		<p>
			Siin saad sa hallata oma rahva ule.<br>
		</p>
		<p>Sisesta mitu inimest soovid paljuemisse rakendada: </p>
		<form method="POST">

			<p>PS! Paljunemine on vaga toidu- ja rahakulukas tegevus.<br>Iga sisestatud inimese kohta on vaja 2 toitu ja 2 raha.</p>

			<select name="time_input">
				<option value="1">1h</option>
				<option value="2">2h</option>
				<option value="3">3h</option>
				<option value="4">4h</option>
				<option value="5">5h</option>
				<option value="6">6h</option>
				<option value="7">7h</option>
			</select>		
			<input name="workforce_input" type="number"> <?php echo $workforce_input_error;?><br>
			<input type="submit" value="Rakenda"><br>
			<button type="submit" name="workforce_input" value="<?php echo $workforce;?>">Rakenda koik (<?php echo $workforce;?>)</button><br>
		</form>
		<p>
			Sinu elumajade tase on <?php echo $population_work;?><br>
			Sul on vaja <?php echo $WorkRes->res*2;?> kivi, <?php echo $WorkRes->res*2;?> rauda ja <?php echo $WorkRes->res*2;?> puitu, et maju uuendada.<br>
			<a href="people.php?work=true">Uuenda!</a> <?php echo $upgrade_error;?><br><br>
		</p>
		<?php require("../layout2.php");?>
	</body>
</html>
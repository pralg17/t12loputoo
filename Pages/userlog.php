<?php
	require("../function.php");

	$user_id=($_SESSION["userId"]);
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}

	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}

	$actionlog=$Actions->getUserlog($user_id);
	$action=$Actions->getUser($user_id);
	
	$html2="<table>";
		$html2 .="<tr>";
			$html2 .="<th>Category</th>";
			$html2 .="<th>Workforce</th>";
			$html2 .="<th>Time</th>";
			$html2 .="<th>Started</th>";
		$html2 .="</tr>";

		foreach($action as $a) {
			$html2 .="<tr>";
				$html2 .="<td>".$a->category."</td>";
				$html2 .="<td>".$a->workforce_input."</td>";
				$html2 .="<td>".$a->time_input." h</td>";
				$html2 .="<td>".$a->created."</td>";
			$html2 .="</tr>";
		}	
	$html2 .="</table>";
	
	$html3="<table>";
		$html3 .="<tr>";
			$html3 .="<th>Category</th>";
			$html3 .="<th>Workforce</th>";
			$html3 .="<th>Time</th>";
			$html3 .="<th>Started</th>";
			$html3 .="<th>Finished</th>";
		$html3 .="</tr>";

		foreach($actionlog as $al) {
			$html3 .="<tr>";
				$html3 .="<td>".$al->category."</td>";
				$html3 .="<td>".$al->workforce_input."</td>";
				$html3 .="<td>".$al->time_input." h</td>";
				$html3 .="<td>".$al->created."</td>";
				$html3 .="<td>".$al->deleted."</td>";
			$html3 .="</tr>";
		}	
	$html3 .="</table>";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Actions log</title>
		<link rel="stylesheet" type="text/css" href="../styles.css">
	</head>
	<body>
		<?php require("../layout1.php");?>
		<h1>Your actions log</h1>
		<p>
			Your active actons: 
			<?php echo $html2;?>
		</p>
		<p>Your actions history: 
			<?php echo $html3;?>
		</p>
		<?php require("../layout2.php");?>
	</body>
</html>
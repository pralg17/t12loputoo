<?php
	require("C:/xampp/config.php");

$database = "if16_brigitta";

if(isset($_GET['storyId'])){
	$storyId = $_GET['storyId'];
}

function updateStory($id, $story){

 		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

 		$stmt = $mysqli->prepare("UPDATE story_dump SET story=? WHERE id=?");
		echo $mysqli->error;
 		//var_dump($story, $id, $stmt->execute()); exit;
 		$stmt->bind_param("si", $story, $id);

 		if($stmt->execute()){

 			echo "success";

 		}

 		$stmt->close();
 		$mysqli->close();

}
//$asdf = "test text, really random, dont even bother with reading asdasdasdasd qwertyu";
//updateStory(16, $asdf);
function getStory($id) 	{
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT story FROM story_dump WHERE id=?");

	$query = 'SELECT story FROM story_dump WHERE id='.$id;

	$stmt->bind_param("i", $id);
	$stmt->bind_result($story);
	$result = mysqli_query($mysqli, $query);
	$story = mysqli_fetch_assoc($result);

	return $story['story'];
//var_dump($story['story']); exit;
}
if(isset($_POST['story'])) {

	updateStory($storyId , $_POST['story']);
	header('Location: short_story_dump.php');
}

//var_dump($_POST); exit;
echo '<form method="post"><textarea name="story" style="width:500px; height:250px;">'.getStory($storyId).'</textarea><br>';
echo '<input type="submit" name="update-btn"></form>';

?>

<?php
	require("C:/xampp/config.php");

	session_start();

	$database = "if16_brigitta";
	$storyError = "";
	$story = "";
	if (empty ($_POST["story"])) {
		$storyError = "you have to write something";
	}

	function saveStory($author, $story) {

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);


		$stmt = $mysqli->prepare("INSERT INTO story_dump (author, story) VALUES(?,?)");
		echo $mysqli->error;

		$stmt->bind_param("ss", $author, $story);

		if ($stmt->execute() ) {

			echo "saving success";
		} else {

			echo "ERROR ".$stmt->error;
		}


	}
function cleanInput ($input)
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}
if(isset($_POST['author']) &&
	isset($_POST['story']) &&
	!empty($_POST['story'])
	) {
		if(empty($_POST["author"])) {
			$author = "anonymous";
		} else {
			$author = cleanInput($_POST["author"]);
		}
		$story = cleanInput($_POST["story"]);
		saveStory($author, $story);
	}
function deleteStory($id) {
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

	$stmt = $mysqli->prepare("DELETE FROM story_dump WHERE id={$id}");

	$stmt->execute();
}
if(isset($_POST['delete-btn'])){
	deleteStory($_POST['story-id']);
}

function getAllStories() 	{
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, author, story FROM story_dump ORDER BY id DESC");
	$stmt->bind_result($id, $author, $story);
	$stmt->execute();
	$result = array();
	while($stmt->fetch()) {
		//echo $note."<br>";
		//lilith
		$object = new StdClass();
		$object->id = $id;
		$object->author = $author;
		$object->story = $story;
		array_push($result, $object);
	}
	//return $result;

	foreach($result as $item) {
//			echo '<div style="position:relative;">';
		echo '<div style="display:flex;width:33%;margin-bottom:5px;"><div style="background-color:rgba('.rand(0,255).','.rand(0,255).','.rand(0,255).',0.5'.rand(0,1).');float:left;display:flex;justify-content:flex-end;word-wrap:break-word; position: relative">';
		echo $item->author." wrote: <br><br>";
		echo $item->story;

		if(isset($_SESSION["userId"])): ?>
		<form method="post" action="short_story_dump.php">
		<input type="hidden" name="story-id" value="<?=$item->id?>">
		<input type="submit" name="delete-btn" value="" class="delete" style="width:27px; height:29px; background-image:url('trash.png');position: absolute;right: 0;top: 0; cursor:pointer;">
		</form>

		<form method="get" action="short_story_edit.php">
		<input type="hidden" name="storyId" value="<?=$item->id?>">
		<input type="submit" name="edit-btn" value="" style="position:absolute; cursor:pointer; top:0px; right:25px; height:29px; width:29px; background-image:url('edit.png');" onclick="location.href='short_story_edit.php?storyId=<?=$item->id?>;">
		</form>

		<?php endif;
		echo '</div></div>';
	}
}
/*
if(isset($_POST['edit-btn'])){
	updateStory($_POST['story-id'], );
}
*/

if (isset($_GET['logout'])) {
	unset($_SESSION['userId']);
	unset($_SESSION['userEmail']);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>story_dump</title>
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var text_max = 666;
				$('#textarea_feedback').html(text_max + ' characters remaining');
				$('#textarea').keyup(function() {
					var text_length = $('#textarea').val().length;
					var text_remaining = text_max - text_length;
					$('#textarea_feedback').html(text_remaining + ' characters remaining');
				});
			});
		</script>
		<style>
			.delete:hover {
				cursor:pointer;
			}
		</style>

	</head>
	<body>
<div style="display:block;">
	<div style="float:left; width:50%;height:1000px;">

		<h1 style="color:#8a0707;">write your deepest darkest secrets here</h1>

		<h2> <?php if(isset($_SESSION["userId"])) { echo "you're logged in as admin"; } ?> </h2>

		<form method="POST">


			<label>what would you like to be called?</label>

			<br>

			<input name="author" type="text" placeholder="anonymous">

			<br><br>

			<textarea name="story" style="width: 300px; height: 150px;" placeholder="speak your mind.." id="textarea" maxlength="666"></textarea>

			<div id="textarea_feedback"></div>

			<?php if(isset($_POST['author'])) { echo $storyError; } ?>

			<br><br>

			<input type="submit" value="submit">


		</form>
	</div>
	<div>
		<?php getAllStories(); ?>
	</div>
</div>
<div>
	<?php if(!isset($_SESSION['userId']) && !isset($_SESSION['userEmail'])): ?>
		<form action="http://localhost/3.kodutoo-III-ruhm/short_story_admin.php" method="get">
				<input type="submit" name="login" value="Login">
		</form>
	<?php
		endif;
		if(isset($_SESSION['userId']) && isset($_SESSION['userEmail'])): ?>
			<form style="float: right;" action="http://localhost/3.kodutoo-III-ruhm/short_story_dump.php" method="get">
				<input type="submit" name="logout" value="Logout">
			</form>
	<?php endif; ?>
</div>
</body>
</html>

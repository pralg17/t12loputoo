<?php
	//edit.php
	require("../functions.php");

	require("../class/Flower.class.php");
	$Flower = new Flower($mysqli);

	if(isset($_POST["update"])){

		$Flower->update($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["flower"]), $Helper->cleanInput($_POST["color"]));

		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();
	}

if(isset($_GET["delete"])){
  $flower ->delete($_GET["id"]);

  header("Location: data.php");
  exit();
}

//kui ei ole id aadressireal, siis suunan tagasi data lehele

if(!isset($_GET["id"])){
  header("Location: data.php");
  exit();
}

$c = $Flower->getSingle($_GET["id"]);
if(isset($_GET["success"])){
  echo "Salvestamine õnnestus!";

  header("Location: data.php");
  exit();
}

?>
<?php require("../header.php"); ?>
<br><br>
<a href="data.php">Tagasi </a>

<h2>Muuda lille andmeid</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" >
  	<label for="flower" >Lille nimi</label><br>
	<input id="flower" name="flower" type="text" value="<?php echo $c->flower;?>" ><br><br>
  	<label for="color" >Lille värv</label><br>
	<input id="color" name="color" type="color" value="<?=$c->color;?>"><br><br>

	<input type="submit" name="update" value="Salvesta">
  </form>

  <br>
 <a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>
 <?php require("../footer.php"); ?>

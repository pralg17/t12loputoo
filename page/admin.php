<?php
require("../functions.php");

$kasutaja ="";
$kasutajaError ="";
$parool="";
$parooliError="";

if (isset ($_POST ["kasutaja"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["kasutaja"])) {
        //oli t�esti t�hi
        $kasutajaError = "Sisesta kasutajanimi!";
    } else {
        $kasutaja = $_POST ["kasutaja"];
    }
}
if (isset ($_POST ["parool"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["parool"])) {
        //oli t�esti t�hi
        $parooliError = "Sisesta parool!";
    } else {
        $parool = $_POST ["parool"];
    }
}

if( isset($_POST["kasutaja"]) &&
    isset($_POST["parool"]) &&
    !empty($_POST["kasutaja"]) &&
    !empty($_POST["parool"])
)	{
    $Admin->login($_POST["kasutaja"],$_POST["parool"]);
    header("Location: adminData.php");
    exit();
}
?>
<?php require("../header.php");?>
<?php require("../style/style.css");?>
<head>

</head>

<body>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-12 col-md-auto">
            <div class="loginWall">
                <center><p class="pageHeading">Logi sisse</p></center>
                <form  method="POST">
                    <?php echo $kasutajaError; ?><br>
                    <?php echo $parooliError; ?>
                    <input class="loginForm" type="text"  value="<?=$kasutaja;?>" name="kasutaja" placeholder="kasutaja"><br><br>
                    <input class="loginForm" type="password"  value="<?=$parool;?>" name="parool" placeholder="parool"><br><br>
                    <button style="width: 300px;height: 50px;font-size: 30px" type="submit">LOGI SISSE</button><br><br>
                </form>
            </div>
            <center><a href="welcome.php" class="toRegister" style="width: 300px;text-align: center">AVALEHELE</a></center>
        </div>
    </div>
</div>



</body>

<?php require("../footer.php");?>
<?php
require("../functions.php");
if(!isset ($_SESSION["userId"])) {

    header("Location: admin.php");
    exit();
}

if(isset($_GET["logout"])) {

    session_destroy();

    header("Location: admin.php");
    exit();
}
$textChanged="";
$textChangedError="";

if (isset ($_POST ["textChanged"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["textChanged"])) {
        //oli t�esti t�hi
        $textChangedError = "Tekt puudub!";
    } else {
        $textChanged = $_POST ["textChanged"];
    }
}

if(
isset($_POST["textChanged"]) &&
!empty($_POST["textChanged"])
){
    $Admin->saveNewText(urlencode($_POST["textChanged"]));
    header("Location: adminText.php");
    exit();
}



$text = $Admin->getWelcomeText();




?>
<?php require("../header.php");?>
<?php require("../style/style.css");?>

<head>
    <p style="background-color: #B71234;font-size: 25px"><a style="color: black" href="adminData.php"> Admin</a><a style="float: right;color: white" href="?logout=1">logi valja</a></p>
</head>

<body>
    <text class="pageHeading"> MUUDA AVALEHE TERVITUSTEKSTI: </text>
    <div class="container">
        <div class="row">
            <div class="col">
                <form method="post">
                    <textarea style="width: 100%;height: 50%;" placeholder="uus tekst" name="textChanged"><?=urldecode($text->text);?></textarea>
                    <button type="submit">SALVESTA</button>
                </form>
            </div>
        </div>
    </div>
</body>





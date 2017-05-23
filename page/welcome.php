<?php
require("../functions.php");
session_destroy();



$text = $Admin->getWelcomeText();
?>

<?php require("../header.php");?>
<?php require("../style/style.css");?>
<!DOCTYPE html>
<html>
<head>


</head>

<body>


<br>

<div class="container">
    <div class="row">
        <div class="col">
            <br>
            <img style="margin-left: 15px " src="http://www.tlu.ee/img/logo01.png">
            <br><br>

            <p class="pageHeading">
                Tutvustav leht
            </p>

            <a href="signUpTudeng.php" class="toRegister">REGISTREERU TUDENGIKS</a><br><br>
            <a href="signUpVari.php" class="toRegister">REGISTREERU VARJUKS</a>
        </div>
        <div class="col">
                    <p style="font-size: large;border-left: solid 10px;border-left-color: #B71234;padding-left: 20px">
                        <?=urldecode($text->text);?>
                    </p>
        </div>
    </div>
</div>
        <br>
</body>

</html>
<?php require("../footer.php");?>
<?php
require("../functions.php");

$bm = "";
$BM = "";
$bmError = "";
$eesnimi = "";
$eesnimiError = "";
$perenimi = "";
$perenimiError = "";
$email = "";
$emailError = "";
$telnr = "";
$telnrError = "";
$kursus = "";
$kursusError = "";
$vanus = "";
$vanusError = "";
$eriala = "";
$eriala2 = "";
$visibility = "fadeable";
$mituVarju="";
$mituVarjuError="";




if (isset ($_POST ["baka"])) {
    $_SESSION["bm"]=$_POST["baka"];
}

if (isset ($_POST ["magi"])) {
    $_SESSION["bm"]=$_POST["magi"];
}

if (isset ($_POST ["eesnimi"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["eesnimi"])) {
        //oli t�esti t�hi
        $eesnimiError = "Eesnimi puudub!";
    } else {
        $eesnimi = $_POST ["eesnimi"];
    }
}

if (isset ($_POST ["perenimi"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["perenimi"])) {
        //oli t�esti t�hi
        $perenimiError = "Perekonnanimi puudub!";
    } else {
        $perenimi = $_POST ["perenimi"];
    }
}

if (isset ($_POST ["email"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["email"])) {
        //oli t�esti t�hi
        $emailError = "Email puudub!";
    } else {
        $email = $_POST ["email"];
    }
}

if (isset ($_POST ["telnr"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["telnr"])) {
        //oli t�esti t�hi
        $telnrError = "Telefoninumber puudub!";
    } else {
        $telnr = $_POST ["telnr"];
    }
}
if (isset ($_POST ["kursus"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["kursus"])) {
        //oli t�esti t�hi
        $kursusError = "kursus puudub!";
    } else {
        $kursus = $_POST ["kursus"];
    }
}
if (isset ($_POST ["vanus"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["vanus"])) {
        //oli t�esti t�hi
        $vanusError = "Vanus puudub!";
    } else {
        $vanus = $_POST ["vanus"];
    }
}
if (isset ($_POST ["eriala"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["eriala"])) {
        //oli t�esti t�hi
        $erialaError = "eriala puudub!";
    } else {
        $eriala = $_POST ["eriala"];
    }
}
if (isset ($_POST ["eriala2"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["eriala2"])) {
        //oli t�esti t�hi
        $eriala2Error = "Eriala puudub!";
    } else {
        $eriala2 = $_POST ["eriala2"];
    }
}
if (isset ($_POST ["mituVarju"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["mituVarju"])) {
        //oli t�esti t�hi
        $mituVarjuError = "vali mitu varju votad!";
    } else {
        $mituVarju = $_POST ["mituVarju"];
    }
}
$bakaDropDownEriala=$Vari->getBaka();
$magiDropDownEriala=$Vari->getMagi();

if( isset($_POST["eesnimi"]) &&
    isset($_POST["perenimi"]) &&
    isset($_POST["email"]) &&
    isset($_POST["telnr"]) &&
    isset($_POST["kursus"]) &&
    isset($_POST["vanus"]) &&
    isset($_POST["eriala"]) &&
    isset($_POST["mituVarju"]) &&
    !empty($_POST["mituVarju"]) &&
    !empty($_POST["eesnimi"]) &&
    !empty($_POST["perenimi"]) &&
    !empty($_POST["email"]) &&
    !empty($_POST["telnr"]) &&
    !empty($_POST["kursus"]) &&
    !empty($_POST["vanus"]) &&
    !empty($_POST["eriala"])
)	{
    $firstname = $Helper->cleanInput($_POST["eesnimi"]);
    $lastname = $Helper->cleanInput($_POST["perenimi"]);
    $email = $Helper->cleanInput($_POST["email"]);
    $phonenr = $Helper->cleanInput($_POST["telnr"]);
    $course = $Helper->cleanInput($_POST["kursus"]);
    $age = $Helper->cleanInput($_POST["vanus"]);
    $Tudeng->saveTudeng($firstname,$lastname,$email,$phonenr,$course,$age,$_SESSION["bm"],$_POST["eriala"],$_POST["mituVarju"]);

    require_once '../swiftmailer/lib/swift_required.php';

    $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
        ->setUsername('tlutudengivari2017@gmail.com')
        ->setPassword($password);

    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance('Test Subject')
        ->setFrom(array('tlutudengivari2017@gmail.com' => 'Tudengivarjuveeb'))
        ->setTo(array($email))
        ->setBody('Registreerusid edukalt tlu tudengivarju lehel tudengiks.');

    $result = $mailer->send($message);

    header("Location: welcome.php");
    exit();
}
?>

<?php require("../header.php");?>
<?php require("../style/style.css");?>


    <head>
        <script type="text/javascript" src="../js/modify.js"></script>
        <p style="background-color: #B71234;font-size: 25px"><a style="color: black" href="welcome.php"> Avaleht</a></p>
    </head>

    <body>
    <br>
    <p class="pageHeading">
        Registreerimine TUDENGIKS
    </p>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-7">

                <button id="baka" value="baka" name="bm" style=";width: 50%" onclick="showBakaForm()">BAKALAUREUS</button>
                <button id="magi" value="magi" name="bm" style="position: absolute;width: 50%;float: right;margin: 0" onclick="showMagiForm()">MAGISTER</button><br><br>

                <div id="bakaForm" class="bakaForm" style="position: absolute;">
                    <form  method="POST" style=" transition:all 1s;">
                        <input type="text" placeholder="Eesnimi" value="<?=$eesnimi;?>" name="eesnimi"><br><br>
                        <input type="text" placeholder="Perekonnanimi" value="<?=$perenimi;?>" name="perenimi"><br><br>
                        <input type="text" placeholder="Email" value="<?=$email;?>" name="email"><br><br>
                        <input type="number" placeholder="Telefoninumber" value="<?=$telnr;?>" name="telnr"><br><br>
                        <input type="number" placeholder="Vanus" value="<?=$vanus;?>" name="vanus"><br><br>


                        eriala: <select name="eriala" type="text" placeholder="Eriala" style="width: 150px">
                            <?php

                            $listHtml = "";

                            foreach($bakaDropDownEriala as $d){


                                $listHtml .= "<option value='".$d->eriala."'>".$d->eriala."</option>";

                            }

                            echo $listHtml;

                            ?>
                        </select><br><br>
                        <input type="text" placeholder="Mitmes kursus" value="<?=$kursus;?>" name="kursus"><br><br>
                        mitu varju soovid: <select name="mituVarju">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select><br><br>

                        <button style="width: 100%;height: 50px" type="submit" value="baka" name="baka">SALVESTA</button><br><br>

                    </form>
                </div>
                <div id="magiForm" class="magiForm" style="position: absolute;right: 0">
                    <form  method="POST" style=" transition:all 1s;">
                        <input type="text" placeholder="Eesnimi" value="<?=$eesnimi;?>" name="eesnimi"><br><br>
                        <input type="text" placeholder="Perekonnanimi" value="<?=$perenimi;?>" name="perenimi"><br><br>
                        <input type="text" placeholder="Email" value="<?=$email;?>" name="email"><br><br>
                        <input type="number" placeholder="Telefoninumber" value="<?=$telnr;?>" name="telnr"><br><br>
                        <input type="number" placeholder="Vanus" value="<?=$vanus;?>" name="vanus"><br><br>


                        eriala: <select name="eriala" type="text" placeholder="Eriala" style="width: 150px">
                            <?php

                            $listHtml = "";

                            foreach($magiDropDownEriala as $d){


                                $listHtml .= "<option value='".$d->eriala."'>".$d->eriala."</option>";

                            }

                            echo $listHtml;

                            ?>
                        </select><br><br>
                        <input type="text" placeholder="Mitmes kursus" value="<?=$kursus;?>" name="kursus"><br><br>
                        mitu varju soovid: <select name="mituVarju">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select><br><br>

                        <button style="width: 100%;height: 50px" type="submit" value="baka" name="baka">SALVESTA</button><br><br>

                    </form>
                </div>
            </div>
        </div>
    </div>

    </body>



<?php require("../footer.php");?>
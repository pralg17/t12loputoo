<?php
require("../functions.php");
$_SESSION["change"]=0;
if($_SESSION["change"]==0){
    $cancel="hidden";
    $modify="visible";
    $_SESSION["change"]=1;
}


$modalVisibility="hidden";

if(!isset ($_SESSION["userId"])) {

    header("Location: admin.php");
    exit();
}
if(isset($_GET["logout"])) {

    session_destroy();

    header("Location: admin.php");
    exit();
}
if (isset ($_POST ["pairVari"])) {
    if (isset ($_SESSION["pairVari"])) {
        if ($_SESSION["pairVari"] > 0 && $_SESSION["pairVari"] == $_POST["pairVari"]) {
            $_SESSION["pairVari"] = "";
        } else {
            $pairVari = $_POST ["pairVari"];
            $_SESSION["pairVari"] = $_POST["pairVari"];
        }
    } else {
        $pairVari = $_POST ["pairVari"];
        $_SESSION["pairVari"] = $_POST["pairVari"];
    }
}
if (isset ($_POST ["pairTudeng"])) {
    if (isset ($_SESSION["pairTudeng"])) {
        if ($_SESSION["pairTudeng"] > 0 && $_SESSION["pairTudeng"] == $_POST["pairTudeng"]) {
            $_SESSION["pairTudeng"] = "";
        }else{
            $pairTudeng = $_POST ["pairTudeng"];
            $_SESSION["pairTudeng"] = $_POST["pairTudeng"];
        }
    }else{
        $pairTudeng = $_POST ["pairTudeng"];
        $_SESSION["pairTudeng"] = $_POST["pairTudeng"];
    }

}


if (isset ($_POST ["pair"])) {
    if( isset($_SESSION["pairVari"]) &&
        isset($_SESSION["pairTudeng"]) &&
        !empty($_SESSION["pairVari"]) &&
        !empty($_SESSION["pairTudeng"])
    ){
        $pairId = $Pair->getPairId();
        $Pair->checkTudengPairIdStatus($_SESSION["pairTudeng"]);
        $Pair->updatePairId();
        if($_SESSION["PairId1Status"]==0){
            $Pair->updateTudeng($_SESSION["PairId"], $_SESSION["pairTudeng"]);
            $tudengForEmail=$Pair->getTudengForEmail($_SESSION["pairTudeng"]);
            $_SESSION["tudengForEmail"]=$tudengForEmail;

        }else{
            $Pair->updateTudeng2($_SESSION["PairId"], $_SESSION["pairTudeng"]);
            $tudengForEmail=$Pair->getTudengForEmail($_SESSION["pairTudeng"]);
            $_SESSION["tudengForEmail"]=$tudengForEmail;



        }
        $variForEmail=$Pair->getVariForEmail($_SESSION["pairVari"]);
        $Pair->updateVari($_SESSION["PairId"], $_SESSION["pairVari"]);
        $_SESSION["variForEmail"]=$variForEmail;


        require_once '../swiftmailer/lib/swift_required.php';

        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('tlutudengivari2017@gmail.com')
            ->setPassword($password);

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance('Tudengivarjunädal')
            ->setFrom(array('tlutudengivari2017@gmail.com' => 'Tudengivarjuveeb'))
            ->setTo(array($_SESSION["variForEmail"][0]->email))
            ->setBody('Tere '.$_SESSION["variForEmail"][0]->eesnimi.'! 

Sulle leiti tudengivarjunädalaks paariline:
'.$_SESSION["tudengForEmail"][0]->eesnimi." ".$_SESSION["tudengForEmail"][0]->perekonnanimi.'.


'.$_SESSION["tudengForEmail"][0]->eesnimi.' andmed:

Nimi: '.$_SESSION["tudengForEmail"][0]->eesnimi." ".$_SESSION["tudengForEmail"][0]->perekonnanimi.'
Email: '.$_SESSION["tudengForEmail"][0]->email.'
Telefoni: '.$_SESSION["tudengForEmail"][0]->telnr.'
Vanus: '.$_SESSION["tudengForEmail"][0]->vanus.'
Eriala: '.$_SESSION["tudengForEmail"][0]->eriala.'
Kursus: '.$_SESSION["tudengForEmail"][0]->kursus.'

Võta temaga ühendust ja leppige kokku sobivad ajad.

Kui sulle tundub, et tekkinud on eksitus, siis võta ühendust administraatoriga.
Email: tlutudengivarjuveeb2017@gmail.com


Sinu Tudengivarjuveeb');

        $result = $mailer->send($message);

        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('tlutudengivari2017@gmail.com')
            ->setPassword($password);

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance('Tudengivarjunädal')
            ->setFrom(array('tlutudengivari2017@gmail.com' => 'Tudengivarjuveeb'))
            ->setTo(array($_SESSION["tudengForEmail"][0]->email))
            ->setBody('Tere '.$_SESSION["tudengForEmail"][0]->eesnimi.'!

Sulle leiti tudengivarjunädala varjuks '.$_SESSION["variForEmail"][0]->eesnimi." ".$_SESSION["variForEmail"][0]->perekonnanimi.'.

'.$_SESSION["variForEmail"][0]->eesnimi.' andmed:

Nimi: '.$_SESSION["variForEmail"][0]->eesnimi." ".$_SESSION["variForEmail"][0]->perekonnanimi.'
Email: '.$_SESSION["variForEmail"][0]->email.'
Telefoni: '.$_SESSION["variForEmail"][0]->telnr.'
Vanus: '.$_SESSION["variForEmail"][0]->vanus.'
Kool: '.$_SESSION["variForEmail"][0]->kool.'

Ta võtab sinuga ise ühendust.

Kui sulle tundub, et tekkinud on eksitus, siis võta ühendust administraatoriga.
Email: tlutudengivarjuveeb2017@gmail.com


Sinu Tudengivarjuveeb');

        $result = $mailer->send($message);
        $_SESSION["pairVari"]="";
        $_SESSION["pairTudeng"]="";
    }
}
if (isset ($_POST ["delTudeng"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["delTudeng"])) {
        //oli t�esti t�hi
        $delTudengError = "";
    } else {
        $delTudeng = $_POST ["delTudeng"];
        $_SESSION["delTudeng"]= $_POST["delTudeng"];
        $cancel="visible";
        $modify="hidden";
    }
}
if (isset ($_POST ["delVari"])) {
    // oli olemas, ehk keegi vajutas nuppu
    if (empty($_POST ["delVari"])) {
        //oli t�esti t�hi
        $delVariError = "";
    } else {
        $delVari = $_POST ["delVari"];
        $_SESSION["delVari"]= $_POST["delVari"];
        $cancel="visible";
        $modify="hidden";
    }
}
if (isset ($_POST ["cancel"])) {
    if (empty($_POST ["delVari"])) {
        $cancel = $_POST ["cancel"];
        $_SESSION["delTudeng"] = 0;
        $_SESSION["delVari"] = 0;
        $cancel = "hidden";
        $modify = "visible";
    }
}
if (isset ($_POST ["deleteTudeng"])) {
    $_SESSION["deleteTudeng"]=$_POST["deleteTudeng"];
    $modalVisibility="visible;z-index: 1001;";
    $DT = $Admin->getSingleTudeng($_POST["deleteTudeng"]);
    $cancel="visible";
    $modify="hidden";

}
if (isset ($_POST ["deleteVari"])) {
    $_SESSION["deleteVari"]=$_POST["deleteVari"];
    $modalVisibility="visible;z-index: 1001;";
    $DV = $Admin->getSingleVari($_POST["deleteVari"]);
    $cancel="visible";
    $modify="hidden";
}
if(isset ($_POST["changeText"])){
    if (!empty($_POST ["changeText"])) {
        header("Location: adminText.php");
    }
}
if (isset ($_POST ["cancelDelete"])) {
    $modalVisibility="hidden;z-index: -100;";
    $cancel="visible";
    $modify="hidden";
}
if (isset ($_POST ["linkedStudents"])) {
    header("Location:adminLinked");
}
if (isset ($_POST ["confirmDelete"])) {
    $modalVisibility="hidden;z-index: -100;";
    if( $_SESSION["deleteTV"]=="T") {
        $Admin->deleteTudeng($_SESSION["deleteTudeng"]);
        $tudengForEmail=$Pair->getTudengForEmail($_SESSION["deleteTudeng"]);
        $_SESSION["tudengForEmail"]=$tudengForEmail;
        require_once '../swiftmailer/lib/swift_required.php';
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername('tlutudengivari2017@gmail.com')
            ->setPassword($password);

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance('Tudengivarjunädal')
            ->setFrom(array('tlutudengivari2017@gmail.com' => 'Tudengivarjuveeb'))
            ->setTo(array($_SESSION["tudengForEmail"][0]->email))
            ->setBody('Tere '.$_SESSION["tudengForEmail"][0]->eesnimi.'!

Sinu taotlus osaleda Tallinna Ülikooli tudengivarjunädalal on kustutatud.

Kui sulle tundub, et tekkinud on eksitus, siis võta ühendust administraatoriga.
Email: tlutudengivarjuveeb2017@gmail.com


Sinu Tudengivarjuveeb');

        $result = $mailer->send($message);
        $_SESSION["deleteTV"]="";
    }elseif( $_SESSION["deleteTV"]=="V"){
        $Admin->deleteVari($_SESSION["deleteVari"]);
    }
    $cancel = "hidden";
    $modify = "visible";
    $_SESSION["delVari"] = 0;
    $_SESSION["delTudeng"] = 0;
}
if (isset ($_POST ["erialad"])) {
        // oli olemas, ehk keegi vajutas nuppu
        if (empty($_POST ["erialad"])) {
            //oli t�esti t�hi
            $bErialaError = "";
        } else {
            $bEriala = $_POST ["erialad"];
            $varjud= $Admin->getSpecificVarjud($_POST ["erialad"]);
            $tudengid= $Admin->getSpecificTudengid($_POST ["erialad"]);

            $_POST ["erialad"]="";

        }
    }else{
    $varjud = $Admin->getVarjud();
    $tudengid = $Admin->getTudengid();
}
if (isset ($_POST ["cancelFilter"])) {
    $_POST ["erialad"]="";
}



$allRegistred=array_merge($Vari->getBaka(),$Vari->getMagi());
sort($allRegistred);


?>
<?php require ("../header.php")?>
<?php require("../style/style.css");?>


<head>
    <script src="../js/modify.js"></script>
    <meta charset="utf-8">
    <p style="background-color: #B71234;font-size: 25px"><a style="color: black" href="adminLinked.php"> Tagasi</a><a style="float: right;color: white" href="?logout=1">logi valja</a></p>
</head>
<body>
<div class="mymodal" style="visibility: <?php echo $modalVisibility ?>;">
    <div align="left" class="confirm">
        <div class="confirmHead">
            <text style="font-size: 22px;color: white;"><span style="font-size: 30px">T</span>EADE!</text>
        </div>

        <?php if (isset ($_POST ["deleteTudeng"])){ ?>
            <h5 style="margin-top: 20px;margin-left: 10px;font-weight: bold" >Soovid kustutada tudengi:</h5>
            <hr>
        <div style="margin-left: 10px">
            <div style="border-bottom: 1px solid gray;margin: 10px"><text>Eesnimi: </text><text class="confirmData"> <?php echo $DT->eesnimi; ?></text></div>
            <div style="border-bottom: 1px solid gray;margin: 10px"><text>Perenimi: </text><text class="confirmData"> <?php echo $DT->perekonnanimi ?></text></div>
            <div style="border-bottom: 1px solid gray;margin: 10px"><text>Email: </text><text class="confirmData"> <?php echo $DT->email ?></text></div>
            <div style="border-bottom: 1px solid gray;margin: 10px"><text>Telefoni nr: </text><text class="confirmData"> <?php echo $DT->telnr ?></text></div>
            <div style="border-bottom: 1px solid gray;margin: 10px"><text>Vanus: </text><text class="confirmData"> <?php echo $DT->vanus ?></text></div>
            <div style="border-bottom: 1px solid gray;margin: 10px"><text>Aste: </text><text class="confirmData"> <?php echo $DT->bm ?></text></div>
            <div style="border-bottom: 1px solid gray;margin: 10px"><text>Eriala: </text><text class="confirmData"> <?php echo $DT->eriala ?></text></div>
            <div style="border-bottom: 1px solid gray;margin: 10px"><text>Eriala2: </text><text class="confirmData"> <?php echo $DT->kursus ?></text></div>
        </div>
        <?php $_SESSION["deleteTV"]="T";
        }elseif(isset ($_POST ["deleteVari"])){ ?>
            <h5 style="margin-top: 20px;margin-left: 10px;font-weight: bold" >Soovid kustutada tudengivarju:</h5>
            <hr>
            <div style="margin-left: 10px">
                <div style="border-bottom: 1px solid gray;margin: 10px"><text>Eesnimi: </text><text class="confirmData"> <?php echo $DV->eesnimi; ?></text></div>
                <div style="border-bottom: 1px solid gray;margin: 10px"><text>Perenimi: </text><text class="confirmData"> <?php echo $DV->perekonnanimi ?></text></div>
                <div style="border-bottom: 1px solid gray;margin: 10px"><text>Email: </text><text class="confirmData"> <?php echo $DV->email ?></text></div>
                <div style="border-bottom: 1px solid gray;margin: 10px"><text>Telefoni nr: </text><text class="confirmData"> <?php echo $DV->telnr ?></text></div>
                <div style="border-bottom: 1px solid gray;margin: 10px"><text>Vanus: </text><text class="confirmData"> <?php echo $DV->vanus ?></text></div>
                <div style="border-bottom: 1px solid gray;margin: 10px"><text>Aste: </text><text class="confirmData"> <?php echo $DV->bm ?></text></div>
                <div style="border-bottom: 1px solid gray;margin: 10px"><text>Eriala: </text><text class="confirmData"> <?php echo $DV->eriala ?></text></div>
                <div style="border-bottom: 1px solid gray;margin: 10px"><text>Eriala2: </text><text class="confirmData"> <?php echo $DV->eriala2 ?></text></div>
            </div>
        <?php $_SESSION["deleteTV"]="V";
        }?>
        <div style="margin-top: 40px">
            <form method="post">
            <button style="position: absolute;bottom: 0;left:0" name="cancelDelete">TÜHISTA</button>
            <button style="position: absolute;bottom: 0;right:0" name="confirmDelete">KINNITA</button>
            </form>
        </div>
    </div>
</div>

<text class="pageHeading"> ADMIN </text>

<form method="post">
    <button class="delBtn" style="font-size: 25px;position: fixed;width: 250px;right: 0;visibility: <?php echo $cancel ?>" name="cancel" value="0" >TÜHISTA</button>
</form>
<form style="visibility: <?php echo $modify ?>;margin-bottom: 66px" method="post">
    <div  class="btn-group" style="position: absolute;right: 0;">

        <div id="modifyBtns"  class="btn-group" onmouseover="show('modifyBtns','btnGroupMain')" onmouseout="hide('modifyBtns','btnGroupMain')" style="opacity: 0;visibility: hidden">
            <button type="submit" style="width: 250px;margin-right: 1" value="1" name="changeText">MUUDA TEKSTI</button>
            <button type="submit" style="width: 250px;margin-left: 1px;margin-right: 1px" value="1" name="delVari">KUSTUTA VARI</button>
            <button type="submit" style="width: 250px" value="1" name="delTudeng">KUSTUTA TUDENG</button>
        </div>
        <button id="btnGroupMain" style="width: 250px" onmouseover="show('modifyBtns','btnGroupMain')" onmouseout="hide('modifyBtns','btnGroupMain')">MUUDA</button>
    </div>
</form>

<form style="position: absolute;right: 0;visibility: <?php echo $modify ?>;margin-bottom: 150px" method="post">
    <div class="btn-group">
        <button type="submit" style="width: 250px;margin-right: 1px ;float: right" name="pair">LIIDA KOKKU</button><br><br>
        <button style="float: right" name="linkedStudents">KOKKU LIIDETUD TUDENGID</button>
    </div>
</form>


    <div class="btn-group" style="position: absolute;right: -150;visibility: <?php echo $modify ?>;margin-top: 51px;margin-bottom: 150px;width: 300px">
        <div id="erialad" class="btn-group" onmouseover="showErialad()" onmouseout="hideErialad()" style="position: absolute;height:100% ;visibility: hidden;opacity: 0;width: 300px">
            <form method="post"><button type="submit" name="cancelFilter" style="position: absolute;right: 600px;px;opacity: 1">X</button></form>
            <form method="post" type="submit">
                <button type="submit" id="saveBtn" style="position: absolute;height: 100%;right: 458px;">SALVESTA</button>
                <select  name="erialad" type="text" style="position: absolute;width: 156px;height:100%;right: 300px;">
                    <?php

                    $listHtml = "";

                    foreach($allRegistred as $d){


                        $listHtml .= "<option value='".$d->eriala."'>".$d->eriala."</option>";

                    }

                    echo $listHtml;

                    ?>
                </select>
            </form>
        </div>
        <button style="float: right;margin-left: 1" id="btnGroupMain2" name="filter" onmouseover="showErialad()" onmouseout="hideErialad()">FILTREERI</button>
    </div>

<br><br>


<div class="container-fluid" style="margin-top: 50px">
    <div class="row">
        <div class="col">
            <h3>registreeritud varjud:</h3>

            <?php

            $html = "<table style='width: 20%' class='table table-striped'>";
            $html .= "<tr>";

            $html .= "<th><center><a style='font-size: 20px' > Vali</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Eesnimi</center></th>";
            $html .= "<th><center><a style='font-size: 19px' > Perenimi</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Vanus</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Aste</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Eriala1</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Eriala2</center></th>";



            foreach($varjud as $V){
                if (isset($_SESSION["delTudeng"]) && $_SESSION["delTudeng"] == 1) {
                    $html .= "<tr>";
                    $html .= "<td><center><button class='selBtn' style='background: #cecece;color: darkslategray;cursor: no-drop;border: none'>VALI</button></center></td>";
                    $html .= "<td><center><a >$V->eesnimi</a></center></td>";
                    $html .= "<td><center><a >$V->perekonnanimi</a></center></td>";
                    $html .= "<td><center><a >$V->vanus</a></center></td>";
                    $html .= "<td><center><a >$V->bm</a></center></td>";
                    $html .= "<td><center><a >$V->eriala</a></center></td>";
                    $html .= "<td><center><a >$V->eriala2</a></center></td>";
                    $html .= "</tr>";
                }else{
                    if( isset($_SESSION["pairVari"])){
                        if($V->id == $_SESSION["pairVari"]) {
                            if (isset($_SESSION["delVari"])) {
                                $html .= "<tr>";
                                if ($_SESSION["delVari"] == 1) {
                                    $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$V->id' name='deleteVari' class='delBtn'>KUSTUTA</button></form></center></td>";
                                    $html .= "<td><center><a >$V->eesnimi</a></center></td>";
                                    $html .= "<td><center><a >$V->perekonnanimi</a></center></td>";
                                    $html .= "<td><center><a >$V->vanus</a></center></td>";
                                    $html .= "<td><center><a >$V->bm</a></center></td>";
                                    $html .= "<td><center><a >$V->eriala</a></center></td>";
                                    $html .= "<td><center><a >$V->eriala2</a></center></td>";
                                    $html .= "</tr>";
                                } else {
                                    $html .= "<td style='background-color: lightgreen'><center><form  method='POST' style='margin: 0'><button value='$V->id' name='pairVari' class='selBtn'>VALI</button></form></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$V->eesnimi</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$V->perekonnanimi</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$V->vanus</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$V->bm</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$V->eriala</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$V->eriala2</a></center></td>";
                                    $html .= "</tr>";
                                }

                            }else{
                                $html .= "<tr>";
                                $html .= "<td style='background-color: lightgreen'><center><form  method='POST' style='margin: 0'><button value='$V->id' name='pairVari' class='selBtn'>VALI</button></form></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$V->eesnimi</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$V->perekonnanimi</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$V->vanus</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$V->bm</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$V->eriala</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$V->eriala2</a></center></td>";
                                $html .= "</tr>";
                            }

                        } else{
                            if (isset($_SESSION["delVari"])) {
                                $html .= "<tr>";
                                if ($_SESSION["delVari"] == 1) {
                                    $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$V->id' name='deleteVari' class='delBtn'>KUSTUTA</button></form></center></td>";
                                } else {
                                    $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$V->id' name='pairVari' class='selBtn'>VALI</button></form></center></td>";
                                }
                                $html .= "<td><center><a >$V->eesnimi</a></center></td>";
                                $html .= "<td><center><a >$V->perekonnanimi</a></center></td>";
                                $html .= "<td><center><a >$V->vanus</a></center></td>";
                                $html .= "<td><center><a >$V->bm</a></center></td>";
                                $html .= "<td><center><a >$V->eriala</a></center></td>";
                                $html .= "<td><center><a >$V->eriala2</a></center></td>";
                                $html .= "</tr>";
                            }else{
                                $html .= "<tr>";
                                $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$V->id' name='pairVari' class='selBtn'>VALI</button></form></center></td>";
                                $html .= "<td><center><a >$V->eesnimi</a></center></td>";
                                $html .= "<td><center><a >$V->perekonnanimi</a></center></td>";
                                $html .= "<td><center><a >$V->vanus</a></center></td>";
                                $html .= "<td><center><a >$V->bm</a></center></td>";
                                $html .= "<td><center><a >$V->eriala</a></center></td>";
                                $html .= "<td><center><a >$V->eriala2</a></center></td>";
                                $html .= "</tr>";
                            }
                        }
                    } else{
                        $html .= "<tr>";
                        if (isset($_SESSION["delVari"])) {
                            if ($_SESSION["delVari"] == 1) {
                                $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$V->id' name='deleteVari' class='delBtn'>KUSTUTA</button></form></center></td>";
                            } else {
                                $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$V->id' name='pairVari' class='selBtn'>VALI</button></form></center></td>";
                            }
                            $html .= "<td><center><a >$V->eesnimi</a></center></td>";
                            $html .= "<td><center><a >$V->perekonnanimi</a></center></td>";
                            $html .= "<td><center><a >$V->vanus</a></center></td>";
                            $html .= "<td><center><a >$V->bm</a></center></td>";
                            $html .= "<td><center><a >$V->eriala</a></center></td>";
                            $html .= "<td><center><a >$V->eriala2</a></center></td>";
                            $html .= "</tr>";
                        } else{
                            $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$V->id' name='pairVari' class='selBtn'>VALI</button></form></center></td>";
                            $html .= "<td><center><a >$V->eesnimi</a></center></td>";
                            $html .= "<td><center><a >$V->perekonnanimi</a></center></td>";
                            $html .= "<td><center><a >$V->vanus</a></center></td>";
                            $html .= "<td><center><a >$V->bm</a></center></td>";
                            $html .= "<td><center><a >$V->eriala</a></center></td>";
                            $html .= "<td><center><a >$V->eriala2</a></center></td>";
                            $html .= "</tr>";
                        }
                    }

                }
            }

            $html .= "</Table>";
            echo $html;

            ?>
        </div>
        <div class="col">
            <h3>registreeritud tudengid:</h3>

            <?php

            $html = "<table style='width: 20%' class='table table-striped'>";
            $html .= "<tr>";

            $html .= "<th><center><a style='font-size: 20px' > Vali</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Eesnimi</center></th>";
            $html .= "<th><center><a style='font-size: 19px' > Perenimi</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Vanus</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Aste</center></th>";
            $html .= "<th><center><a style='font-size: 20px' > Eriala</center></th>";



            foreach($tudengid as $T) {
                if (isset($_SESSION["delVari"]) && $_SESSION["delVari"] == 1) {
                                $html .= "<tr>";
                                $html .= "<td><center></center><button class='selBtn' style='background: #cecece;color: darkslategray;cursor: no-drop;border: none'>VALI</button></center></td>";
                                $html .= "<td><center><a >$T->eesnimi</a></center></td>";
                                $html .= "<td><center><a >$T->perekonnanimi</a></center></td>";
                                $html .= "<td><center><a >$T->vanus</a></center></td>";
                                $html .= "<td><center><a >$T->bm</a></center></td>";
                                $html .= "<td><center><a >$T->eriala</a></center></td>";
                                $html .= "</tr>";
                }else{
                    if (isset($_SESSION["pairTudeng"])) {
                        if ($T->id == $_SESSION["pairTudeng"]) {
                            if (isset($_SESSION["delTudeng"])) {
                                $html .= "<tr>";
                                if ($_SESSION["delTudeng"] == 1) {
                                    $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$T->id' name='deleteTudeng' class='delBtn'>KUSTUTA</button></form></center></td>";
                                    $html .= "<td><center><a >$T->eesnimi</a></center></td>";
                                    $html .= "<td><center><a >$T->perekonnanimi</a></center></td>";
                                    $html .= "<td><center><a >$T->vanus</a></center></td>";
                                    $html .= "<td><center><a >$T->bm</a></center></td>";
                                    $html .= "<td><center><a >$T->eriala</a></center></td>";
                                    $html .= "</tr>";
                                } else {
                                    $html .= "<td style='background-color: lightgreen'><center><form  method='POST' style='margin: 0'><button value='$T->id' name='pairTudeng' class='selBtn'>VALI</button></form></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$T->eesnimi</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$T->perekonnanimi</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$T->vanus</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$T->bm</a></center></td>";
                                    $html .= "<td style='background-color: lightgreen'><center><a >$T->eriala</a></center></td>";
                                    $html .= "</tr>";
                                }

                            }else{
                                $html .= "<tr>";
                                $html .= "<td style='background-color: lightgreen'><center><form  method='POST' style='margin: 0'><button value='$T->id' name='pairTudeng' class='selBtn'>VALI</button></form></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$T->eesnimi</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$T->perekonnanimi</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$T->vanus</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$T->bm</a></center></td>";
                                $html .= "<td style='background-color: lightgreen'><center><a >$T->eriala</a></center></td>";
                                $html .= "</tr>";
                            }
                        } else {
                            if (isset($_SESSION["delTudeng"])) {
                                $html .= "<tr>";
                                if ($_SESSION["delTudeng"] == 1) {
                                    $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$T->id' name='deleteTudeng' class='delBtn'>KUSTUTA</button></form></center></td>";
                                } else {
                                    $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$T->id' name='pairTudeng' class='selBtn'>VALI</button></form></center></td>";
                                }
                                $html .= "<td><center><a >$T->eesnimi</a></center></td>";
                                $html .= "<td><center><a >$T->perekonnanimi</a></center></td>";
                                $html .= "<td><center><a >$T->vanus</a></center></td>";
                                $html .= "<td><center><a >$T->bm</a></center></td>";
                                $html .= "<td><center><a >$T->eriala</a></center></td>";
                                $html .= "</tr>";
                            }else{
                                $html .= "<tr>";
                                $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$T->id' name='pairTudeng' class='selBtn'>VALI</button></form></center></td>";
                                $html .= "<td><center><a >$T->eesnimi</a></center></td>";
                                $html .= "<td><center><a >$T->perekonnanimi</a></center></td>";
                                $html .= "<td><center><a >$T->vanus</a></center></td>";
                                $html .= "<td><center><a >$T->bm</a></center></td>";
                                $html .= "<td><center><a >$T->eriala</a></center></td>";
                                $html .= "</tr>";
                            }
                        }
                    } else {
                        $html .= "<tr>";
                        if (isset($_SESSION["delTudeng"])) {
                            if($_SESSION["delTudeng"]==1) {
                                $html .= "<td><center><form method='POST' style='margin: 0'><button value='$T->id' name='deleteTudeng' class='delBtn'>KUSTUTA</button></form></center></td>";
                            }else{
                                $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$T->id' name='pairTudeng' class='selBtn'>VALI</button></form></center></td>";
                            }
                            $html .= "<td><center><a >$T->eesnimi</a></center></td>";
                            $html .= "<td><center><a >$T->perekonnanimi</a></center></td>";
                            $html .= "<td><center><a >$T->vanus</a></center></td>";
                            $html .= "<td><center><a >$T->bm</a></center></td>";
                            $html .= "<td><center><a >$T->eriala</a></center></td>";
                            $html .= "</tr>";
                        }else{
                            $html .= "<td><center><form  method='POST' style='margin: 0'><button value='$T->id' name='pairTudeng' class='selBtn'>VALI</button></form></center></td>";
                            $html .= "<td><center><a >$T->eesnimi</a></center></td>";
                            $html .= "<td><center><a >$T->perekonnanimi</a></center></td>";
                            $html .= "<td><center><a >$T->vanus</a></center></td>";
                            $html .= "<td><center><a >$T->bm</a></center></td>";
                            $html .= "<td><center><a >$T->eriala</a></center></td>";
                            $html .= "</tr>";
                        }
                    }
                }
            }


            $html .= "</Table>";
            echo $html;

            ?>
        </div>
        <div class="col">

        </div>
    </div>
</div>




</body>

<?php require ("../footer.php")?>

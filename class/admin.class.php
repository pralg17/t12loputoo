<?php

class Admin
{

    //klassi sees saab kasutada
    private $connection;

    //$user=new user(see); jouab siia sulgude vahele
    function __construct($mysqli)
    {

        //klassi sees muutujua kasutamiseks $this->
        //this viitab sellele klassile
        $this->connection = $mysqli;

    }

    function login($kasutaja, $parool){

        $error = "";

        $this->connection = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

        //kask
        $stmt = $this->connection->prepare("
			SELECT id, knimi, parool
			FROM admin
			WHERE knimi=?
		");

        echo $this->connection->error;

        //asendan kysimargid
        $stmt->bind_param("s", $kasutaja);

        //maaran tulpadele muutujad
        $stmt->bind_result($id, $kasutajaBaasist, $paroolBaasist);
        $stmt->execute();

        if($stmt->fetch()) {
            //oli rida


            if($kasutaja == $kasutajaBaasist && $parool==$paroolBaasist){

                echo "kasutaja ".$id."logis sisse";

                $_SESSION["userId"]= $id;
                $_SESSION["user"]=$kasutajaBaasist;


                //suunan uuele lehele
                header("location: restoWELCOME.php");


            }else {
                header("location: admin.php");
                exit();
            }

        }else {
            header("location: admin.php");
            exit();
        }

        header("location: admin.php");
    }

    function getVarjud(){

        $stmt = $this->connection->prepare("
			SELECT id, eesnimi, perekonnanimi, email, telefoninr, kool, vanus, bm, eriala, eriala2, pairId
            FROM tudengivarjud
            WHERE pairId=0 AND deleted is NULL
            ORDER BY eriala
		");
        echo $this->connection->error;

        $stmt->bind_result($id,$eesnimi,$perenimi,$email,$telnr, $kool, $vanus, $bm, $eriala, $eriala2, $pairId);
        $stmt->execute();


        //tekitan massiivi
        $result = array();

        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $person = new StdClass();
            $person->id = $id;
            $person->eesnimi = $eesnimi;
            $person->perekonnanimi = $perenimi;
            $person->email = $email;
            $person->telnr = $telnr;
            $person->kool = $kool;
            $person->vanus = $vanus;
            $person->bm = $bm;
            $person->eriala = $eriala;
            $person->eriala2 = $eriala2;
            $person->pairId = $pairId;

            array_push($result, $person);
        }

        $stmt->close();

        return $result;
    }

    function getTudengid(){

        $stmt = $this->connection->prepare("
			SELECT id, eesnimi, perekonnanimi, email, telefoninr, vanus, eriala, kursus, bm, pairId
            FROM tudengid
            WHERE mituVarju>0 and deleted is NULL 
            ORDER BY eriala
		");
        echo $this->connection->error;

        $stmt->bind_result($id,$eesnimi,$perenimi,$email,$telnr, $vanus, $eriala, $kursus, $bm, $pairId);
        $stmt->execute();


        //tekitan massiivi
        $result = array();

        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $tudeng = new StdClass();
            $tudeng->id = $id;
            $tudeng->eesnimi = $eesnimi;
            $tudeng->perekonnanimi = $perenimi;
            $tudeng->email = $email;
            $tudeng->telnr = $telnr;
            $tudeng->vanus = $vanus;
            $tudeng->eriala = $eriala;
            $tudeng->kursus = $kursus;
            $tudeng->bm = $bm;
            $tudeng->pairId = $pairId;

            array_push($result, $tudeng);
        }

        $stmt->close();

        return $result;
    }

    function getSingleTudeng($id){

        $stmt = $this->connection->prepare("
			SELECT id, eesnimi, perekonnanimi, email, telefoninr, vanus, eriala, kursus, bm, pairId
            FROM tudengid
            WHERE id=?
		");
        echo $this->connection->error;

        $stmt->bind_param("i", $id);

        $stmt->bind_result($id,$eesnimi,$perenimi,$email,$telnr, $vanus, $eriala, $kursus, $bm, $pairId);
        $stmt->execute();


        $tudeng = new StdClass();
        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            
            $tudeng->id = $id;
            $tudeng->eesnimi = $eesnimi;
            $tudeng->perekonnanimi = $perenimi;
            $tudeng->email = $email;
            $tudeng->telnr = $telnr;
            $tudeng->vanus = $vanus;
            $tudeng->eriala = $eriala;
            $tudeng->kursus = $kursus;
            $tudeng->bm = $bm;
            $tudeng->pairId = $pairId;

        }

        $stmt->close();

        return $tudeng;
    }

    function getSingleVari($id){

        $stmt = $this->connection->prepare("
			SELECT id, eesnimi, perekonnanimi, email, telefoninr, vanus, eriala, eriala2, bm, pairId
            FROM tudengivarjud
            WHERE id=?
		");
        echo $this->connection->error;

        $stmt->bind_param("i", $id);

        $stmt->bind_result($id,$eesnimi,$perenimi,$email,$telnr, $vanus, $eriala, $eriala2, $bm, $pairId);
        $stmt->execute();


        $vari = new StdClass();
        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti

            $vari->id = $id;
            $vari->eesnimi = $eesnimi;
            $vari->perekonnanimi = $perenimi;
            $vari->email = $email;
            $vari->telnr = $telnr;
            $vari->vanus = $vanus;
            $vari->eriala = $eriala;
            $vari->eriala2 = $eriala2;
            $vari->bm = $bm;
            $vari->pairId = $pairId;

        }

        $stmt->close();

        return $vari;
    }

    function deleteTudeng($id){

    $stmt = $this->connection->prepare("UPDATE tudengid SET deleted=NOW() WHERE id=?");

    $stmt->bind_param("i", $id);

    // kas õnnestus salvestada
    if ($stmt->execute()) {
        // õnnestus
//        echo "Tudengi kustutamine õnnestus!";
    }

    $stmt->close();

}

    function deleteVari($id){

        $stmt = $this->connection->prepare("UPDATE tudengivarjud SET deleted=NOW() WHERE id=?");

        $stmt->bind_param("i", $id);

        // kas õnnestus salvestada
        if ($stmt->execute()) {
            // õnnestus
//            echo "Varju kustutamine õnnestus!";
        }

        $stmt->close();

    }

    function unPairVariData($id){

        $stmt = $this->connection->prepare("
			SELECT eesnimi, perekonnanimi, email, telefoninr, vanus, eriala, eriala2, bm
            FROM tudengivarjud
            WHERE pairId=?
		");
        echo $this->connection->error;

        $stmt->bind_param("i", $id);

        $stmt->bind_result($eesnimi,$perenimi,$email,$telnr,$vanus,$eriala,$eriala2,$bm);
        $stmt->execute();


        $vari = new StdClass();
        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $vari->eesnimi = $eesnimi;
            $vari->perekonnanimi = $perenimi;
            $vari->email = $email;
            $vari->telnr = $telnr;
            $vari->vanus = $vanus;
            $vari->eriala = $eriala;
            $vari->eriala2 = $eriala2;
            $vari->bm = $bm;

        }

        $stmt->close();

        return $vari;
    }

    function unPairTudengData($id){

        $stmt = $this->connection->prepare("
			SELECT eesnimi, perekonnanimi, email, telefoninr, vanus, eriala, kursus, bm, pairId, pairId2
            FROM tudengid
            WHERE pairId=? or pairId2=?
		");
        echo $this->connection->error;

        $stmt->bind_param("ii", $id,$id);

        $stmt->bind_result($eesnimi,$perenimi,$email,$telnr,$vanus,$eriala,$kursus,$bm,$pairId,$pairId2);
        $stmt->execute();


        $tudeng = new StdClass();
        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti

            $tudeng->eesnimi = $eesnimi;
            $tudeng->perekonnanimi = $perenimi;
            $tudeng->email = $email;
            $tudeng->telnr = $telnr;
            $tudeng->vanus = $vanus;
            $tudeng->eriala = $eriala;
            $tudeng->kursus = $kursus;
            $tudeng->bm = $bm;
            $tudeng->pairId = $pairId;
            $tudeng->pairId2 = $pairId2;

        }

        $stmt->close();

        return $tudeng;
    }

    function unPairTudeng($id){

        $stmt = $this->connection->prepare("UPDATE tudengid SET pairId=0,mituVarju=mituvarju+1 WHERE pairId=?");

        $stmt->bind_param("i", $id);

        // kas õnnestus salvestada
        if ($stmt->execute()) {
            // õnnestus
//        echo "Tudengi kustutamine õnnestus!";
        }

        $stmt->close();

    }

    function unPairTudeng2($id){

        $stmt = $this->connection->prepare("UPDATE tudengid SET pairId2=0,mituVarju=mituvarju+1 WHERE pairId2=?");

        $stmt->bind_param("i", $id);

        // kas õnnestus salvestada
        if ($stmt->execute()) {
            // õnnestus
//        echo "Tudengi kustutamine õnnestus!";
        }

        $stmt->close();

    }

    function unPairVari($id){

        $stmt = $this->connection->prepare("UPDATE tudengivarjud SET pairId=0 WHERE pairId=?");

        $stmt->bind_param("i", $id);

        // kas õnnestus salvestada
        if ($stmt->execute()) {
            // õnnestus
//        echo "Tudengi kustutamine õnnestus!";
        }

        $stmt->close();

    }

    function lookForPairId($pairId){

        $stmt = $this->connection->prepare("
                SELECT pairId 
                FROM tudengivarjud
                WHERE pairId=?
            ");
        echo $this->connection->error;

        $stmt->bind_param("i",$pairId);

        $stmt->bind_result($pairId);
        $stmt->execute();

        if ($stmt->fetch()) {
            echo "muutsin";
            $_SESSION["pairIdExists"]= 1;
        }else {
            header("location: adminLinked");
            exit();
        }

        $stmt->close();

    }

    function getWelcomeText(){

        $stmt = $this->connection->prepare("
			SELECT tekst
            FROM tervitusTekst
            ORDER BY id DESC
            LIMIT 1;
		");
        echo $this->connection->error;

//        $stmt->bind_param("i", $id);

        $stmt->bind_result($textFromDb);
        $stmt->execute();


        $text = new StdClass();
        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti

            $text->text = $textFromDb;


        }

        $stmt->close();

        return $text;
    }

    function saveNewText($newText){


        //yhendus olemas
        //kask
        $stmt = $this->connection->prepare("
            INSERT INTO tervitusTekst (tekst) 
            VALUES (?)");

        echo $this->connection->error;
        //asendan kysimargid vaartustega
        //iga muutuja kohta 1 taht
        //s tahistab stringi
        //i integer
        //d double/float
        $stmt->bind_param("s", $newText);

        if ($stmt->execute()) {
            echo "salvestamine onnestus ";
        } else {
            echo "ERROR " . $stmt->error;
        }
    }

    function getSpecificVarjud($eriala){

        $stmt = $this->connection->prepare("
			SELECT id, eesnimi, perekonnanimi, email, telefoninr, kool, vanus, bm, eriala, eriala2, pairId
            FROM tudengivarjud
            WHERE pairId=0 AND deleted is NULL AND (eriala=? OR eriala2=?)
            ORDER BY eriala
		");
        echo $this->connection->error;

        $stmt->bind_param("ss", $eriala, $eriala);

        $stmt->bind_result($id,$eesnimi,$perenimi,$email,$telnr, $kool, $vanus, $bm, $eriala, $eriala2, $pairId);
        $stmt->execute();


        //tekitan massiivi
        $result = array();

        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $person = new StdClass();
            $person->id = $id;
            $person->eesnimi = $eesnimi;
            $person->perekonnanimi = $perenimi;
            $person->email = $email;
            $person->telnr = $telnr;
            $person->kool = $kool;
            $person->vanus = $vanus;
            $person->bm = $bm;
            $person->eriala = $eriala;
            $person->eriala2 = $eriala2;
            $person->pairId = $pairId;

            array_push($result, $person);
        }

        $stmt->close();

        return $result;
    }

    function getSpecificTudengid($eriala){

        $stmt = $this->connection->prepare("
			SELECT id, eesnimi, perekonnanimi, email, telefoninr, vanus, eriala, kursus, bm, pairId
            FROM tudengid
            WHERE mituVarju>0 and deleted is NULL AND eriala=?
            ORDER BY eriala
		");
        echo $this->connection->error;

        $stmt->bind_param("s", $eriala);

        $stmt->bind_result($id,$eesnimi,$perenimi,$email,$telnr, $vanus, $eriala, $kursus, $bm, $pairId);
        $stmt->execute();


        //tekitan massiivi
        $result = array();

        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $tudeng = new StdClass();
            $tudeng->id = $id;
            $tudeng->eesnimi = $eesnimi;
            $tudeng->perekonnanimi = $perenimi;
            $tudeng->email = $email;
            $tudeng->telnr = $telnr;
            $tudeng->vanus = $vanus;
            $tudeng->eriala = $eriala;
            $tudeng->kursus = $kursus;
            $tudeng->bm = $bm;
            $tudeng->pairId = $pairId;

            array_push($result, $tudeng);
        }

        $stmt->close();

        return $result;
    }




}
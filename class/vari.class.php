<?php

class Vari
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

    function getBaka(){

        $stmt = $this->connection->prepare("
                SELECT eriala 
                FROM eriala WHERE bm LIKE ('baka')
                ORDER BY eriala
            ");
        echo $this->connection->error;

//        $stmt->bind_param("s",$bm);

        $stmt->bind_result($eriala);
        $stmt->execute();


        //tekitan massiivi
        $result = array();

        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $d = new StdClass();
            $d->eriala = $eriala;

            array_push($result, $d);
        }

        $stmt->close();

        return $result;
    }

    function getMagi(){

        $stmt = $this->connection->prepare("
                SELECT eriala 
                FROM eriala WHERE bm LIKE ('magi')
                ORDER BY eriala
            ");
        echo $this->connection->error;

//        $stmt->bind_param("s",$bm);

        $stmt->bind_result($eriala);
        $stmt->execute();


        //tekitan massiivi
        $result = array();

        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $d = new StdClass();
            $d->eriala = $eriala;

            array_push($result, $d);
        }

        $stmt->close();

        return $result;
    }

    function getBaka2(){

        $stmt = $this->connection->prepare("
                SELECT eriala 
                FROM eriala WHERE bm LIKE ('baka')
                ORDER BY eriala
            ");
        echo $this->connection->error;

//        $stmt->bind_param("s",$bm);

        $stmt->bind_result($eriala2);
        $stmt->execute();


        //tekitan massiivi
        $result = array();

        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $d = new StdClass();
            $d->eriala2 = $eriala2;

            array_push($result, $d);
        }

        $stmt->close();

        return $result;
    }

    function getMagi2(){

        $stmt = $this->connection->prepare("
                SELECT eriala 
                FROM eriala WHERE bm LIKE ('magi')
                ORDER BY eriala
            ");
        echo $this->connection->error;

//        $stmt->bind_param("s",$bm);

        $stmt->bind_result($eriala2);
        $stmt->execute();


        //tekitan massiivi
        $result = array();

        // tee seda seni, kuni on rida andmeid
        // mis vastab select lausele
        while ($stmt->fetch()) {

            //tekitan objekti
            $d = new StdClass();
            $d->eriala2 = $eriala2;

            array_push($result, $d);
        }

        $stmt->close();

        return $result;
    }

    function saveVari($eesnimi, $perenimi, $email, $telnr, $kool, $vanus, $bm, $eriala, $eriala2){


        //yhendus olemas
        //kask
        $stmt = $this->connection->prepare("INSERT INTO tudengivarjud (eesnimi, perekonnanimi, email, telefoninr, kool, vanus, bm, eriala, eriala2) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        echo $this->connection->error;
        //asendan kysimargid vaartustega
        //iga muutuja kohta 1 taht
        //s tahistab stringi
        //i integer
        //d double/float
        $stmt->bind_param("sssisisss", $eesnimi, $perenimi, $email, $telnr, $kool, $vanus, $bm, $eriala, $eriala2);

        if ($stmt->execute()) {
            echo "salvestamine onnestus ";
        } else {
            echo "ERROR " . $stmt->error;
        }
    }
}
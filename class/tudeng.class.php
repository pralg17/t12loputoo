<?php

class Tudeng
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

    function saveTudeng($eesnimi, $perenimi, $email, $telnr, $kursus, $vanus, $bm, $eriala, $mituVarju){


        //yhendus olemas
        //kask
        $stmt = $this->connection->prepare("INSERT INTO tudengid (eesnimi, perekonnanimi, email, telefoninr, kursus, vanus, bm, eriala, mituVarju) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        echo $this->connection->error;
        //asendan kysimargid vaartustega
        //iga muutuja kohta 1 taht
        //s tahistab stringi
        //i integer
        //d double/float
        $stmt->bind_param("sssisissi", $eesnimi, $perenimi, $email, $telnr, $kursus, $vanus, $bm, $eriala, $mituVarju);

        if ($stmt->execute()) {
            echo "salvestamine onnestus ";
        } else {
            echo "ERROR " . $stmt->error;
        }
    }


}
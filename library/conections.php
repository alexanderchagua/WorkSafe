<?php

function dataPrueba(){
    $server = 'localhost';
    $dbname= 'worksafe';
    $username = 'Client';
    $password = 'QRSu/3T[nWYMlL3W'; 
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    } catch(PDOException $e) {
        echo "Error de conexi贸n: " . $e->getMessage();
        exit; 
    }
}


?>
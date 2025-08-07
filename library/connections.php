<?php

function dataPrueba()
{
    /* Regular Connection*/

    $server = 'localhost';
    $dbname = 'worksafe';
    $username = 'clients';
    $password = 'TF8W-c!SyF]h2(s2';
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    /*
    David's Connection

    $server = 'localhost';
    $dbname = 'worksafe';
    $username = 'iClient';
    $password = 'yCg89Ird-oKxpMOC';
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    */

    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit; 
    }
}

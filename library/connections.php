<?php

function dataPrueba()
{
    /* Regular Connection*/

    $server = 'localhost';
    $dbname = 'worksafe';
    $username = 'worksafe';
    $password = 'DMEE0/hebGI5GW_g';
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
        exit; // Termina la ejecución del script si hay un error de conexión
    }
}

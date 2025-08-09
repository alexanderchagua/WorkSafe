<?php

function dataPrueba()
{
    /* Regular Connection*/

    $server = 'localhost';
    $dbname= 'worksafe';
    $username = 'Client';
    //$password = '9X(meYDO7PdQ)5!9';
    $password = 'ZEs3LS9wZ53ot/9q'; 

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

<?php

function dataPrueba()
{
    $server = 'localhost';
    $dbname = 'worksafe';
    $username = 'worksafe';
    $password = 'DMEE0/hebGI5GW_g';
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit;
    }
}

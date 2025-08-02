<?php

function dataPrueba(){
    $server = 'localhost';
    $dbname= 'prueba';
    $username = 'client';
    //$password = '9X(meYDO7PdQ)5!9';
    $password = 'XzTfr.-5_s@02EZ9'; 
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit; // Termina la ejecución del script si hay un error de conexión
    }
}

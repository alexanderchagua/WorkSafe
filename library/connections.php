<?php

function dataPrueba(){
    $server = 'localhost';
    $dbname= 'worksafe';
    $username = 'Client';
    //$password = '9X(meYDO7PdQ)5!9';
    $password = 'A6sk-4)6HiKHlUMt'; 
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

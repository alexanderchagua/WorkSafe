<?php

function dataPrueba()
{
    /* Regular connection parameters */
    $server = 'localhost';         // Database server address (localhost means the same server)
    $dbname = 'worksafe';          // Name of the database
    $username = 'clients';         // Database username
    //$password = '9X(meYDO7PdQ)5!9'; // (Old password - commented out)
    $password = 'M*PwWV(vDVuujlUP'; // Current database password

    // Data Source Name (DSN) for PDO connection
    $dsn = "mysql:host=$server;dbname=$dbname";

    // PDO options: enable exception mode for error handling
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    /*
    Alternative connection (David's connection)
    Uncomment this block if you want to use David's credentials instead of the regular one.
    
    $server = 'localhost';
    $dbname = 'worksafe';
    $username = 'iClient';
    $password = 'yCg89Ird-oKxpMOC';
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    */

    try {
        // Create a new PDO connection
        $link = new PDO($dsn, $username, $password, $options);
        return $link; // Return the connection object
    } catch (PDOException $e) {
        // Handle connection error
        echo "Connection error: " . $e->getMessage();
        exit; // Stop script execution if connection fails
    }
}
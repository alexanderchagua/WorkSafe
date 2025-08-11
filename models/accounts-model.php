<?php

// Function to register a new client in the database
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword)
{
    $db = dataPrueba(); // Get database connection

    // SQL insert query with placeholders for security (prepared statement)
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword)
            VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';

    // Prepare the SQL statement
    $stmt = $db->prepare($sql);

    // Bind parameters to the placeholders
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    // Get the number of affected rows (should be 1 if successful)
    $rowsChanged = $stmt->rowCount();

    // Close the cursor to free up the connection
    $stmt->closeCursor();

    return $rowsChanged; // Return the number of rows inserted
}

// Function to check if an email already exists in the database
function checkExistingEmail($clientEmail)
{
    $db = dataPrueba();

    // Query to check if email exists (SELECT 1 for efficiency)
    $sql = 'SELECT 1 FROM clients WHERE clientEmail = :email LIMIT 1';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the first column (true if exists, false if not)
    $exists = $stmt->fetchColumn();

    $stmt->closeCursor();

    // Return 1 if exists, 0 if not
    return $exists ? 1 : 0;
}

// Function to get client data by email
function getClient($clientEmail)
{
    $db = dataPrueba();

    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword 
            FROM clients 
            WHERE clientEmail = :clientEmail';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch as an associative array
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    return $clientData;
}

// Function to get client data by ID
function getClientId($clientId)
{
    $db = dataPrueba();

    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword 
            FROM clients 
            WHERE clientId = :clientId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();

    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    return $clientData;
}

// Function to update personal details (name, last name, email)
function updatePersonal($clientFirstname, $clientLastname, $clientEmail, $clientId)
{
    $db = dataPrueba();

    $sql = 'UPDATE clients 
            SET clientFirstname = :clientFirstname, 
                clientLastname = :clientLastname, 
                clientEmail = :clientEmail 
            WHERE clientId = :clientId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount();

    $stmt->closeCursor();
    return $rowsChanged;
}

// Function to update a client's password
function updateNewPassword($hashedPassword, $clientId)
{
    $db = dataPrueba();

    $sql = 'UPDATE clients 
            SET clientPassword = :clientPassword 
            WHERE clientId = :clientId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientPassword', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount();

    $stmt->closeCursor();
    return $rowsChanged;
}

<?php
require_once './library/connections.php'; // Include the database connection file

/**
 * Insert a new record into the inventory table
 *
 * @param string $code        The product code
 * @param string $description The product description
 * @param int    $stock       Current stock
 * @param int    $quantity    Quantity to add
 * @return bool               True on success, false on failure
 */
function insertData($code, $description, $stock, $quantity) {
    $pdo = dataPrueba(); // Get the database connection
    try {
        // Prepare SQL statement to insert data into the 'invetory' table
        $stmt = $pdo->prepare("INSERT INTO invetory (code, description, stock, quantity) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$code, $description, $stock, $quantity]); // Execute with bound parameters
    } catch (PDOException $e) {
        error_log("Error inserting data: " . $e->getMessage()); // Log any error
        return false; // Return false if insertion fails
    }
}

/**
 * Delete a record from the inventory table by its ID
 *
 * @param int $id The record ID to delete
 * @return bool   True on success, false on failure
 */
function deleteRecord($id) {
    $pdo = dataPrueba(); // Get the database connection
    try {
        // Prepare SQL statement to delete a record by ID
        $stmt = $pdo->prepare("DELETE FROM invetory WHERE id = ?");
        return $stmt->execute([$id]); // Execute with bound parameter
    } catch (PDOException $e) {
        error_log("Error deleting record: " . $e->getMessage()); // Log any error
        return false; // Return false if deletion fails
    }
}

/**
 * Update a record in the inventory table
 *
 * @param int    $id          The record ID to update
 * @param string $code        The product code
 * @param string $description The product description
 * @param int    $stock       Current stock
 * @param int    $quantity    Quantity to set
 * @return bool               True on success, false on failure
 */
function updateRecord($id, $code, $description, $stock, $quantity) {
    $pdo = dataPrueba(); // Get the database connection
    try {
        // Prepare SQL statement to update a record by ID
        $stmt = $pdo->prepare("UPDATE invetory SET code = ?, description = ?, stock = ?, quantity = ? WHERE id = ?");
        return $stmt->execute([$code, $description, $stock, $quantity, $id]); // Execute with bound parameters
    } catch (PDOException $e) {
        error_log("Error updating record: " . $e->getMessage()); // Log any error
        return false; // Return false if update fails
    }
}
?>

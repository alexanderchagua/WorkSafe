<?php
require_once './library/connections.php';

function insertData($code, $description, $stock, $quantity) {
    $pdo = dataPrueba();
    try {
        $stmt = $pdo->prepare("INSERT INTO invetory (code, description, stock, quantity) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$code, $description, $stock, $quantity]);
    } catch (PDOException $e) {
        error_log("Error inserting data: " . $e->getMessage());
        return false;
    }
}

function deleteRecord($id) {
    $pdo = dataPrueba();
    try {
        $stmt = $pdo->prepare("DELETE FROM invetory WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("Error deleting record: " . $e->getMessage());
        return false;
    }
}

function updateRecord($id, $code, $description, $stock, $quantity) {
    $pdo = dataPrueba();
    try {
        $stmt = $pdo->prepare("UPDATE invetory SET code = ?, description = ?, stock = ?, quantity = ? WHERE id = ?");
        return $stmt->execute([$code, $description, $stock, $quantity, $id]);
    } catch (PDOException $e) {
        error_log("Error updating record: " . $e->getMessage());
        return false;
    }
}
?>
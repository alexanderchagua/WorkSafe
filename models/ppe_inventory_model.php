<?php
require_once './library/connections.php';

function insertData($code, $description, $stock, $quantity) {
    $pdo = dataPrueba(); // Formerly dataPrueba()
    $stmt = $pdo->prepare("INSERT INTO invetory (code, description, stock, quantity) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$code, $description, $stock, $quantity]);
}

function deleteRecord($id) {
    $pdo = dataPrueba();
    $stmt = $pdo->prepare("DELETE FROM invetory WHERE id = ?");
    return $stmt->execute([$id]);
}

function updateRecord($id, $code, $description, $stock, $quantity) {
    $pdo = dataPrueba();
    $stmt = $pdo->prepare("UPDATE invetory SET code = ?, description = ?, stock = ?, quantity = ? WHERE id = ?");
    return $stmt->execute([$code, $description, $stock, $quantity, $id]);
}
?>

<?php
require_once './library/connections.php';

function getInventoryItems() {
    $db = dataPrueba();
    $sql = "SELECT * FROM inventory";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addInventoryItem($code, $description, $stock, $quantity) {
    $db = dataPrueba();
    $sql = "INSERT INTO inventory (Codigo, Descripcion, Stock, quantity) VALUES (:code, :description, :stock, :quantity)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':quantity', $quantity);
    return $stmt->execute();
}

function updateInventoryItem($id, $code, $description, $stock, $quantity) {
    $db = dataPrueba();
    $sql = "UPDATE inventory SET Codigo = :code, Descripcion = :description, Stock = :stock, quantity = :quantity WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':quantity', $quantity);
    return $stmt->execute();
}

function deleteInventoryItem($id) {
    $db = dataPrueba();
    $sql = "DELETE FROM inventory WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function searchInventoryItems($searchTerm) {
    $db = dataPrueba();
    $sql = "SELECT * FROM inventory WHERE Codigo LIKE :search OR Descripcion LIKE :search";
    $stmt = $db->prepare($sql);
    $searchParam = "%$searchTerm%";
    $stmt->bindParam(':search', $searchParam);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
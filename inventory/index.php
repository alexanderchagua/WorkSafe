<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/worksafe/models/ppe_inventory_model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/worksafe/includes/dataPrueba.php';

header('Content-Type: application/json');

// Handle different actions
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'get_items':
            $items = getInventoryItems();
            echo json_encode(['success' => true, 'data' => $items]);
            break;
            
        case 'add_item':
            $code = $_POST['ppeCode'] ?? '';
            $name = $_POST['ppeName'] ?? '';
            $category = $_POST['ppeCategory'] ?? '';
            $size = $_POST['ppeSize'] ?? '';
            $quantity = $_POST['ppeQuantity'] ?? 0;
            
            // Combine name, category and size into description
            $description = trim("$name - $category - $size");
            
            $success = addInventoryItem($code, $description, 0, $quantity);
            echo json_encode(['success' => $success]);
            break;
            
        case 'update_item':
            $id = $_POST['id'] ?? 0;
            $code = $_POST['code'] ?? '';
            $description = $_POST['description'] ?? '';
            $stock = $_POST['stock'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            
            $success = updateInventoryItem($id, $code, $description, $stock, $quantity);
            echo json_encode(['success' => $success]);
            break;
            
        case 'delete_item':
            $id = $_POST['id'] ?? 0;
            $success = deleteInventoryItem($id);
            echo json_encode(['success' => $success]);
            break;
            
        case 'search_items':
            $searchTerm = $_GET['term'] ?? '';
            $items = searchInventoryItems($searchTerm);
            echo json_encode(['success' => true, 'data' => $items]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
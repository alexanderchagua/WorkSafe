<?php
// Main controller for WorkSafe

session_start();

// Load dependencies
require_once './library/connections.php';
require_once './library/nav.php';
require_once './models/main-model.php';

// Build navigation menu
$navs = getNavs();
$navList = buildNavList($navs);


require_once './models/ppe_inventory_model.php';

$pdo = dataPrueba(); // Changed from dataPrueba
$stmt = $pdo->query("SELECT * FROM invetory"); // Corrected table name spelling
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteRecord($id)) {
        echo "Record deleted successfully.";
        
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting the record.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['code'])) {
        $code = $_POST['code'];
        $description = $_POST['description'];
        $stock = $_POST['stock'];
        $quantity = $_POST['quantity'];

        if (insertData($code, $description, $stock, $quantity)) {
            echo "Data inserted successfully.";
            
            header("Location: index.php");
            exit();
        } else {
            echo "Error inserting the data.";
        }
    }

    if (isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];
        $code = $_POST['newCode'];
        $description = $_POST['newDescription'];
        $stock = $_POST['newStock'];
        $quantity = $_POST['newQuantity'];

        if (updateRecord($id, $code, $description, $stock, $quantity)) {
            echo "Record updated successfully.";
            
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating the record.";
        }
    }
}



$action = filter_input(INPUT_GET, 'action');
if (!$action) {
    $action = 'home';
}

// Redirect account-related actions to accounts controller
$accountActions = [
    'login',
    'Login',
    'Logout',
    'register',
    'registration',
    'updateInfo',
    'updatePersonal',
    'updatePassword'
];

if (in_array($action, $accountActions)) {
    header('Location: /worksafe/accounts/index.php?action=' . urlencode($action));
    exit;
}

// Route for general actions
switch ($action) {
    case 'Add Personal':
        include './views/addPerson.php';
        break;

    case 'Statistics':
        require_once './stadistics/index.php';
        break;
    case 'Login':
        include './views/login.php';

    case 'Search':
        include './views/search.php';
        break;
    case 'Inventory':
        include './views/ppe_inventory.php';
        break;

    case 'Join':
        include './views/join_form.php';
        break;
    

    case 'home':
    default:
        include './views/home.php';
        break;
}

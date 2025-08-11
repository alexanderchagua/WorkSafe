<?php
// Main controller for WorkSafe

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load dependencies
require_once './library/connections.php';
require_once './library/nav.php';
require_once './models/main-model.php';

// Build navigation menu
$navs = getNavs();
$navList = buildNavList($navs);

require_once './models/ppe_inventory_model.php';

$pdo = dataPrueba();


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
        break;

    case 'Search':
        // Only require search_model when we need it, and use correct path
        if (!function_exists('obtenerDatosPorNombre')) {
            require_once './models/search_model.php';
        }
        
        // Initialize personas array
        $personas = [];
        
        // Check if we have search results from session
        if (isset($_SESSION['search_results'])) {
            $personas = $_SESSION['search_results'];
            // Clear the search results from session after using them
            unset($_SESSION['search_results']);
        }
        
        // Get search parameters if they exist
        $search_params = isset($_SESSION['search_params']) ? $_SESSION['search_params'] : ['nombre' => '', 'area_trabajo' => ''];
        if (isset($_SESSION['search_params'])) {
            // Don't clear search_params immediately, keep them for form display
            // They will be cleared after the view is rendered
        }
        
        include './views/search.php';
        
        // Clear search params after including the view
        if (isset($_SESSION['search_params'])) {
            unset($_SESSION['search_params']);
        }
        break;
        
   case 'Inventory':
    $stmt = $pdo->query("SELECT * FROM invetory");
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle delete operation
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        if (deleteRecord($id)) {
            $_SESSION['message'] = "Record deleted successfully.";
        } else {
            $_SESSION['error'] = "Error deleting the record.";
        }
        header("Location: index.php?action=Inventory");
        exit();
    }

    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['code'])) {
            // Insert new record
            $code = $_POST['code'];
            $description = $_POST['description'];
            $stock = $_POST['stock'];
            $quantity = $_POST['quantity'];

            if (insertData($code, $description, $stock, $quantity)) {
                $_SESSION['message'] = "Data inserted successfully.";
            } else {
                $_SESSION['error'] = "Error inserting the data.";
            }
            header("Location: index.php?action=Inventory");
            exit();
        }

        if (isset($_POST['edit_id'])) {
            // Update existing record
            $id = $_POST['edit_id'];
            $code = $_POST['newCode'];
            $description = $_POST['newDescription'];
            $stock = $_POST['newStock'];
            $quantity = $_POST['newQuantity'];

            if (updateRecord($id, $code, $description, $stock, $quantity)) {
                $_SESSION['message'] = "Record updated successfully.";
            } else {
                $_SESSION['error'] = "Error updating the record.";
            }
            header("Location: index.php?action=Inventory");
            exit();
        }
    }
    
    // Display messages if they exist
    if (isset($_SESSION['message'])) {
        echo "<p style='color: green;'>".$_SESSION['message']."</p>";
        unset($_SESSION['message']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>".$_SESSION['error']."</p>";
        unset($_SESSION['error']);
    }
    
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
?>
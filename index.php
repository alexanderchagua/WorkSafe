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

// Determine the requested action
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
        require_once './views/dasboard.php';
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

<?php
// This is the main controller

// Create or access a Session
session_start();

require_once './library/connections.php';
require_once './library/nav.php';
require_once './models/main-model.php';

$navs = getNavs();
$navList = buildNavList($navs);

//var_dump($navs);
//exit;
//echo $navList;
//exit;

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'login':
    case 'Login':
    case 'Logout':
    case 'register':
    case 'registration':
    case 'updateInfo':
    case 'updatePersonal':
    case 'updatePassword':
        header('Location: /worksafe/accounts/index.php?action=' . urlencode($action));
        exit;

    case 'Add Personal':
        include './views/addPerson.php';
        break;

    case 'Search':
        include './views/search.php';
        break;

    default:
        include './views/home.php';
        break;
    case 'Join':
        include './views/join_form.php';
        break;
}

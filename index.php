<?php

require_once './library/conections.php';
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
    case 'Add Personal':
        include './views/addPerson.php';
        break;
    case 'Search':
        include './views/search.php';
        break;
    case 'Login':
        include './views/login.php';
        break;
    default:
        include './views/home.php';
        break;
}



?>
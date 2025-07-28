<?php
// Accounts Controller

session_start();

require_once '../library/connections.php';
require_once '../models/main-model.php';
require_once '../models/accounts-model.php';
require_once '../library/functions.php';
require_once '../library/nav.php';

$navs = getNavs();
$navList = buildNavList($navs);

// Detect action
$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? 'login';

// Leer cookie de firstname si existe
if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action) {

    case 'registration':
        include '../views/registration.php';
        break;

    case 'register':
        // Procesar datos de registro
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $existingEmail = checkExistingEmail($clientEmail);
        if ($existingEmail) {
            $message = '<p>That email address already exists. Do you want to login instead?</p>';
            include '../views/login.php';
            exit;
        }

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../views/registration.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
            header('Location: ../accounts/?action=login');
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../views/registration.php';
            exit;
        }

    case 'login':
        include '../views/login.php';
        break;

    case 'Login':
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $clientEmail = checkEmail($clientEmail);
        $passwordCheck = checkPassword($clientPassword);

        if (empty($clientEmail) || empty($passwordCheck)) {
            $message = '<p>Please provide a valid email address and password.</p>';
            include '../views/login.php';
            exit;
        }

        $clientData = getClient($clientEmail);
        if (!password_verify($clientPassword, $clientData['clientPassword'])) {
            $message = '<p>Please check your password and try again.</p>';
            include '../views/login.php';
            exit;
        }

        // Login OK
        $_SESSION['loggedin'] = true;
        unset($clientData['clientPassword']); // safer than array_pop
        $_SESSION['clientData'] = $clientData;
        include '../views/admin.php';
        exit;

    case 'updateInfo':
        include '../views/client-update.php';
        break;

    case 'updatePersonal':
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $clientEmail = checkEmail($clientEmail);

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($invId)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../views/client-update.php';
            exit;
        }

        $resultPersonal = updatePersonal($clientFirstname, $clientLastname, $clientEmail, $invId);

        $clientData = getClientId($invId);
        unset($clientData['clientPassword']);
        $_SESSION['clientData'] = $clientData;

        if ($resultPersonal === 1) {
            $_SESSION['message'] = "<p>Information update was a success.</p>";
        } else {
            $_SESSION['message'] = "<p>Sorry, but information update failed. Please try again.</p>";
        }

        header('location: /worksafe/accounts/');
        exit;

    case 'updatePassword':
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $passwordCheck = checkPassword($clientPassword);
        if (empty($passwordCheck)) {
            $message = '<p>Please provide a valid password.</p>';
            include '../views/client-update.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        $resultPassword = updateNewPassword($hashedPassword, $invId);

        if ($resultPassword === 1) {
            $_SESSION['message'] = "<p>Password update was a success.</p>";
        } else {
            $_SESSION['message'] = "<p>Sorry, but password update failed. Please try again.</p>";
        }

        header('location: /worksafe/accounts/');
        exit;

    case 'Logout':
        session_destroy();
        header('Location: ../accounts/?action=login');
        exit;

    case 'error':
        include '../views/500.php';
        break;

    default:
        include '../views/home.php';
        break;
}

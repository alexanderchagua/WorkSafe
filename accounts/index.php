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

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? 'login';

if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action) {

    case 'registration':
        include '../views/registration.php';
        break;

    case 'register':
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $confirmPassword = trim(filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if ($clientPassword !== $confirmPassword) {
            $message = "<p>Passwords do not match.</p>";
            include '../views/registration.php';
            exit;
        }

        $existingEmail = checkExistingEmail($clientEmail);
        if ($existingEmail) {
            $message = '<p>That email address already exists. Do you want to login instead?</p>';
            include '../views/login.php';
            exit;
        }

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please fill in all required fields with valid data.</p>';
            include '../views/registration.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please login.";
            header('Location: ../accounts/?action=login');
            exit;
        } else {
            $message = "<p>Registration failed. Please try again.</p>";
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
            $message = '<p>Invalid email or password format.</p>';
            include '../views/login.php';
            exit;
        }

        $clientData = getClient($clientEmail);
        if (!$clientData || !password_verify($clientPassword, $clientData['clientPassword'])) {
            $message = 'Email or password is incorrect.';
            include '../views/login.php';
            exit;
        }

        $_SESSION['loggedin'] = true;
        unset($clientData['clientPassword']);
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
            $message = '<p>Please complete all fields.</p>';
            include '../views/client-update.php';
            exit;
        }

        // Verificar si el nuevo email ya está en uso por otro usuario
        $emailOwner = getClient($clientEmail);
        if ($emailOwner && $emailOwner['clientId'] != $invId) {
            $message = '<p>Email already in use by another user.</p>';
            include '../views/client-update.php';
            exit;
        }

        $resultPersonal = updatePersonal($clientFirstname, $clientLastname, $clientEmail, $invId);

        $clientData = getClientId($invId);
        unset($clientData['clientPassword']);
        $_SESSION['clientData'] = $clientData;

        $_SESSION['message'] = $resultPersonal === 1
            ? "<p>Information update was a success.</p>"
            : "<p>Update failed. Please try again.</p>";

        header('location: /worksafe/accounts/');
        exit;

    case 'updatePassword':
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if ($clientPassword !== $confirmPassword) {
            $message = '<p>Passwords do not match.</p>';
            include '../views/client-update.php';
            exit;
        }

        $passwordCheck = checkPassword($clientPassword);
        if (empty($passwordCheck)) {
            $message = '<p>Please provide a valid password.</p>';
            include '../views/client-update.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        $resultPassword = updateNewPassword($hashedPassword, $invId);

        $_SESSION['message'] = $resultPassword === 1
            ? "<p>Password updated successfully.</p>"
            : "<p>Failed to update password. Please try again.</p>";

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

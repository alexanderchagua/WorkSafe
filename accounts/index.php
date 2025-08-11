<?php
// Accounts Controller
// This controller handles user account-related actions such as registration, login, updating profile, and logout.

session_start(); // Start or resume the session

// Include necessary dependencies and functions
require_once '../library/connections.php';     // Database connection
require_once '../models/main-model.php';       // Main model functions
require_once '../models/accounts-model.php';   // Account-specific model functions
require_once '../library/functions.php';       // Utility functions
require_once '../library/nav.php';             // Navigation menu functions

// Build the navigation menu
$navs = getNavs();                // Get navigation data
$navList = buildNavList($navs);   // Create HTML list for navigation

// Determine the requested action from POST or GET, defaulting to 'login'
$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? 'login';

// Check if a firstname cookie exists and sanitize it
if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

// Action handling using a switch statement
switch ($action) {

    // Show the registration form
    case 'registration':
        include '../views/registration.php';
        break;

    // Process registration form data
    case 'register':
        // Get and sanitize form inputs
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $confirmPassword = trim(filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Ensure passwords match
        if ($clientPassword !== $confirmPassword) {
            $message = "<p>Passwords do not match.</p>";
            include '../views/registration.php';
            exit;
        }

        // Check if email is already registered
        $existingEmail = checkExistingEmail($clientEmail);
        if ($existingEmail) {
            $message = '<p>That email address already exists. Do you want to login instead?</p>';
            include '../views/login.php';
            exit;
        }

        // Validate email format and password strength
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Ensure all fields are filled with valid data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please fill in all required fields with valid data.</p>';
            include '../views/registration.php';
            exit;
        }

        // Hash the password for security
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Attempt to register the new client
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        if ($regOutcome === 1) {
            // Store firstname in cookie and session message, then redirect to login
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please login.";
            header('Location: ../accounts/?action=login');
            exit;
        } else {
            $message = "<p>Registration failed. Please try again.</p>";
            include '../views/registration.php';
            exit;
        }

    // Show the login form
    case 'login':
        include '../views/login.php';
        break;

    // Process login form data
    case 'Login':
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Validate email and password format
        $clientEmail = checkEmail($clientEmail);
        $passwordCheck = checkPassword($clientPassword);

        if (empty($clientEmail) || empty($passwordCheck)) {
            $message = '<p>Invalid email or password format.</p>';
            include '../views/login.php';
            exit;
        }

        // Retrieve client data from the database
        $clientData = getClient($clientEmail);

        // Verify credentials
        if (!$clientData || !password_verify($clientPassword, $clientData['clientPassword'])) {
            $message = 'Email or password is incorrect.';
            include '../views/login.php';
            exit;
        }

        // Set session variables for the logged-in user
        $_SESSION['loggedin'] = true;
        unset($clientData['clientPassword']); // Remove password from session
        $_SESSION['clientData'] = $clientData;

        // Load the admin dashboard
        include '../views/admin.php';
        exit;

    // Show update profile form
    case 'updateInfo':
        include '../views/client-update.php';
        break;

    // Process personal info update
    case 'updatePersonal':
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        // Validate email format
        $clientEmail = checkEmail($clientEmail);

        // Ensure no empty required fields
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($invId)) {
            $message = '<p>Please complete all fields.</p>';
            include '../views/client-update.php';
            exit;
        }

        // Check if new email is already used by another user
        $emailOwner = getClient($clientEmail);
        if ($emailOwner && $emailOwner['clientId'] != $invId) {
            $message = '<p>Email already in use by another user.</p>';
            include '../views/client-update.php';
            exit;
        }

        // Update personal info
        $resultPersonal = updatePersonal($clientFirstname, $clientLastname, $clientEmail, $invId);

        // Refresh session with updated client data
        $clientData = getClientId($invId);
        unset($clientData['clientPassword']);
        $_SESSION['clientData'] = $clientData;

        // Store success or failure message
        $_SESSION['message'] = $resultPersonal === 1
            ? "<p>Information update was a success.</p>"
            : "<p>Update failed. Please try again.</p>";

        // Redirect to accounts page
        header('location: /worksafe/accounts/');
        exit;

    // Process password update
    case 'updatePassword':
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        // Ensure passwords match
        if ($clientPassword !== $confirmPassword) {
            $message = '<p>Passwords do not match.</p>';
            include '../views/client-update.php';
            exit;
        }

        // Validate password format
        $passwordCheck = checkPassword($clientPassword);
        if (empty($passwordCheck)) {
            $message = '<p>Please provide a valid password.</p>';
            include '../views/client-update.php';
            exit;
        }

        // Hash and update the password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        $resultPassword = updateNewPassword($hashedPassword, $invId);

        // Store success or failure message
        $_SESSION['message'] = $resultPassword === 1
            ? "<p>Password updated successfully.</p>"
            : "<p>Failed to update password. Please try again.</p>";

        // Redirect to accounts page
        header('location: /worksafe/accounts/');
        exit;

    // Handle user logout
    case 'Logout':
        session_destroy(); // End session
        header('Location: ../accounts/?action=login'); // Redirect to login
        exit;

    // Show error page for internal server errors
    case 'error':
        include '../views/500.php';
        break;

    // Default action: show home page
    default:
        include '../views/home.php';
        break;
}

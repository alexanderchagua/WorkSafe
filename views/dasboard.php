<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php

// Check if the user is logged in
if (!isset($_SESSION['clientData'])) {
    echo "<p style='color: red;'>Access denied. You must be logged in.</p>";
    header("refresh:3;url=/worksafe/index.php"); // redirects after 3 seconds
    exit;
}

// Check if the user has level 1 access
if ($_SESSION['clientData']['clientLevel'] != 1) {
    echo "<p style='color: red;'>You do not have permission to access this page.</p>";
    header("refresh:3;url=/worksafe/index.php"); // redirects after 3 seconds
    exit;
}
?>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/stadistics/index.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>

<?php
// Start a new session if one has not been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php 
// Include the header file
include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; 

// Include the main content file
include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/main.php"; 

// Include the footer file
include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; 
?>
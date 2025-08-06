<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/main.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>

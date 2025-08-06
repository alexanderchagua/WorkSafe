<?php
// Redirección inmediata si el usuario no está autenticado

if (!isset($_SESSION['clientData'])) {
    header('Location: /worksafe/accounts/index.php?action=login');
    exit;
}
$client = $_SESSION['clientData'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WorkSafe Admin Panel</title>
    <meta name="description" content="WorkSafe Admin Panel" />
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

    <main>
        <h1>Welcome to Your Dashboard</h1>

        <p><strong>Name:</strong> <?= htmlspecialchars($client['clientFirstname'] . ' ' . $client['clientLastname']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($client['clientEmail']) ?></p>

        <?php if (isset($_SESSION['message'])): ?>
            <p class="message"><?= htmlspecialchars($_SESSION['message']) ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <h2>Account Options</h2>
        <ul>
            <li><a href="/worksafe/accounts/index.php?action=updateInfo">Update Account Info</a></li>
            <li><a href="/worksafe/accounts/index.php?action=Logout">Log Out</a></li>
        </ul>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>

</html>
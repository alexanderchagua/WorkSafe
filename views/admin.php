<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkSafe Admin Panel</title>
    <meta name="description" content="WorkSafe Admin Panel" />
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

    <main>
        <h1>Welcome to Your Dashboard</h1>

        <?php if (isset($_SESSION['clientData'])):
            $client = $_SESSION['clientData']; ?>
            <p><strong>Name:</strong> <?= htmlspecialchars($client['clientFirstname'] . ' ' . $client['clientLastname']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($client['clientEmail']) ?></p>

            <?php if (isset($_SESSION['message'])) {
                echo "<p class='message'>{$_SESSION['message']}</p>";
                unset($_SESSION['message']);
            } ?>

            <h2>Account Options</h2>
            <ul>
                <li><a href="/worksafe/accounts/index.php?action=updateInfo">Update Account Info</a></li>
                <li><a href="/worksafe/accounts/index.php?action=Logout">Log Out</a></li>
            </ul>
        <?php else: ?>
            <p>You are not logged in. <a href="/worksafe/accounts/index.php?action=login">Login here</a>.</p>
        <?php endif; ?>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>

</html>
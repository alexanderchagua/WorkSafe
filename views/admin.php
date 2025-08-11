<?php
// Immediate redirection if the user is not authenticated
if (!isset($_SESSION)) session_start();

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
    <style>
      main {
        max-width: 600px;
        margin: 2rem auto; /* center the container */
        padding: 1rem;
        text-align: left; /* align text to the left */
      }
      main ul {
        list-style: none;
        padding: 0;
      }
      main ul li {
        margin: 0.5rem 0;
      }
      main a {
        color: var(--active-color, #007acc);
        text-decoration: none;
        font-weight: 600;
      }
      main a:hover {
        text-decoration: underline;
      }
      .message {
        background-color: #dff0d8;
        color: #3c763d;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        margin: 1rem 0;
      }
    </style>
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

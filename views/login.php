<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkSafe Login</title>
    <meta name="description" content="WorkSafe Login" />
    <link rel="stylesheet" href="/worksafe/css/login.css">

</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

    <main>
        <h1>Sign In</h1>

        <?php

        if (isset($message)) {
            echo "<p class='message'>" . htmlspecialchars($message) . "</p>";
        }
        if (isset($_SESSION['message'])) {
            echo "<p class='message'>" . htmlspecialchars($_SESSION['message']) . "</p>";
            unset($_SESSION['message']);
        }
        ?>

        <form method="post" action="/worksafe/accounts/index.php">
            <label for="clientEmail">Email:</label><br>
            <input type="email" id="clientEmail" name="clientEmail"
                value="<?= htmlspecialchars($clientEmail ?? '') ?>" required><br><br>

            <label for="clientPassword">Password:</label><br>
            <span>
                Password must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.
            </span><br>
            <input type="password" id="clientPassword" name="clientPassword" required
                pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>

            <input type="submit" name="submit" id="logbtn" value="Login">
            <input type="hidden" name="action" value="Login">
        </form>

        <p><a href="/worksafe/accounts/?action=registration" class="link">Not a member yet? Register here</a></p>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>

</html>
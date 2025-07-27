<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkSafe Registration</title>
    <meta name="description" content="WorkSafe Registration" />
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

    <main>
        <h1>Register</h1>

        <?php
        if (isset($message)) {
            echo "<p class='message'>$message</p>";
        }
        ?>

        <form method="post" action="/worksafe/accounts/index.php">
            <fieldset>

                <label for="fname">First Name:</label><br>
                <input type="text" id="fname" name="clientFirstname" required
                    value="<?= isset($clientFirstname) ? htmlspecialchars($clientFirstname) : '' ?>"><br>

                <label for="lname">Last Name:</label><br>
                <input type="text" id="lname" name="clientLastname" required
                    value="<?= isset($clientLastname) ? htmlspecialchars($clientLastname) : '' ?>"><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="clientEmail" required placeholder="Enter a valid email address"
                    value="<?= isset($clientEmail) ? htmlspecialchars($clientEmail) : '' ?>"><br>

                <label for="password">Password:</label><br>
                <span class="tooltip">
                    Password must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character.
                </span><br>
                <input type="password" id="password" name="clientPassword" required
                    pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>

                <input type="submit" name="submit" id="regbtn" value="Register">
                <input type="hidden" name="action" value="register">

            </fieldset>
        </form>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>

</html>
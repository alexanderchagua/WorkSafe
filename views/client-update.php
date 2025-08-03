<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkSafe - Update Information</title>
    <meta name="description" content="WorkSafe - Update information" />
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

    <main>
        <h1>Update Account Information</h1>
        <p>*Note all fields are required</p>

        <?php if (isset($message)) echo $message; ?>

        <form action="/worksafe/accounts/index.php" method="POST">
            <label for="clientFirstname">New First Name</label><br>
            <input type="text" name="clientFirstname" id="clientFirstname"
                value="<?php echo isset($clientFirstname) ? htmlspecialchars($clientFirstname) : htmlspecialchars($_SESSION['clientData']['clientFirstname'] ?? ''); ?>" required><br><br>

            <label for="clientLastname">New Last Name</label><br>
            <input type="text" name="clientLastname" id="clientLastname"
                value="<?php echo isset($clientLastname) ? htmlspecialchars($clientLastname) : htmlspecialchars($_SESSION['clientData']['clientLastname'] ?? ''); ?>" required><br><br>

            <label for="clientEmail">New Email</label><br>
            <input type="email" name="clientEmail" id="clientEmail"
                value="<?php echo isset($clientEmail) ? htmlspecialchars($clientEmail) : htmlspecialchars($_SESSION['clientData']['clientEmail'] ?? ''); ?>" required><br><br>

            <input type="submit" value="Update Account">

            <input type="hidden" name="action" value="updatePersonal">
            <input type="hidden" name="invId" value="<?php echo $_SESSION['clientData']['clientId'] ?? ''; ?>">
        </form>

        <h2>Change Password</h2>
        <p>
            Passwords must be at least 8 characters and contain at least 1
            number, 1 capital letter, and 1 special character.
        </p>

        <form action="/worksafe/accounts/index.php" method="POST" id="passwordForm">
            <label for="clientPassword">New Password</label><br>
            <input type="password" name="clientPassword" id="clientPassword" required
                pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>

            <label for="confirmPassword">Confirm Password</label><br>
            <input type="password" name="confirmPassword" id="confirmPassword" required><br><br>

            <input type="submit" value="Update Password">
            <input type="hidden" name="action" value="updatePassword">
            <input type="hidden" name="invId" value="<?php echo $_SESSION['clientData']['clientId'] ?? ''; ?>">
        </form>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkSafe login</title>
    <meta name="description" content="WorkSafe Login" />
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

    <main>
        <h1>Sign in</h1>

        <?php
        if (isset($message)) {
            echo $message;
        }
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        ?>

        <form method="post" action="/worksafe/accounts/">
            <label for="email">Email:</label><br>

            <input type="email" id="clientEmail" name="clientEmail" required><br>
            <?php if (isset($clientEmail)) {
                echo "value='$clientEmail'";
            }  ?><br>

            <label for="password">Password:</label><br>

            <span>Password must be at least 8 characters and contain at least 1 number, ,1 capital letter and 1 special character</span> <br>
            <input type="password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>

            <input type="submit" name="submit" id="logbtn" value="Login">

            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="Login">
        </form>

        <a href="index.php?action=registration" class="link">Not a member yet?</a>

    </main>


    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>

</html>
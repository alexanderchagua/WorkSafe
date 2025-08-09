<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>WorkSafe Registration</title>
    <meta name="description" content="WorkSafe Registration" />
    <style>
       /* Reset básico */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* Body igual que login */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Contenedor principal */
main {
    max-width: 400px;
    width: 90%;
    margin: 40px auto;
    background: transparent;
    padding: 2rem;
    border-radius: 10px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Quitar borde y padding default de fieldset */
fieldset {
    border: none;
    padding: 0;
    margin: 0;
}

/* Título */
h1 {
    text-align: center;
    color: #333;
    margin-bottom: 1.5rem;
}

/* Mensaje de error o alerta */
.message {
    background-color: #ffdddd;
    color: #a94442;
    padding: 0.8rem;
    margin-bottom: 1rem;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
}

/* Labels */
label {
    font-weight: bold;
    display: block;
    margin-bottom: 0.3rem;
    color: #333;
}

/* Inputs */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 0.6rem;
    margin-bottom: 1rem;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 1rem;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
    outline: none; /* quita el outline por defecto */
}

/* Tooltip para indicaciones */
.tooltip {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 0.3rem;
    display: block;
}

/* Botón submit */
input[type="submit"] {
    width: 100%;
    padding: 0.8rem;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
    outline: none; /* quita outline en botón */
}

input[type="submit"]:hover {
    background-color: #218838;
}

/* Responsive para móviles */
@media (max-width: 400px) {
    main {
        margin: 20px;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid #bbb;
    }
}

    </style>
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

        <form method="post" action="/worksafe/accounts/index.php" novalidate>
            <fieldset>
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="clientFirstname" required
                    value="<?= isset($clientFirstname) ? htmlspecialchars($clientFirstname) : '' ?>">

                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="clientLastname" required
                    value="<?= isset($clientLastname) ? htmlspecialchars($clientLastname) : '' ?>">

                <label for="email">Email:</label>
                <input type="email" id="email" name="clientEmail" required placeholder="Enter a valid email address"
                    value="<?= isset($clientEmail) ? htmlspecialchars($clientEmail) : '' ?>">

                <label for="password">Password:</label>
                <span class="tooltip">
                    Password must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character.
                </span>
                <input type="password" id="password" name="clientPassword" required
                    pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>

                <input type="hidden" name="action" value="register">
                <input type="submit" name="submit" id="regbtn" value="Register">
            </fieldset>
        </form>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>

</html>

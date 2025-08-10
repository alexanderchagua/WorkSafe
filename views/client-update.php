<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>WorkSafe - Update Information</title>
    <meta name="description" content="WorkSafe - Update information" />
    <style>
      main {
        max-width: 600px;
        margin: 2rem auto;
        padding: 1rem;
        text-align: left;
        font-family: Arial, sans-serif;
      }
      h1, h2 {
        margin-bottom: 1rem;
      }
      p {
        margin-bottom: 1rem;
      }
      form {
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }
      label {
        font-weight: 600;
      }
      input[type="text"],
      input[type="email"],
      input[type="password"] {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        width: 100%;
        box-sizing: border-box;
      }
      /* Botones más pequeños y sutiles */
      input[type="submit"] {
        background-color: #f0f0f0; /* gris muy claro */
        color: #333; /* gris oscuro */
        border: 1px solid #ccc;
        padding: 0.5rem 0.75rem; /* más pequeño */
        border-radius: 4px;
        font-size: 0.9rem;
        cursor: pointer;
        width: auto; /* tamaño ajustado al texto */
        align-self: flex-start; /* que no ocupe todo el ancho */
        transition: background-color 0.3s ease;
      }
      input[type="submit"]:hover {
        background-color: #e0e0e0; /* un poco más oscuro al pasar el mouse */
      }
      .message {
        background-color: #dff0d8;
        color: #3c763d;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        margin-bottom: 1rem;
      }
    </style>
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

    <main>
        <h1>Update Account Information</h1>
        <p>*Note all fields are required</p>

        <?php if (isset($message)) echo '<p class="message">' . $message . '</p>'; ?>

        <form action="/worksafe/accounts/index.php" method="POST">
            <label for="clientFirstname">New First Name</label>
            <input type="text" name="clientFirstname" id="clientFirstname"
                value="<?php echo isset($clientFirstname) ? htmlspecialchars($clientFirstname) : htmlspecialchars($_SESSION['clientData']['clientFirstname'] ?? ''); ?>" required>

            <label for="clientLastname">New Last Name</label>
            <input type="text" name="clientLastname" id="clientLastname"
                value="<?php echo isset($clientLastname) ? htmlspecialchars($clientLastname) : htmlspecialchars($_SESSION['clientData']['clientLastname'] ?? ''); ?>" required>

            <label for="clientEmail">New Email</label>
            <input type="email" name="clientEmail" id="clientEmail"
                value="<?php echo isset($clientEmail) ? htmlspecialchars($clientEmail) : htmlspecialchars($_SESSION['clientData']['clientEmail'] ?? ''); ?>" required>

            <input type="hidden" name="action" value="updatePersonal">
            <input type="hidden" name="invId" value="<?php echo $_SESSION['clientData']['clientId'] ?? ''; ?>">

            <input type="submit" value="Update Account">
        </form>

        <h2>Change Password</h2>
        <p>
            Passwords must be at least 8 characters and contain at least 1
            number, 1 capital letter, and 1 special character.
        </p>

        <form action="/worksafe/accounts/index.php" method="POST" id="passwordForm">
            <label for="clientPassword">New Password</label>
            <input type="password" name="clientPassword" id="clientPassword" required
                pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword" required>

            <input type="hidden" name="action" value="updatePassword">
            <input type="hidden" name="invId" value="<?php echo $_SESSION['clientData']['clientId'] ?? ''; ?>">

            <input type="submit" value="Update Password">
        </form>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>

</html>

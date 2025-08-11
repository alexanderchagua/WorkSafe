<?php
// common/header.php
// This file is the common header used across the application.
// It includes meta information, stylesheets, navigation menu, and the header layout.
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>
        <?php
        // Display the page title if $pageTitle is set, otherwise show a default title
        echo isset($pageTitle) ? $pageTitle : 'worksafe - system safe';
        ?>
    </title>

    <!-- External Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Main CSS Styles -->
    <link rel="stylesheet" href="/worksafe/css/style.css" />
    <link rel="stylesheet" href="/worksafe/css/header.css" />
    <link rel="stylesheet" href="/worksafe/css/addperson.css" />

    <!-- Intl Tel Input CSS for international phone number formatting -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.5/build/css/intlTelInput.min.css" />
</head>

<body>
    <!-- HEADER SECTION -->
    <header class="header">
        <!-- Logo section with image and brand name -->
        <div class="logo-container">
            <img src="/worksafe/images/logo.jpeg" alt="worksafe Logo" class="logo" />
            <div class="logo-text">Work<span>Safe</span></div>
        </div>

        <!-- Mobile hamburger button for responsive menu -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Main navigation menu -->
        <nav class="nav-menu" id="navMenu">
            <ul class="navigation">
                <?php
                if (isset($navList)) {
                    // Remove <ul> tags from $navList if they already exist to avoid duplication
                    echo preg_replace('/<\/?ul[^>]*>/', '', $navList);
                } else {
                    // Fallback option if $navList is not defined
                    echo '<li><a href="/worksafe/index.php">Home</a></li>';
                }
                ?>

                <!-- Login button or user dropdown as the last item in the navigation -->
                <li class="user-nav">
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                        <!-- Dropdown menu for logged-in users -->
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button">
                                <i class="fas fa-user"></i>
                                <?php
                                // Display the logged-in user's first name, fallback to "User"
                                echo htmlspecialchars($_SESSION['clientData']['clientFirstname'] ?? 'User');
                                ?>
                                <i class="fas fa-caret-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="/worksafe/accounts/?action=updateInfo">Edit Profile</a>
                                <a href="/worksafe/accounts/?action=Logout">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Login button for non-logged-in users -->
                        <a href="/worksafe/accounts/?action=login" class="user-btn">
                            <i class="fas"></i> Login
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <script>
        // Wait for the DOM to be fully loaded before running scripts
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const navMenu = document.getElementById('navMenu');

            // Toggle hamburger menu for mobile navigation
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navMenu.classList.toggle('active');
            });

            // Close menu when a navigation link is clicked (mobile UX improvement)
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });

            // Highlight the active menu link based on the "action" URL parameter
            const currentAction = '<?php echo isset($_GET['action']) ? $_GET['action'] : 'home'; ?>';
            document.querySelectorAll('.nav-menu a').forEach(link => {
                const href = link.getAttribute('href');
                if (href.includes('action=' + currentAction) ||
                    (currentAction === 'home' && !href.includes('action='))) {
                    link.classList.add('active');
                }
            });
        });
    </script>

    <!-- External JavaScript for dropdown menu behavior -->
    <script src="/worksafe/views/js/dropdown.js"></script>

</body>

</html>
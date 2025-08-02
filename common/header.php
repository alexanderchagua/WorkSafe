 <?php
// common/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'worksafe - sytem safe'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/worksafe/css/style.css">
    <!-- Intl Tel Input CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.5/build/css/intlTelInput.min.css" />

</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="/worksafe/images/logo.jpeg" alt="worksafe Logo" class="logo">
            <div class="logo-text">Work<span>Safe</span></div>
        </div>
        
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
     <!-- 
        Este es el bloque original en header.php.
        El problema es que $navList no está definido si accedemos a páginas
        que no pasan por el controlador principal (index.php).
        Eso genera un warning de "Undefined variable" como por ejemplo ppe_inventory.php que es donde estoy trabajando ahora. .
        -->
        <!-- <nav class="nav-menu" id="navMenu">
        <?php echo $navList; ?>
        </nav> -->

        <!-- 
        He modificado este bloque para evitar el warning de "Undefined variable $navList"
        cuando se accede directamente a páginas que aún no pasan
        por el controlador principal (index.php).

        Esta solución usa 'isset()' para verificar si $navList está definido
        antes de intentar mostrarlo. Así el header no rompe y queda pendiente
        que el backend genere esta variable correctamente más adelante.
        -->
        <nav class="nav-menu" id="navMenu">
        <?php
            if (isset($navList)) {
            echo $navList;
            } else {
            // Esto evita el error y puede ser temporal
            echo '<ul class="navigation"><li><a href="/worksafe/index.php">Home</a></li></ul>';
            }
        ?>
        </nav>


        
        <div class="user-menu">
            <button class="user-btn" id="userBtn">
                <i class="fas fa-user"></i> User
            </button>
        </div>
    </header>

    <script>
     
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const navMenu = document.getElementById('navMenu');
            
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navMenu.classList.toggle('active');
            });
            
          
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });
            
         
            const currentAction = '<?php echo isset($_GET['action']) ? $_GET['action'] : 'home'; ?>';
            document.querySelectorAll('.nav-menu a').forEach(link => {
                const href = link.getAttribute('href');
                if (href.includes('action=' + currentAction) || (currentAction === 'home' && !href.includes('action='))) {
                    link.classList.add('active');
                }
            });
        });
    </script>
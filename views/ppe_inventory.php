<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php

// Check if the user is logged in
if (!isset($_SESSION['clientData'])) {
    echo "<p style='color: red;'>Access denied. You must be logged in.</p>";
    header("refresh:3;url=/worksafe/index.php"); // redirects after 3 seconds
    exit;
}

// Check if the user has level 1 access
if ($_SESSION['clientData']['clientLevel'] != 1) {
    echo "<p style='color: red;'>You do not have permission to access this page.</p>";
    header("refresh:3;url=/worksafe/index.php"); // redirects after 3 seconds
    exit;
}
?>



<!DOCTYPE html>
<html>
<head>
  <title>Safety Equipment Inventory</title>
  <link rel="stylesheet" href="css/hamburguesa.css">
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#000000">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/worksafe/css/inventory.css">
</head>
<body>
  <div class="header-content">
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>
  </div>

  <main class="ppe-inventory-container">

    <!-- Introduction -->
    <section class="form-section">
      <h2>Manage PPE Inventory</h2>
      <p>
        PPE stands for <strong>Personal Protective Equipment</strong>. These are safety items designed to protect workers from health and safety risks at work. 
        Common examples include helmets, gloves, safety goggles, boots, face shields, and masks.
      </p>
      <p>
        On this page, you can <strong>register new PPE items</strong> and <strong>manage your current inventory</strong>. Fill out the form below with the required details 
        such as code, name, category, size, and quantity. All items will appear in the table below, where you can also search, edit, or remove them.
      </p>
    </section>

    <!-- Form -->
    <section class="form-section">
      <form id="inventoryForm" class="join-form" method="post" action="index.php">
        <label for="code">Code:</label>
        <input type="text" id="code" name="code" required>
        <br>
        <label for="descripcion">Item Description:</label>
        <input type="text" id="description" name="description" required>
        <br>
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>
        <br>
        <label for="quantity">Physical Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>
        <br>
        <input type="submit" value="Save">
      </form>
    </section>

    <br><br>

    <!-- Filter -->
    <div> 
      <label for="filtroNombre" class="search-label"><strong>Filter by Name:</strong></label>
      <input type="text" id="filtroNombre" class="input-field search-input" placeholder="Type a letter or name...">
    </div>   

    <!-- Table -->
    <section class="form-section">
      <h2>Inventory Table</h2>
      <table border="1" class="data-table">
        <tr>
          <th>Code</th>
          <th>Item Description</th>
          <th>Stock</th>
          <th>Physical Quantity</th>
          <th>Actions</th>
        </tr>
        <?php foreach ($datos as $dato): ?>
          <tr>
            <td><?= $dato['code'] ?></td>
            <td><?= $dato['description'] ?></td>
            <td><?= $dato['stock'] ?></td>
            <td><?= $dato['quantity'] ?></td>
            <td>
              <form method="post" action="index.php?action=PPE Inventory">
                <input type="hidden" name="modificar_id" value="<?= $dato['id'] ?>">
                <input type="text" name="nuevoCodigo" value="<?= $dato['code'] ?>">
                <input type="text" name="nuevaDescripcion" value="<?= $dato['description'] ?>">
                <input type="number" name="nuevoStock" value="<?= $dato['stock'] ?>">
                <input type="number" name="nuevaCantidad" value="<?= $dato['quantity'] ?>">
                <button type="submit">Update</button>
              </form>
              <a href="index.php?eliminar=<?= $dato['id'] ?>">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </section>
  </main>

  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?><br><br>
  </footer>

  <script>
    document.getElementById("filtroNombre").addEventListener("keyup", function() {
      var filtro = this.value.toLowerCase();
      var filas = document.querySelectorAll("table tr:not(:first-child)");

      filas.forEach(function(fila) {
        var descripcion = fila.cells[1].textContent.toLowerCase();
        if (descripcion.startsWith(filtro)) {
          fila.style.display = "";
        } else {
          fila.style.display = "none";
        }
      });
    });

    function toggleDropdown(event) {
      event.preventDefault();
      const dropdown = event.currentTarget.closest('.dropdown');
      const menu = dropdown.querySelector('.dropdown-menu');
      const arrow = dropdown.querySelector('.dropdown-arrow');

      document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
        if (openMenu !== menu) {
          openMenu.classList.remove('show');
          openMenu.closest('.dropdown').querySelector('.dropdown-toggle').classList.remove('active');
        }
      });

      menu.classList.toggle('show');
      event.currentTarget.classList.toggle('active');
    }

    document.addEventListener('click', function(event) {
      if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
          menu.classList.remove('show');
          menu.closest('.dropdown').querySelector('.dropdown-toggle').classList.remove('active');
        });
      }
    });

    function toggleMenu() {
      const navLinks = document.getElementById('nav-links');
      navLinks.classList.toggle('active');
    }
  </script>
</body>
</html>

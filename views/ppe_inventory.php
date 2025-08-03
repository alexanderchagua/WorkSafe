<?php
$pageTitle = "PPE Inventory";
include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php";
?>

<main class="ppe-inventory-container">

  <!-- Introducción explicativa sobre el propósito de esta página -->
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

  <!-- Formulario de ingreso de nuevos ítems de PPE -->
  <section class="form-section">
    <form id="ppeForm" class="join-form">
      <label for="ppeCode">Code:</label>
      <input type="text" id="ppeCode" name="ppeCode" required>

      <label for="ppeName">Name:</label>
      <input type="text" id="ppeName" name="ppeName" required>

      <label for="ppeCategory">Category:</label>
      <input type="text" id="ppeCategory" name="ppeCategory">

      <label for="ppeSize">Size:</label>
      <input type="text" id="ppeSize" name="ppeSize">

      <label for="ppeQuantity">Quantity:</label>
      <input type="number" id="ppeQuantity" name="ppeQuantity" required>

      <button type="submit">Save Item</button>
    </form>
  </section>

  <!-- Campo de búsqueda -->
  <section class="form-section search-section">
    <label for="searchInput" class="search-label">🔍 Search PPE items:</label>
    <input
      type="text"
      id="searchInput"
      placeholder="Search by code or name..."
      class="input-field search-input"
    >
  </section>

  <!-- Tabla de inventario con estilo envolvente -->
  <section class="form-section">
    <h3 class="table-title">Current Inventory</h3>
    <div class="table-wrapper">
      <table id="ppeTable" class="data-table">
        <thead>
          <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Category</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Filas generadas por JS -->
        </tbody>
      </table>
    </div>
  </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
<script src="/worksafe/views/js/ppe_inventory.js"></script>

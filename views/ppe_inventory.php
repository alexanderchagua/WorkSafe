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


<?php
$pageTitle = "PPE Inventory";
include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php";
?>

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

  <section class="form-section">
    <form id="ppeForm" class="join-form" method="POST" action="/worksafe/inventory/index.php">
        <input type="hidden" name="action" value="add_item">
        
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

  <!-- Search field -->
  <section class="form-section search-section">
    <label for="searchInput" class="search-label">🔍 Search PPE items:</label>
    <input
      type="text"
      id="searchInput"
      placeholder="Search by code or name..."
      class="input-field search-input"
    >
  </section>

  <!-- Inventory table -->
  <section class="form-section">
    <h3 class="table-title">Current Inventory</h3>
    <div class="table-wrapper">
      <table id="ppeTable" class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Description</th>
            <th>Stock</th>
            <th>Quantity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Rows will be populated by JavaScript -->
        </tbody>
      </table>
    </div>
  </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const ppeForm = document.getElementById('ppeForm');
    const ppeTable = document.getElementById('ppeTable').getElementsByTagName('tbody')[0];
    const searchInput = document.getElementById('searchInput');
    
    // Load inventory items on page load
    loadInventoryItems();
    
    // Form submission for new item
    ppeForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(ppeForm);
        
        fetch('/worksafe/inventory/index.php?action=add_item', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Item added successfully');
                ppeForm.reset();
                loadInventoryItems();
            } else {
                alert('Error adding item');
            }
        })
        .catch(error => console.error('Error:', error));
    });
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        
        if (searchTerm.length > 2) {
            fetch(`/worksafe/inventory/index.php?action=search_items&term=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        populateTable(data.data);
                    }
                })
                .catch(error => console.error('Error:', error));
        } else if (searchTerm.length === 0) {
            loadInventoryItems();
        }
    });
    
    // Load all inventory items
    function loadInventoryItems() {
        fetch('/worksafe/inventory/index.php?action=get_items')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateTable(data.data);
                }
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Populate the table with data
    function populateTable(items) {
        ppeTable.innerHTML = '';
        
        items.forEach(item => {
            const row = ppeTable.insertRow();
            
            row.innerHTML = `
                <td>${item.id}</td>
                <td>${item.Codigo}</td>
                <td>${item.Descripcion}</td>
                <td>${item.Stock}</td>
                <td>${item.quantity}</td>
                <td>
                    <button class="edit-btn" data-id="${item.id}">Edit</button>
                    <button class="delete-btn" data-id="${item.id}">Delete</button>
                </td>
            `;
        });
        
        // Add event listeners to edit and delete buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                editItem(id);
            });
        });
        
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this item?')) {
                    deleteItem(id);
                }
            });
        });
    }
    
    // Edit item function
    function editItem(id) {
        // Find the item in the table
        const row = document.querySelector(`button.edit-btn[data-id="${id}"]`).closest('tr');
        const cells = row.cells;
        
        // Create a form for editing
        row.innerHTML = `
            <td>${id}</td>
            <td><input type="text" value="${cells[1].textContent}" class="edit-code"></td>
            <td><input type="text" value="${cells[2].textContent}" class="edit-desc"></td>
            <td><input type="number" value="${cells[3].textContent}" class="edit-stock"></td>
            <td><input type="number" value="${cells[4].textContent}" class="edit-quantity"></td>
            <td>
                <button class="save-btn" data-id="${id}">Save</button>
                <button class="cancel-btn" data-id="${id}">Cancel</button>
            </td>
        `;
        
        // Add event listeners to save and cancel buttons
        row.querySelector('.save-btn').addEventListener('click', function() {
            const updatedData = {
                id: id,
                code: row.querySelector('.edit-code').value,
                description: row.querySelector('.edit-desc').value,
                stock: row.querySelector('.edit-stock').value,
                quantity: row.querySelector('.edit-quantity').value
            };
            
            saveItem(updatedData);
        });
        
        row.querySelector('.cancel-btn').addEventListener('click', function() {
            loadInventoryItems();
        });
    }
    
    // Save edited item
    function saveItem(data) {
        const formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);
        }
        
        fetch('/worksafe/inventory/index.php?action=update_item', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Item updated successfully');
                loadInventoryItems();
            } else {
                alert('Error updating item');
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    // Delete item
    function deleteItem(id) {
        const formData = new FormData();
        formData.append('id', id);
        
        fetch('/worksafe/inventory/index.php?action=delete_item', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Item deleted successfully');
                loadInventoryItems();
            } else {
                alert('Error deleting item');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>
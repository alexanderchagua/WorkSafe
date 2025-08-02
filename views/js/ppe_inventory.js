// Clave para localStorage
const STORAGE_KEY = "ppeInventory";

// Inicializamos el inventario desde localStorage si existe
let inventory = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

// Guardar en localStorage
function saveToLocalStorage() {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(inventory));
}

// Función para capitalizar la primera letra de una palabra
function capitalize(text) {
  return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
}

// Renderizar tabla con inputs editables en todas las columnas
function renderTable(items = inventory) {
  const tableBody = document.querySelector("#ppeTable tbody");
  tableBody.innerHTML = "";

  items.forEach((item, index) => {
    const row = document.createElement("tr");

    // Generar una celda editable para cada campo
    ["code", "name", "category", "size", "quantity"].forEach((field) => {
      const cell = document.createElement("td");
      const input = document.createElement("input");

      input.type = field === "quantity" ? "number" : "text";
      input.value = item[field];
      input.min = field === "quantity" ? "0" : null;

      input.addEventListener("change", () => {
        let newValue = input.value.trim();

        // Capitalizar si no es campo numérico
        if (field !== "quantity") {
          newValue = capitalize(newValue);
        }

        inventory[index][field] = field === "quantity" ? parseInt(newValue, 10) : newValue;
        saveToLocalStorage();
        renderTable(); // para que se vea el cambio capitalizado al instante
      });

      cell.appendChild(input);
      row.appendChild(cell);
    });

    // Botón para eliminar
    const actionCell = document.createElement("td");
    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Delete";
    deleteBtn.addEventListener("click", () => {
      deleteItem(index);
    });
    actionCell.appendChild(deleteBtn);
    row.appendChild(actionCell);

    tableBody.appendChild(row);
  });
}

// Agregar un nuevo ítem al inventario desde el formulario
document.querySelector("#ppeForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const item = {
    code: capitalize(document.getElementById("ppeCode").value.trim()),
    name: capitalize(document.getElementById("ppeName").value.trim()),
    category: capitalize(document.getElementById("ppeCategory").value.trim()),
    size: capitalize(document.getElementById("ppeSize").value.trim()),
    quantity: parseInt(document.getElementById("ppeQuantity").value, 10)
  };

  inventory.push(item);
  saveToLocalStorage();
  renderTable();
  this.reset();
});

// Eliminar ítem
function deleteItem(index) {
  inventory.splice(index, 1);
  saveToLocalStorage();
  renderTable();
}

// Buscar por código o nombre
document.getElementById("searchInput").addEventListener("input", function () {
  const term = this.value.toLowerCase();
  const filtered = inventory.filter(item =>
    item.name.toLowerCase().includes(term) ||
    item.code.toLowerCase().includes(term)
  );
  renderTable(filtered);
});

// Mostrar datos al cargar
renderTable();

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

<!-- Agregar el CSS específico -->
<link rel="stylesheet" href="../css/search.css">

<div class="main-content">
    <!-- Formulario de búsqueda -->
    <form id="searchForm" method="GET" action="./search/index.php">
        <h2><i class="fas fa-search"></i> Personnel Search</h2>
        
        <div>
            <label for="nombre">Search by name:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Enter employee name...">
        </div>

        <div>
            <label for="area_trabajo">Search by work area:</label>
            <input type="text" id="area_trabajo" name="area_trabajo" placeholder="Enter work area...">
        </div>

        <input type="submit" value="🔍 Search Personnel">
    </form>

    <!-- Resultados -->
    <div id="personList" class="person-list">
        <?php
        // Array to map abbreviations to full names
        $nombres_completos = array(
            'Cs' => 'Safety Helmet',
            'Oc' => 'Helmet Earmuffs',
            'Ov' => 'Headband Earmuffs',
            'Gbd' => 'Badana Gloves',
            'Zp' => 'Safety Shoes',
            'Ga' => 'Cut-resistant Gloves',
            'Gc' => 'Leather Gloves',
            'Gac' => 'Acid-resistant Gloves',
            'Mp' => 'Cleaning Gloves',
            'Gs' => 'Welding Gloves',
            'Cas' => 'Welding Helmet',
            'Cms' => 'Welding Shirt',
            'Hs' => 'Welding Shoulder Pads',
            'Ms' => 'Welding Apron',
            'Bs' => 'Welding Boots',
            'Ls' => 'Safety Glasses',
            'Pf' => 'Face Shield',
            'Fc' => 'Lifting Belt',
            'Lg' => 'Goggles',
            'R3m' => '3M Respirator',
            'Vo' => 'Organic Vapor Filter',
            'Fp' => 'Particle Filter',
            'Ta' => 'Acid Suit',
            'Chc' => 'Cold Room Jacket',
            'Pc' => 'Cold Room Pants',
            'Mc' => 'Cold Room Socks',
            'Pm' => 'Balaclava',
            'Cam' => 'Cold Room Gloves',
            'Tc' => 'Cold Room Suit',
            'Bb' => 'White Boots',
            'U' => 'Production Uniform',
            'Ua' => 'Warehouse Uniform',
            'Ul' => 'Cleaning Uniform',
            'Zc' => 'Cold Room Shoes',
            'Um' => 'Maintenance Uniform',
            'Bp' => 'Steel Toe Boots',
            'Tv' => 'Tyvek Suit',
        );

        // Check if the form has been submitted and if there are results to display
        if (!empty($personas)) {
            echo '<div class="marco">';
            echo '<h2><i class="fas fa-users"></i> Search Results</h2>';
            echo '<ul id="personListUl">';
            foreach ($personas as $persona) {
                $persona['firmar'] = 'data:image/jpeg;base64,' . $persona['firmar'];
                $tiene_epp = false;
                foreach ($persona as $key => $value) {
                    if ((strpos($key, 'fecha_entrega_') !== false || strpos($key, 'cambio_') !== false) && $value !== '0000-00-00' && $value !== '0') {
                        $tiene_epp = true;
                        break;
                    }
                }
                if ($tiene_epp) {
                    echo '<li>';
                    echo '<div class="photo">';
                    echo '<img src="' . $persona['foto'] . '" alt="' . $persona['name'] . '">';
                    echo '</div>';
                    
                    echo '<span>';
                    echo '<strong>📋 Personal Information</strong><br><br>';
                    echo '<strong>Status:</strong> <span class="' . ($persona['estado'] === 'activo' ? 'estado-activo' : 'estado-retirado') . '">' . ucfirst($persona['estado']) . '</span><br>';
                    echo '<strong>Name:</strong> ' . $persona['name'] . '<br>';
                    echo '<strong>Age:</strong> ' . $persona['edad'] . ' years<br>';
                    echo '<strong>Occupation:</strong> ' . $persona['ocupacion'] . '<br>';
                    echo '<strong>Area:</strong> ' . $persona['area_trabajo'] . '<br>';
                    echo '<strong>Location:</strong> ' . $persona['sede'] . '<br>';
                    echo '<strong>Date of Entry:</strong> ' . date('M d, Y', strtotime($persona['fecha_ingreso'])) . '<br>';
                    echo '<strong>Birthday:</strong> ' . date('M d, Y', strtotime($persona['fecha_cumple'])) . '<br>';
                    echo '</span>';
                    
                    echo '<span>';
                    echo '<h2><i class="fas fa-hard-hat"></i> Safety Equipment</h2>';
                    echo '<strong>PPE Status:</strong> <span class="' . ($persona['estado_epp'] === 'devuelto' ? 'estado_epp_devuelto' : ($persona['estado_epp'] === 'activo' ? 'estado_epp_activos' : '')) . '">' . ucfirst($persona['estado_epp']) . '</span><br><br>';
                    echo '<strong>Observations:</strong> ' . ($persona['observaciones'] ?: 'No observations') . '<br><br>';

                    $mostrado = [];
                    $epp_count = 0;

                    foreach ($persona as $key => $value) {
                        if ((strpos($key, 'fecha_entrega_') !== false || strpos($key, 'cambio_') !== false) && $value !== '0000-00-00' && $value !== '0' && !empty($value)) {
                            $epp_nombre = ucwords(str_replace('', ' ', str_replace(['fecha_entrega_', 'cambio_'], '', $key)));
                            if (array_key_exists($epp_nombre, $nombres_completos)) {
                                $epp_nombre_completo = $nombres_completos[$epp_nombre];
                                if (!in_array($epp_nombre_completo, $mostrado)) {
                                    $epp_count++;
                                    echo '<div class="epp-item">';
                                    echo '<strong>🔧 ' . $epp_nombre_completo . ':</strong><br>';
                                    echo '<em>Delivery:</em> ' . date('M d, Y', strtotime($value)) . '<br>';
                                    $cambio_key = str_replace('fecha_entrega_', 'cambio_', $key);
                                    if (!empty($persona[$cambio_key]) && $persona[$cambio_key] !== '0000-00-00') {
                                        echo '<em>Replacement:</em> ' . date('M d, Y', strtotime($persona[$cambio_key])) . '<br>';
                                    }
                                    echo '</div><br>';
                                    $mostrado[] = $epp_nombre_completo;
                                }
                            }
                        }
                    }
                    
                    if ($epp_count == 0) {
                        echo '<em>No PPE equipment registered</em><br>';
                    }
                    
                    echo '</span>';
                    
                    // Sección de firmas e imágenes (ocupará toda la fila)
                    echo '<div style="grid-column: 1 / -1; margin-top: 2rem;">';
                    echo '<h2><i class="fas fa-signature"></i> Documentation</h2>';
                    echo '<div style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center; align-items: center;">';
                    
                    // Firma
                    if (!empty($persona['firmar'])) {
                        echo '<div style="text-align: center;">';
                        echo '<h4>Digital Signature</h4>';
                        echo '<img class="firma" src="' . htmlspecialchars($persona['firmar']) . '" alt="Signature" />';
                        if (!empty($persona['fecha'])) {
                            echo '<p><small>Date: ' . date('M d, Y', strtotime($persona['fecha'])) . '</small></p>';
                        }
                        echo '</div>';
                    }
                    
                    // Foto de evidencia
                    if (!empty($persona['foto_captura'])) {
                        echo '<div style="text-align: center;">';
                        echo '<h4>Evidence Photo</h4>';
                        echo '<img src="data:image/png;base64,' . htmlspecialchars($persona['foto_captura']) . '" alt="Evidence Photo" style="max-width: 250px; height: auto;">';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                    echo '</div>';
                    
                    echo '</li>';
                }
            }
            echo '</ul>';
            echo '</div>';
            
            // Botón de modificar
            if ($_SESSION['clientData']['clientLevel'] == 3 || $_SESSION['clientData']['clientLevel'] == 4) {
                echo '<div style="text-align: center; margin-top: 2rem;">';
                echo '<a href="../views/mpersonal.php?id=' . $persona['id'] . '" class="btn-modificar">';
                echo '<i class="fas fa-edit"></i> Modify Personnel Data</a>';
                echo '</div>';
            }
        } else {
            echo '<div class="no-results">';
            echo '<p><i class="fas fa-search-minus"></i><br>No results found for your search criteria.<br><small>Try adjusting your search terms.</small></p>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>

<style>
/* Estilos adicionales para elementos específicos */
.epp-item {
    background: rgba(52, 152, 219, 0.1);
    padding: 0.8rem;
    border-radius: 8px;
    border-left: 4px solid var(--accent-color);
    margin: 0.5rem 0;
}

.no-results {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.no-results p {
    font-size: 1.2rem;
    color: var(--text-dark);
    line-height: 1.8;
}

.no-results i {
    font-size: 3rem;
    color: var(--warning-color);
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .epp-item {
        padding: 0.6rem;
        margin: 0.3rem 0;
    }
    
    .no-results {
        padding: 2rem 1rem;
    }
    
    .no-results i {
        font-size: 2rem;
    }
    
    .no-results p {
        font-size: 1rem;
    }
}

/* Mejoras adicionales para la visualización */
#personListUl li > span:first-of-type strong,
#personListUl li > span:nth-of-type(2) strong {
    color: var(--primary-color);
}

#personListUl li > span:first-of-type em,
#personListUl li > span:nth-of-type(2) em {
    color: var(--accent-color);
    font-style: normal;
    font-weight: 500;
}

/* Separador visual entre secciones */
#personListUl li > span + span {
    border-top: 1px solid var(--border-color);
    padding-top: 1.5rem;
    margin-top: 1.5rem;
}

/* Efecto hover para items de EPP */
.epp-item:hover {
    background: rgba(52, 152, 219, 0.15);
    transform: translateX(5px);
    transition: all 0.3s ease;
}
</style>

<script>
// Script para mejorar la experiencia de usuario
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus en el primer campo de búsqueda
    const nombreInput = document.getElementById('nombre');
    if (nombreInput) {
        nombreInput.focus();
    }
    
    // Contador de resultados
    const resultsList = document.getElementById('personListUl');
    if (resultsList) {
        const resultCount = resultsList.children.length;
        const marco = document.querySelector('.marco h2');
        if (marco && resultCount > 0) {
            marco.innerHTML += ` <small style="color: var(--active-color); font-weight: normal;">(${resultCount} result${resultCount !== 1 ? 's' : ''})</small>`;
        }
    }
    
    // Animación de carga para las imágenes
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '0';
            this.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                this.style.opacity = '1';
            }, 100);
        });
    });
    
    // Tooltip para estados
    const estados = document.querySelectorAll('.estado-activo, .estado-retirado, .estado_epp_activos, .estado_epp_devuelto');
    estados.forEach(estado => {
        let tooltipText = '';
        if (estado.classList.contains('estado-activo')) {
            tooltipText = 'Employee is currently active';
        } else if (estado.classList.contains('estado-retirado')) {
            tooltipText = 'Employee has retired';
        } else if (estado.classList.contains('estado_epp_activos')) {
            tooltipText = 'PPE equipment is active';
        } else if (estado.classList.contains('estado_epp_devuelto')) {
            tooltipText = 'PPE equipment has been returned';
        }
        
        if (tooltipText) {
            estado.title = tooltipText;
            estado.style.cursor = 'help';
        }
    });
    
    // Búsqueda en tiempo real (opcional)
    const searchInputs = document.querySelectorAll('#nombre, #area_trabajo');
    let searchTimeout;
    
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Aquí podrías implementar búsqueda AJAX si lo deseas
                console.log('Searching for:', this.value);
            }, 500);
        });
    });
    
    // Validación del formulario
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const area = document.getElementById('area_trabajo').value.trim();
            
            if (!nombre && !area) {
                e.preventDefault();
                alert('Please enter at least one search criteria (Name or Work Area)');
                return false;
            }
        });
    }
    
    // Expandir/contraer información adicional
    const personItems = document.querySelectorAll('#personListUl li');
    personItems.forEach((item, index) => {
        // Agregar un botón de expansión para detalles adicionales si es necesario
        const additionalInfo = item.querySelector('.epp-item');
        if (additionalInfo) {
            item.style.cursor = 'pointer';
            item.addEventListener('click', function(e) {
                // Solo si no se hace clic en enlaces o botones
                if (!e.target.closest('a, button, img')) {
                    item.classList.toggle('expanded');
                }
            });
        }
    });
});

// Función para imprimir los resultados
function printResults() {
    const printWindow = window.open('', '_blank');
    const personList = document.getElementById('personList').innerHTML;
    
    printWindow.document.write(`
        <html>
        <head>
            <title>WorkSafe - Personnel Search Results</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .marco { margin-bottom: 20px; }
                .marco h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
                #personListUl { list-style: none; padding: 0; }
                #personListUl li { border: 1px solid #ddd; margin: 20px 0; padding: 20px; page-break-inside: avoid; }
                .photo img { width: 100px; height: 100px; border-radius: 50%; }
                .estado-activo, .estado-retirado, .estado_epp_activos, .estado_epp_devuelto { 
                    padding: 2px 8px; border-radius: 4px; font-weight: bold; 
                }
                .estado-activo, .estado_epp_activos { background: #27ae60; color: white; }
                .estado-retirado { background: #e74c3c; color: white; }
                .estado_epp_devuelto { background: #f39c12; color: white; }
                @media print { 
                    body { margin: 0; } 
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <h1>WorkSafe - Personnel Search Results</h1>
            <p>Generated on: ${new Date().toLocaleString()}</p>
            ${personList}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.print();
}

// Función para exportar a CSV (básico)
function exportToCSV() {
    const rows = [];
    const headers = ['Name', 'Age', 'Occupation', 'Area', 'Location', 'Status', 'PPE Status'];
    rows.push(headers.join(','));
    
    const personItems = document.querySelectorAll('#personListUl li');
    personItems.forEach(item => {
        const name = item.querySelector('span').textContent.match(/Name: ([^\n]+)/)?.[1] || '';
        const age = item.querySelector('span').textContent.match(/Age: ([^\n]+)/)?.[1] || '';
        const occupation = item.querySelector('span').textContent.match(/Occupation: ([^\n]+)/)?.[1] || '';
        const area = item.querySelector('span').textContent.match(/Area: ([^\n]+)/)?.[1] || '';
        const location = item.querySelector('span').textContent.match(/Location: ([^\n]+)/)?.[1] || '';
        const status = item.querySelector('.estado-activo, .estado-retirado')?.textContent || '';
        const ppeStatus = item.querySelector('.estado_epp_activos, .estado_epp_devuelto')?.textContent || '';
        
        const row = [name, age, occupation, area, location, status, ppeStatus].map(field => 
            `"${field.replace(/"/g, '""')}"`
        );
        rows.push(row.join(','));
    });
    
    const csvContent = rows.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `worksafe_personnel_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>
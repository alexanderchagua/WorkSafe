<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['clientData'])) {
    echo "<p style='color: red;'>Access denied. You must be logged in.</p>";
    header("refresh:3;url=/worksafe/index.php");
    exit;
}

// Check if the user has level 1 access
if ($_SESSION['clientData']['clientLevel'] != 1) {
    echo "<p style='color: red;'>You do not have permission to access this page.</p>";
    header("refresh:3;url=/worksafe/index.php");
    exit;
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

<!-- Include specific CSS -->
<link rel="stylesheet" href="./css/search.css">

<div class="main-content">
    <!-- Search Form -->
    <form id="searchForm" method="GET" action="./search/index.php">
        <h2><i class="fas fa-search"></i> Personnel Search</h2>
        
        <div class="marco">
            <label for="nombre">Search by name:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Enter employee name..." 
                   value="<?php echo isset($search_params['nombre']) ? htmlspecialchars($search_params['nombre']) : ''; ?>">
        </div>

        <div class="marco">
            <label for="area_trabajo">Search by work area:</label>
            <input type="text" id="area_trabajo" name="area_trabajo" placeholder="Enter work area..." 
                   value="<?php echo isset($search_params['area_trabajo']) ? htmlspecialchars($search_params['area_trabajo']) : ''; ?>">
        </div>

        <input type="submit" value="🔍 Search Personnel">
    </form>

    <!-- Search Results -->
    <div id="personList" class="person-list">
        <?php
        // Array to map abbreviations to full PPE names
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

        // Check if form is submitted and results exist
        if (!empty($personas)) {
            echo '<div class="marco">';
            echo '<h2><i class="fas fa-users"></i> Search Results (' . count($personas) . ' found)</h2>';
            echo '<ul id="personListUl">';
            foreach ($personas as $persona) {
                $persona['firmar'] = 'data:image/jpeg;base64,' . $persona['firmar'];
                $has_ppe = false;
                foreach ($persona as $key => $value) {
                    if ((strpos($key, 'fecha_entrega_') !== false || strpos($key, 'cambio_') !== false) && $value !== '0000-00-00' && $value !== '0') {
                        $has_ppe = true;
                        break;
                    }
                }
                if ($has_ppe) {
                    echo '<li>';
                    echo '<div class="photo">';
                    // Handle different image path formats
                    $foto_path = $persona['foto'];
                    
                    // Debug: Show the original path (remove this line once fixed)
                    // echo "<!-- Debug: Original path: " . htmlspecialchars($foto_path) . " -->";
                    
                    // If it's a base64 image
                    if (strpos($foto_path, 'data:image') === 0) {
                        echo '<img src="' . htmlspecialchars($foto_path) . '" alt="' . htmlspecialchars($persona['name']) . '" style="max-width: 150px; height: auto;">';
                    }
                    // If it's a regular file path
                    elseif (!empty($foto_path)) {
                        // Try different path combinations
                        $possible_paths = [
                            $foto_path,  // Original path
                            '/worksafe/' . ltrim($foto_path, '/'), // Add worksafe prefix
                            '/worksafe/uploads/' . basename($foto_path), // Assume uploads folder
                            '/worksafe/images/' . basename($foto_path), // Assume images folder
                            './uploads/' . basename($foto_path), // Relative uploads
                            './images/' . basename($foto_path), // Relative images
                        ];
                        
                        $image_found = false;
                        foreach ($possible_paths as $test_path) {
                            // Check if file exists (for server-side files)
                            $server_path = $_SERVER['DOCUMENT_ROOT'] . $test_path;
                            if (file_exists($server_path)) {
                                echo '<img src="' . htmlspecialchars($test_path) . '" alt="' . htmlspecialchars($persona['name']) . '" style="max-width: 150px; height: auto;">';
                                $image_found = true;
                                break;
                            }
                        }
                        
                        // If no file found, try original path anyway (might be external URL)
                        if (!$image_found) {
                            echo '<img src="' . htmlspecialchars($foto_path) . '" alt="' . htmlspecialchars($persona['name']) . '" style="max-width: 150px; height: auto;" onerror="this.src=\'/worksafe/images/default-avatar.png\'; this.style.backgroundColor=\'#f0f0f0\'; this.style.border=\'1px solid #ddd\';">';
                        }
                    }
                    // Default placeholder if no image
                    else {
                        echo '<div style="width: 150px; height: 150px; background-color: #f0f0f0; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; color: #666;">';
                        echo '<i class="fas fa-user" style="font-size: 3em;"></i>';
                        echo '</div>';
                    }
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

                    $displayed = [];
                    $epp_count = 0;

                    foreach ($persona as $key => $value) {
                        if ((strpos($key, 'fecha_entrega_') !== false || strpos($key, 'cambio_') !== false) && $value !== '0000-00-00' && $value !== '0' && !empty($value)) {
                            $epp_name = ucwords(str_replace('', ' ', str_replace(['fecha_entrega_', 'cambio_'], '', $key)));
                            if (array_key_exists($epp_name, $nombres_completos)) {
                                $full_epp_name = $nombres_completos[$epp_name];
                                if (!in_array($full_epp_name, $displayed)) {
                                    $epp_count++;
                                    echo '<div class="epp-item">';
                                    echo '<strong>🔧 ' . $full_epp_name . ':</strong><br>';
                                    echo '<em>Delivery:</em> ' . date('M d, Y', strtotime($value)) . '<br>';
                                    $cambio_key = str_replace('fecha_entrega_', 'cambio_', $key);
                                    if (!empty($persona[$cambio_key]) && $persona[$cambio_key] !== '0000-00-00') {
                                        echo '<em>Replacement:</em> ' . date('M d, Y', strtotime($persona[$cambio_key])) . '<br>';
                                    }
                                    echo '</div><br>';
                                    $displayed[] = $full_epp_name;
                                }
                            }
                        }
                    }
                    
                    if ($epp_count == 0) {
                        echo '<em>No PPE equipment registered</em><br>';
                    }
                    
                    echo '</span>';
                    
                    // Signatures and images section (full width)
                    echo '<div style="grid-column: 1 / -1; margin-top: 2rem;">';
                    echo '<h2><i class="fas fa-signature"></i> Documentation</h2>';
                    echo '<div style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center; align-items: center;">';
                    
                    // Digital signature
                    if (!empty($persona['firmar'])) {
                        echo '<div style="text-align: center;">';
                        echo '<h4>Digital Signature</h4>';
                        echo '<img class="firma" src="' . htmlspecialchars($persona['firmar']) . '" alt="Signature" />';
                        if (!empty($persona['fecha'])) {
                            echo '<p><small>Date: ' . date('M d, Y', strtotime($persona['fecha'])) . '</small></p>';
                        }
                        echo '</div>';
                    }
                    
                    // Evidence photo
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
        } elseif (isset($_SESSION['search_attempted'])) {
            echo '<div class="marco">';
            echo '<h2><i class="fas fa-exclamation-circle"></i> No Results Found</h2>';
            echo '<p>No personnel found matching your search criteria.</p>';
            echo '</div>';
            unset($_SESSION['search_attempted']);
        }
        ?>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
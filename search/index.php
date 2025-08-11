<?php
// Use absolute paths to avoid conflicts
require_once $_SERVER['DOCUMENT_ROOT'] . '/worksafe/library/connections.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/worksafe/models/search_model.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$personas = [];

// Check if the form has been submitted
if (isset($_GET['nombre']) || isset($_GET['area_trabajo'])) {
    // Get the name and work area
    $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
    $area_trabajo = isset($_GET['area_trabajo']) ? $_GET['area_trabajo'] : '';
    
    // Call the function to get data by name
    $personas = obtenerDatosPorNombre($nombre, $area_trabajo);
    
    // Store results in session to pass them
    $_SESSION['search_results'] = $personas;
    $_SESSION['search_params'] = [
        'nombre' => $nombre,
        'area_trabajo' => $area_trabajo
    ];
    $_SESSION['search_attempted'] = true;
    
    // Redirect to main index with Search action
    header('Location: /worksafe/index.php?action=Search');
    exit;
} else {
    // If no search parameters, redirect to search page
    header('Location: /worksafe/index.php?action=Search');
    exit;
}
?>
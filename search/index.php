<?php

// Include the file with the function to fetch data
require_once '../library/connections.php'; // Make sure the filename is correct
require_once '../models/personal_mode.php';
require_once '../models/search_model.php';

require_once '../library/nav.php';
require_once '../models/main-model.php';
// Get the array of classifications

$navs = getNavs();

$personas = [];

// Check if the form has been submitted
if (isset($_GET['nombre']) || isset($_GET['area_trabajo'])) {
    // Get the name and work area
    $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';  // If not set, assign an empty string
    $area_trabajo = isset($_GET['area_trabajo']) ? $_GET['area_trabajo'] : '';  // If not set, assign an empty string

    // Call the function to get data by name
    $personas = obtenerDatosPorNombre($nombre, $area_trabajo);
}

// Debug
// var_dump($area_trabajo);

// Check if there are results to display
if (!empty($personas)) {
    // Include the search page if results were found
    include '../views/search.php';
    exit; // Stop script execution after including the page
}

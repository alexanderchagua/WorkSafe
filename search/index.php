<?php


// Incluir el archivo con la función para obtener datos
require_once './library/conections.php'; // Asegúrate de que esté corregido el nombre del archivo
require_once './models/personal_mode.php';
require_once './models/search_model.php'; 
require_once './models/modification.php';
require_once './library/nav.php';
require_once './models/main-model.php';
// Get the array of classifications



$navs = getNavs();




$personas = [];

// Verificar si se ha enviado el formulario
if (isset($_GET['nombre']) || isset($_GET['area_trabajo'])) {
    // Obtener el nombre y el área de trabajo
    $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';  // Si no existe, asigna una cadena vacía
    $area_trabajo = isset($_GET['area_trabajo']) ? $_GET['area_trabajo'] : '';  // Si no existe, asigna una cadena vacía

    // Llamar a la función para obtener los datos por nombre
    $personas = obtenerDatosPorNombre($nombre, $area_trabajo);
}

// Depuración
//var_dump($area_trabajo);


// Verificar si hay resultados para mostrar
if (!empty($personas)) {
    // Incluir la página de búsqueda si se encontraron resultados
    include './views/busqueda.php';
    exit; // Terminar la ejecución del script después de incluir la página
}
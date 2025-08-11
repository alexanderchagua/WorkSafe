<?php
// Use absolute path or check if connections is already included
if (!function_exists('dataPrueba')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/worksafe/library/connections.php';
}

function obtenerDatosPorNombre($name, $area_trabajo) {
    // Connect to the database
    $pdo = dataPrueba();
    
    // SQL query to get data by name and work area
    $stmt = $pdo->prepare("SELECT * FROM personal_epp WHERE name LIKE :name AND area_trabajo LIKE :area_trabajo");
    $stmt->execute([
        'name' => "%$name%",
        'area_trabajo' => "%$area_trabajo%"
    ]);
    
    // Fetch and return the results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
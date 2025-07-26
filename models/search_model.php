

<?php

require_once './library/conections.php'; 

function obtenerDatosPorNombre($name, $area_trabajo) {
    // Conexion a la base de datos
    $pdo = dataPrueba();
    
    // Consulta SQL para obtener los datos por nombre
    $stmt = $pdo->prepare("SELECT * FROM personal_epp WHERE name LIKE :name AND area_trabajo LIKE :area_trabajo");
    $stmt->execute([
        'name' => "%$name%",
        'area_trabajo' => "%$area_trabajo%"
    ]);
    
    // Obtener y devolver los resultados
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
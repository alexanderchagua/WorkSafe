<?php
// personal_epp/index.php - CONTROLADOR ACTUALIZADO
session_start();
require_once '../library/conections.php';
require_once '../models/personal_mode.php';
require_once '../library/nav.php';
require_once '../models/main-model.php';

// Obtener los datos de navegación
$navs = getNavs();

// Obtener los campos EPP dinámicamente
$epp_fields = getEppFields();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos personales
    $datos_personales = [
        'name' => trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)),
        'edad' => intval(trim(filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT))),
        'ocupacion' => trim(filter_input(INPUT_POST, 'ocupacion', FILTER_SANITIZE_STRING)),
        'area_trabajo' => trim(filter_input(INPUT_POST, 'area_trabajo', FILTER_SANITIZE_STRING)),
        'fecha_cumple' => $_POST['fecha_cumple'],
        'fecha_ingreso' => $_POST['fecha_ingreso'],
        'estado' => $_POST['estado'],
        'estado_epp' => $_POST['estado_epp'],
        'observaciones' => trim(filter_input(INPUT_POST, 'observaciones', FILTER_SANITIZE_STRING)),
        'sede' => $_POST['sede']
    ];
    
    // Procesar imagen
    $foto = $_FILES['foto'];
    $uploadDirectory = "../uploads/";
    
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }
    
    $fotoNombre = uniqid() . '_' . basename($foto['name']);
    $targetFilePath = $uploadDirectory . $fotoNombre;
    
    // Procesar datos EPP dinámicamente
    $datos_epp = [];
    
    foreach($epp_fields as $epp_key => $epp_info) {
        // Campo principal (checkbox)
        if(isset($epp_info['campo'])) {
            $campo_principal = $epp_info['campo'];
            $datos_epp[$campo_principal] = isset($_POST[$campo_principal]) ? 1 : 0;
        }
        
        // Fecha de entrega
        if(isset($epp_info['fecha_entrega'])) {
            $campo_fecha = $epp_info['fecha_entrega'];
            $datos_epp[$campo_fecha] = !empty($_POST[$campo_fecha]) ? $_POST[$campo_fecha] : null;
        }
        
        // Fecha de cambio
        if(isset($epp_info['cambio'])) {
            $campo_cambio = $epp_info['cambio'];
            $datos_epp[$campo_cambio] = !empty($_POST[$campo_cambio]) ? $_POST[$campo_cambio] : null;
        }
    }
    
    // Firma
    $firmar = !empty($_POST['firmar']) ? $_POST['firmar'] : null;
    
    // Intentar mover el archivo
    if (move_uploaded_file($foto['tmp_name'], $targetFilePath)) {
        $datos_personales['foto'] = $targetFilePath;
        
        // Guardar los datos en la base de datos
        if (guardarDatosDinamico($datos_personales, $datos_epp, $firmar)) {
            // Éxito al guardar los datos
            $success_message = "Personal registrado exitosamente";
            include './views/personal_dinamico.php';
            exit();
        } else {
            $message = "Error al guardar los datos. Por favor, inténtalo de nuevo.";
        }
    } else {
        $message = "Error al cargar la imagen. Por favor, inténtalo de nuevo.";
    }
} else {
    // Mostrar formulario
    include '../views/personal_dinamico.php';
}

?>
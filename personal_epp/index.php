<?php
// personal_epp/index.php - UPDATED CONTROLLER
session_start();
require_once '../library/connections.php';
require_once '../models/personal_mode.php';
require_once '../library/nav.php';
require_once '../models/main-model.php';

// Get navigation data
$navs = getNavs();

// Get EPP fields dynamically
$epp_fields = getEppFields();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Personal data
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
    
    // Process photo
    $foto = $_FILES['foto'];
    $uploadDirectory = "../uploads/";
    
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }
    
    $fotoNombre = uniqid() . '_' . basename($foto['name']);
    $targetFilePath = $uploadDirectory . $fotoNombre;
    
    // Process EPP data dynamically
    $datos_epp = [];
    
    foreach($epp_fields as $epp_key => $epp_info) {
        // Main field (checkbox)
        if(isset($epp_info['campo'])) {
            $campo_principal = $epp_info['campo'];
            $datos_epp[$campo_principal] = isset($_POST[$campo_principal]) ? 1 : 0;
        }
        
        // Delivery date
        if(isset($epp_info['fecha_entrega'])) {
            $campo_fecha = $epp_info['fecha_entrega'];
            $datos_epp[$campo_fecha] = !empty($_POST[$campo_fecha]) ? $_POST[$campo_fecha] : null;
        }
        
        // Replacement date
        if(isset($epp_info['cambio'])) {
            $campo_cambio = $epp_info['cambio'];
            $datos_epp[$campo_cambio] = !empty($_POST[$campo_cambio]) ? $_POST[$campo_cambio] : null;
        }
    }
    
    // Signature
    $firmar = !empty($_POST['firmar']) ? $_POST['firmar'] : null;
    $firmar = str_replace('data:image/jpeg;base64,', '', $firmar);

    // Try to move the uploaded file
    if (move_uploaded_file($foto['tmp_name'], $targetFilePath)) {
        $datos_personales['foto'] = $targetFilePath;
        
        // Save data to database
        if (guardarDatosDinamico($datos_personales, $datos_epp, $firmar)) {
            // Data saved successfully
            $success_message = "Personnel successfully registered";
            include '../views/addPerson.php';
            exit();
        } else {
            $message = "Error saving data. Please try again.";
        }
    } else {
        $message = "Error uploading image. Please try again.";
    }
} else {
    // Show form
}
?>

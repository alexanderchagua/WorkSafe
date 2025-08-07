<?php
// controllers/SsomaController.php
require_once './models/model_stadistic.php';
require_once './library/connections.php';
require_once './models/main-model.php';



function mostrarDashboard() {
    $mesActual = isset($_GET['mes']) ? $_GET['mes'] : 'enero';
    $datos = obtenerDatosPorMes($mesActual);
    $resumenAnual = obtenerResumenAnual();
    
    $datosGraficas = prepararDatosGraficas($datos, $resumenAnual);
    
    require_once './common/statistics.php';
}

function obtenerDatosAjax() {
    header('Content-Type: application/json');
    
    if (!isset($_POST['mes'])) {
        echo json_encode(['error' => 'Mes no especificado']);
        return;
    }
    
    $mes = $_POST['mes'];
    $datos = obtenerDatosPorMes($mes);
    
    if ($datos === null) {
        echo json_encode(['error' => 'Error al obtener datos']);
        return;
    }
    
    $respuesta = [
        'success' => true,
        'datos' => $datos,
        'graficas' => [
            'incidentes' => [
                'labels' => ['Incidents', 'Days without accidents'],
                'data' => [(int)$datos['incidentes'], (int)$datos['dias_sin_accidentes']],
                'backgroundColor' => ['#ff6384', '#36a2eb']
            ],
            'trabajadores' => [
                'labels' => ['Administrative', 'Operational'],
                'data' => [(int)$datos['trabajadores_admin'], (int)$datos['trabajadores_oper']],
                'backgroundColor' => ['#4bc0c0', '#ff9f40']
            ],
            'indices' => [
                'labels' => ['Frequency Index', 'Severity Index'],
                'data' => [(float)$datos['indice_frecuencia'], (float)$datos['indice_gravedad']],
                'backgroundColor' => ['#9966ff', '#ff6384']
            ],
            'riesgo' => [
                'labels' => ['Trained', 'Untrained'],
                'data' => [
                    (int)$datos['capacitados'], 
                    max(0, (int)$datos['trabajadores_total'] - (int)$datos['capacitados'])
                ],
                'backgroundColor' => ['#4bc0c0', '#ff6384']
            ]
        ]
    ];
    
    echo json_encode($respuesta);
}

function prepararDatosGraficas($datos, $resumenAnual) {
    return [
        'incidentes' => [
            'labels' => ['Incidents', 'Days without accidents'],
            'data' => [(int)$datos['incidentes'], (int)$datos['dias_sin_accidentes']],
            'backgroundColor' => ['#ff6384', '#36a2eb']
        ],
        'trabajadores' => [
            'labels' => ['Administrative', 'Operational'],
            'data' => [(int)$datos['trabajadores_admin'], (int)$datos['trabajadores_oper']],
            'backgroundColor' => ['#4bc0c0', '#ff9f40']
        ],
        'indices' => [
            'labels' => ['Frequency Index', 'Severity Index'],
            'data' => [(float)$datos['indice_frecuencia'], (float)$datos['indice_gravedad']],
            'backgroundColor' => ['#9966ff', '#ff6384']
        ],
        'riesgo' => [
            'labels' => ['Trained', 'Untrained'],
            'data' => [
                (int)$datos['capacitados'], 
                max(0, (int)$datos['trabajadores_total'] - (int)$datos['capacitados'])
            ],
            'backgroundColor' => ['#4bc0c0', '#ff6384']
        ],
        'resumen_anual' => $resumenAnual
    ];
}

// Manejar las solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'obtener_datos') {
    obtenerDatosAjax();
} else {
    mostrarDashboard();
}
?>
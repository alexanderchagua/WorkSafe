<?php


// Include required files: models, database connection, navigation utilities
require_once './models/model_stadistic.php';
require_once './library/connections.php';
require_once './models/main-model.php';
require_once './library/nav.php';

// Generate navigation menu
$navs = getNavs(); // Get navigation items from database
$navList = buildNavList($navs); // Build HTML navigation list

/**
 * Display the dashboard page
 *
 * - Gets current month from GET parameters (defaults to "enero" if not set)
 * - Retrieves monthly and yearly summary data
 * - Prepares chart data
 * - Loads the statistics view
 */
function mostrarDashboard() {
    global $navList, $navs;

    // Get current month from URL parameter or set default
    $mesActual = isset($_GET['mes']) ? $_GET['mes'] : 'enero';

    // Get data for the selected month
    $datos = obtenerDatosPorMes($mesActual);

    // Get annual summary data
    $resumenAnual = obtenerResumenAnual();

    // Prepare chart data based on the retrieved data
    $datosGraficas = prepararDatosGraficas($datos, $resumenAnual);

    // Load statistics view
    require_once './common/statistics.php';
}

/**
 * Handle AJAX request to get data by month
 *
 * - Expects a POST request with a 'mes' parameter
 * - Returns JSON with data and chart configuration
 */
function obtenerDatosAjax() {
    header('Content-Type: application/json');

    // Check if 'mes' parameter is present
    if (!isset($_POST['mes'])) {
        echo json_encode(['error' => 'Month not specified']);
        return;
    }

    $mes = $_POST['mes'];

    // Retrieve data for the given month
    $datos = obtenerDatosPorMes($mes);

    // Check if data retrieval was successful
    if ($datos === null) {
        echo json_encode(['error' => 'Error retrieving data']);
        return;
    }

    // Prepare the JSON response with chart data
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

    // Send the JSON response
    echo json_encode($respuesta);
}

/**
 * Prepare chart data for statistics
 *
 * @param array $datos         Monthly data
 * @param array $resumenAnual  Yearly summary data
 * @return array               Chart configuration arrays
 */
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

// Handle incoming requests:
// If POST request with 'accion' = 'obtener_datos', return JSON via obtenerDatosAjax()
// Otherwise, show the dashboard
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'obtener_datos') {
    obtenerDatosAjax();
} else {
    mostrarDashboard();
}
?>

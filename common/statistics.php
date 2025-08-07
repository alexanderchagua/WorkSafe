
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php

// Check if the user is logged in
if (!isset($_SESSION['clientData'])) {
    echo "<p style='color: red;'>Access denied. You must be logged in.</p>";
    header("refresh:3;url=/worksafe/index.php"); // redirects after 3 seconds
    exit;
}

// Check if the user has level 1 access
if ($_SESSION['clientData']['clientLevel'] != 1) {
    echo "<p style='color: red;'>You do not have permission to access this page.</p>";
    header("refresh:3;url=/worksafe/index.php"); // redirects after 3 seconds
    exit;
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SSOMA</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
            border-radius: 0.5rem;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #1d7bdaff;
            font-weight: 600;
        }
        .btn-mes {
            margin: 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-mes.active {
            background-color: #0d6efd;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin: 1rem 0;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
    </style>
</head>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>
<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <i class="fas fa-chart-line me-2"></i>
                SSOMA Dashboard
            </span>
            <span class="navbar-text">
                <i class="fas fa-calendar-alt me-1"></i>
                Year <?php echo $datos['anio']; ?>
            </span>
        </div>
    </nav>

    <div class="container-fluid">
        <!-- Month buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-calendar me-2"></i>
                        Select Month
                    </div>
                    <div class="card-body text-center">
                        <?php 
                        $meses = [
                            'enero' => 'January',
                            'febrero' => 'February', 
                            'marzo' => 'March',
                            'abril' => 'April',
                            'mayo' => 'May',
                            'junio' => 'June',
                            'julio' => 'July',
                            'agosto' => 'August',
                            'septiembre' => 'September',
                            'octubre' => 'October',
                            'noviembre' => 'November',
                            'diciembre' => 'December'
                        ];

                        $mesActual = isset($_GET['mes']) ? $_GET['mes'] : 'enero';
                        
                        foreach ($meses as $clave => $nombre): ?>
                            <button class="btn btn-outline-primary btn-mes <?php echo ($mesActual === $clave) ? 'active' : ''; ?>" 
                                    data-mes="<?php echo $clave; ?>">
                                <i class="fas fa-calendar-day me-1"></i>
                                <?php echo $nombre; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading -->
        <div class="loading" id="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading data...</p>
        </div>

        <!-- Statistical summary -->
        <div class="row mb-4" id="stats-row">
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #0fc2f8ff 0%, #4831caff 100%);">
                    <div class="stat-value" id="stat-trabajadores"><?php echo $datos['trabajadores_total']; ?></div>
                    <div><i class="fas fa-users me-2"></i>Total Workers</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="stat-value" id="stat-incidentes"><?php echo $datos['incidentes']; ?></div>
                    <div><i class="fas fa-exclamation-triangle me-2"></i>Incidents</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="stat-value" id="stat-dias"><?php echo $datos['dias_sin_accidentes']; ?></div>
                    <div><i class="fas fa-shield-alt me-2"></i>Days Without Accidents</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <div class="stat-value" id="stat-capacitados"><?php echo $datos['capacitados']; ?></div>
                    <div><i class="fas fa-graduation-cap me-2"></i>Trained Workers</div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Incidents and Safety
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartIncidentes"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-users me-2"></i>
                        Worker Distribution
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartTrabajadores"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-2"></i>
                        Safety Indexes
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartIndices"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Training Status
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartRiesgo"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    
    <script>
        
        let chartIncidentes, chartTrabajadores, chartIndices, chartRiesgo;
  
        const datosIniciales = <?php echo json_encode($datosGraficas); ?>;
    
        document.addEventListener('DOMContentLoaded', function() {
            inicializarGraficas();
            configurarEventos();
        });
        
        function inicializarGraficas() {
           
            Chart.defaults.plugins.legend.position = 'bottom';
            Chart.defaults.plugins.legend.labels.usePointStyle = true;
            Chart.defaults.plugins.legend.labels.padding = 20;
            
           
            const ctxIncidentes = document.getElementById('chartIncidentes').getContext('2d');
            chartIncidentes = new Chart(ctxIncidentes, {
                type: 'doughnut',
                data: {
                    labels: datosIniciales.incidentes.labels,
                    datasets: [{
                        data: datosIniciales.incidentes.data,
                        backgroundColor: datosIniciales.incidentes.backgroundColor,
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
         
            const ctxTrabajadores = document.getElementById('chartTrabajadores').getContext('2d');
            chartTrabajadores = new Chart(ctxTrabajadores, {
                type: 'pie',
                data: {
                    labels: datosIniciales.trabajadores.labels,
                    datasets: [{
                        data: datosIniciales.trabajadores.data,
                        backgroundColor: datosIniciales.trabajadores.backgroundColor,
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
            
       
            const ctxIndices = document.getElementById('chartIndices').getContext('2d');
            chartIndices = new Chart(ctxIndices, {
                type: 'bar',
                data: {
                    labels: datosIniciales.indices.labels,
                    datasets: [{
                        data: datosIniciales.indices.data,
                        backgroundColor: datosIniciales.indices.backgroundColor,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
 
            const ctxRiesgo = document.getElementById('chartRiesgo').getContext('2d');
            chartRiesgo = new Chart(ctxRiesgo, {
                type: 'doughnut',
                data: {
                    labels: datosIniciales.riesgo.labels,
                    datasets: [{
                        data: datosIniciales.riesgo.data,
                        backgroundColor: datosIniciales.riesgo.backgroundColor,
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        function configurarEventos() {
         
            document.querySelectorAll('.btn-mes').forEach(button => {
                button.addEventListener('click', function() {
                    const mes = this.getAttribute('data-mes');
                    cambiarMes(mes, this);
                });
            });
        }
        
        function cambiarMes(mes, botonActivo) {
            //  loading
            document.getElementById('loading').style.display = 'block';
            document.getElementById('stats-row').style.opacity = '0.5';
            
       
            document.querySelectorAll('.btn-mes').forEach(btn => {
                btn.classList.remove('active');
            });
            botonActivo.classList.add('active');
            
          
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `accion=obtener_datos&mes=${mes}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    actualizarGraficas(data.graficas);
                    actualizarEstadisticas(data.datos);
                } else {
                    console.error('Error:', data.error);
                    alert('Error al cargar los datos: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión');
            })
            .finally(() => {
         
                document.getElementById('loading').style.display = 'none';
                document.getElementById('stats-row').style.opacity = '1';
            });
        }
        
        function actualizarGraficas(datos) {
          
            chartIncidentes.data.labels = datos.incidentes.labels;
            chartIncidentes.data.datasets[0].data = datos.incidentes.data;
            chartIncidentes.update('active');
            
     
            chartTrabajadores.data.labels = datos.trabajadores.labels;
            chartTrabajadores.data.datasets[0].data = datos.trabajadores.data;
            chartTrabajadores.update('active');
          
            chartIndices.data.labels = datos.indices.labels;
            chartIndices.data.datasets[0].data = datos.indices.data;
            chartIndices.update('active');
            
          
            chartRiesgo.data.labels = datos.riesgo.labels;
            chartRiesgo.data.datasets[0].data = datos.riesgo.data;
            chartRiesgo.update('active');
        }
        
        function actualizarEstadisticas(datos) {
            document.getElementById('stat-trabajadores').textContent = datos.trabajadores_total;
            document.getElementById('stat-incidentes').textContent = datos.incidentes;
            document.getElementById('stat-dias').textContent = datos.dias_sin_accidentes;
            document.getElementById('stat-capacitados').textContent = datos.capacitados;
        }
    </script>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</body>


</html>
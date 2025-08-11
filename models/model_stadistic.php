<?php
// Import database connection function
require_once './library/connections.php';

/**
 * Retrieves data from the 'datos_ssoma' table for a specific month.
 *
 * @param string $mes The month name (e.g., 'enero', 'febrero').
 * @return array|null Returns an associative array with data for the month, 
 *                    or a default array with zero values if no record is found,
 *                    or null in case of an error.
 */
function obtenerDatosPorMes($mes) {
    try {
        $pdo = dataPrueba();

        // Prepare query to get data for the given month (case-insensitive)
        $stmt = $pdo->prepare("SELECT * FROM datos_ssoma WHERE LOWER(mes) = LOWER(?) ORDER BY anio DESC LIMIT 1");
        $stmt->execute([$mes]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // If no data exists, return default structure with zero values
        if (!$result) {
            return [
                'id' => 0,
                'mes' => $mes,
                'anio' => date('Y'),
                'trabajadores_total' => 0,
                'trabajadores_admin' => 0,
                'trabajadores_oper' => 0,
                'dias_sin_accidentes' => 0,
                'porcentaje_accidentes' => 0.00,
                'incidentes' => 0,
                'indice_gravedad' => 0.00,
                'indice_frecuencia' => 0.00,
                'capacitados' => 0
            ];
        }
        
        return $result;
    } catch (PDOException $e) {
        // Log the error without exposing sensitive details to the user
        error_log("Error en obtenerDatosPorMes: " . $e->getMessage());
        return null;
    }
}

/**
 * Retrieves all records from 'datos_ssoma' ordered by month and year.
 *
 * @return array Returns an array of associative arrays containing all records.
 */
function obtenerTodosLosDatos() {
    try {
        $pdo = dataPrueba();

        // Order months manually to maintain chronological order
        $stmt = $pdo->prepare("SELECT * FROM datos_ssoma ORDER BY 
            CASE mes 
                WHEN 'enero' THEN 1 
                WHEN 'febrero' THEN 2 
                WHEN 'marzo' THEN 3 
                WHEN 'abril' THEN 4 
                WHEN 'mayo' THEN 5 
                WHEN 'junio' THEN 6 
                WHEN 'julio' THEN 7 
                WHEN 'agosto' THEN 8 
                WHEN 'septiembre' THEN 9 
                WHEN 'octubre' THEN 10 
                WHEN 'noviembre' THEN 11 
                WHEN 'diciembre' THEN 12 
            END, anio DESC");
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en obtenerTodosLosDatos: " . $e->getMessage());
        return [];
    }
}

/**
 * Retrieves a yearly summary from 'datos_ssoma' for the current year.
 *
 * @return array Returns an array with monthly totals, averages, and max values for the year.
 */
function obtenerResumenAnual() {
    try {
        $pdo = dataPrueba();

        // Get summarized data grouped by month for the current year
        $stmt = $pdo->prepare("
            SELECT 
                mes,
                SUM(incidentes) as total_incidentes,
                AVG(indice_frecuencia) as promedio_frecuencia,
                AVG(indice_gravedad) as promedio_gravedad,
                AVG(trabajadores_total) as promedio_trabajadores,
                MAX(dias_sin_accidentes) as max_dias_sin_accidentes
            FROM datos_ssoma 
            WHERE anio = YEAR(CURDATE())
            GROUP BY mes
            ORDER BY 
                CASE mes 
                    WHEN 'enero' THEN 1 
                    WHEN 'febrero' THEN 2 
                    WHEN 'marzo' THEN 3 
                    WHEN 'abril' THEN 4 
                    WHEN 'mayo' THEN 5 
                    WHEN 'junio' THEN 6 
                    WHEN 'julio' THEN 7 
                    WHEN 'agosto' THEN 8 
                    WHEN 'septiembre' THEN 9 
                    WHEN 'octubre' THEN 10 
                    WHEN 'noviembre' THEN 11 
                    WHEN 'diciembre' THEN 12 
                END
        ");
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en obtenerResumenAnual: " . $e->getMessage());
        return [];
    }
}
?>

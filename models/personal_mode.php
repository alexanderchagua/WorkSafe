<?php
// models/personal_mode.php - UPDATED
@require_once '../library/connections.php';

// Function to dynamically get all EPP columns
function getEppFields() {
    try {
        $conn = dataPrueba();
        $sql = "SHOW COLUMNS FROM personal_epp WHERE 
                Field NOT IN ('id', 'name', 'edad', 'ocupacion', 'area_trabajo', 'fecha_cumple', 
                             'fecha_ingreso', 'estado', 'sede', 'foto', 'estado_epp', 'observaciones', 
                             'fecha', 'foto_captura', 'firmar')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Organize by EPP groups
        $epps = [];
        foreach($columns as $column) {
            $field = $column['Field'];
            
            // Identify the type of field
            if(strpos($field, 'fecha_entrega_') === 0) {
                $epp_key = str_replace('fecha_entrega_', '', $field);
                $epps[$epp_key]['fecha_entrega'] = $field;
            } elseif(strpos($field, 'cambio_') === 0) {
                $epp_key = str_replace('cambio_', '', $field);
                $epps[$epp_key]['cambio'] = $field;
            } else {
                // Main EPP field
                $epp_key = $field;
                if(strpos($field, '_seguridad') !== false || strpos($field, '_casco') !== false) {
                    // For original EPPs like zapato_seguridad, casco_seguridad
                    $parts = explode('_', $field);
                    if(count($parts) >= 2) {
                        $epp_key = substr($parts[1], 0, 1) . (isset($parts[0]) ? substr($parts[0], 0, 1) : '');
                        if($field == 'zapato_seguridad') $epp_key = 'zp';
                        if($field == 'casco_seguridad') $epp_key = 'cs';
                        if($field == 'orejeras_casco') $epp_key = 'oc';
                    }
                }
                $epps[$epp_key]['campo'] = $field;
                $epps[$epp_key]['nombre'] = ucwords(str_replace('_', ' ', $field));
            }
        }
        
        return $epps;
    } catch(PDOException $e) {
        return [];
    }
}

function guardarDatosDinamico($personal_data, $epp_data, $signature) {
    $signature = str_replace('data:image/jpeg;base64,', '', $signature);
    
    try {
        $conn = dataPrueba();
        
        // Build the query dynamically
        $personal_fields = "name, edad, ocupacion, area_trabajo, fecha_cumple, fecha_ingreso, estado, estado_epp, observaciones, sede, foto, firmar";
        $personal_values = ":name, :edad, :ocupacion, :area_trabajo, :fecha_cumple, :fecha_ingreso, :estado, :estado_epp, :observaciones, :sede, :foto, :firmar";
        
        // Add dynamic EPP fields
        $epp_fields = "";
        $epp_values = "";
        $additional_params = [];
        
        foreach($epp_data as $field => $value) {
            $epp_fields .= ", " . $field;
            $epp_values .= ", :" . $field;
            $additional_params[$field] = $value;
        }
        
        $sql = "INSERT INTO personal_epp ({$personal_fields}{$epp_fields}) 
                VALUES ({$personal_values}{$epp_values})";
        
        $stmt = $conn->prepare($sql);
        
        // Bind personal parameters
        $stmt->bindParam(':name', $personal_data['name']);
        $stmt->bindParam(':edad', $personal_data['edad']);
        $stmt->bindParam(':ocupacion', $personal_data['ocupacion']);
        $stmt->bindParam(':area_trabajo', $personal_data['area_trabajo']);
        $stmt->bindParam(':fecha_cumple', $personal_data['fecha_cumple']);
        $stmt->bindParam(':fecha_ingreso', $personal_data['fecha_ingreso']);
        $stmt->bindParam(':estado', $personal_data['estado']);
        $stmt->bindParam(':estado_epp', $personal_data['estado_epp']);
        $stmt->bindParam(':observaciones', $personal_data['observaciones']);
        $stmt->bindParam(':sede', $personal_data['sede']);
        $stmt->bindParam(':foto', $personal_data['foto']);
        $stmt->bindParam(':firmar', $signature, PDO::PARAM_STR);
        
        // Bind dynamic EPP parameters
        foreach($additional_params as $param => $value) {
            $stmt->bindParam(':' . $param, $additional_params[$param]);
        }
        
        $stmt->execute();
        $conn = null;
        
        return true;
    } catch (PDOException $e) {
        echo "Error saving data: " . $e->getMessage();
        return false;
    }
}

// Function to get all personnel records
function getAllPersonal() {
    try {
        $conn = dataPrueba();
        $sql = "SELECT * FROM personal_epp ORDER BY fecha DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [];
    }
}

// Function to get a specific personnel record
function getPersonalById($id) {
    try {
        $conn = dataPrueba();
        $sql = "SELECT * FROM personal_epp WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return null;
    }
}

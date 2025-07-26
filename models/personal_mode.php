<?php
// models/personal_mode.php - ACTUALIZADO
@require_once './library/conections.php';

// Función para obtener todas las columnas EPP dinámicamente
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
        
        // Organizar por grupos de EPP
        $epps = [];
        foreach($columns as $column) {
            $field = $column['Field'];
            
            // Identificar el tipo de campo
            if(strpos($field, 'fecha_entrega_') === 0) {
                $epp_key = str_replace('fecha_entrega_', '', $field);
                $epps[$epp_key]['fecha_entrega'] = $field;
            } elseif(strpos($field, 'cambio_') === 0) {
                $epp_key = str_replace('cambio_', '', $field);
                $epps[$epp_key]['cambio'] = $field;
            } else {
                // Campo principal del EPP
                $epp_key = $field;
                if(strpos($field, '_seguridad') !== false || strpos($field, '_casco') !== false) {
                    // Para los EPP originales como zapato_seguridad, casco_seguridad
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

function guardarDatosDinamico($datos_personales, $datos_epp, $firmar) {
    $firmar = str_replace('data:image/jpeg;base64,', '', $firmar);
    
    try {
        $conn = dataPrueba();
        
        // Construir la consulta dinámicamente
        $campos_personales = "name, edad, ocupacion, area_trabajo, fecha_cumple, fecha_ingreso, estado, estado_epp, observaciones, sede, foto, firmar";
        $valores_personales = ":name, :edad, :ocupacion, :area_trabajo, :fecha_cumple, :fecha_ingreso, :estado, :estado_epp, :observaciones, :sede, :foto, :firmar";
        
        // Agregar campos EPP dinámicos
        $campos_epp = "";
        $valores_epp = "";
        $parametros_adicionales = [];
        
        foreach($datos_epp as $campo => $valor) {
            $campos_epp .= ", " . $campo;
            $valores_epp .= ", :" . $campo;
            $parametros_adicionales[$campo] = $valor;
        }
        
        $sql = "INSERT INTO personal_epp ({$campos_personales}{$campos_epp}) 
                VALUES ({$valores_personales}{$valores_epp})";
        
        $stmt = $conn->prepare($sql);
        
        // Vincular parámetros personales
        $stmt->bindParam(':name', $datos_personales['name']);
        $stmt->bindParam(':edad', $datos_personales['edad']);
        $stmt->bindParam(':ocupacion', $datos_personales['ocupacion']);
        $stmt->bindParam(':area_trabajo', $datos_personales['area_trabajo']);
        $stmt->bindParam(':fecha_cumple', $datos_personales['fecha_cumple']);
        $stmt->bindParam(':fecha_ingreso', $datos_personales['fecha_ingreso']);
        $stmt->bindParam(':estado', $datos_personales['estado']);
        $stmt->bindParam(':estado_epp', $datos_personales['estado_epp']);
        $stmt->bindParam(':observaciones', $datos_personales['observaciones']);
        $stmt->bindParam(':sede', $datos_personales['sede']);
        $stmt->bindParam(':foto', $datos_personales['foto']);
        $stmt->bindParam(':firmar', $firmar, PDO::PARAM_STR);
        
        // Vincular parámetros EPP dinámicos
        foreach($parametros_adicionales as $param => $valor) {
            $stmt->bindParam(':' . $param, $parametros_adicionales[$param]);
        }
        
        $stmt->execute();
        $conn = null;
        
        return true;
    } catch (PDOException $e) {
        echo "Error al guardar los datos: " . $e->getMessage();
        return false;
    }
}

// Función para obtener todos los registros de personal
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

// Función para obtener un registro específico
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

?>
<?php
/**
 * =========================================================================
 * ARCHIVO: models/PaseadorModel.php
 * =========================================================================
 * PROPÓSITO: El Músculo de los Paseadores (Procedimental, sin clases).
 * Contiene todas las consultas SQL que los empleados necesitan hacer.
 * =========================================================================
 */

require_once __DIR__ . '/../config/conexion.php';

/**
 * Obtiene todos los paseos asignados a este paseador que el Admin ya aprobó.
 * Combina 3 tablas usando la sintaxis del WHERE (Join implícito).
 */
function getMiAgenda($id_paseador) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Join implícito usando WHERE en lugar de INNER JOIN, sin sentencia preparada
    $sql = "SELECT 
                pa.id_paseo, pa.fecha, pa.hora_inicio, pa.hora_fin, pa.tipo_paseo, pa.estado_paseo,
                m.nombre as mascota_nombre, m.raza as mascota_raza, m.observaciones as mascota_observaciones,
                u.nombre as dueno_nombre, u.apellido as dueno_apellido, u.telefono as dueno_telefono, u.direccion as dueno_direccion
            FROM paseo pa, mascota m, usuarios u
            WHERE pa.id_mascota = m.id_mascota
              AND m.id_dueno = u.id_usuario
              AND pa.id_paseador = $id_paseador 
              AND pa.estado_habilitacion = 'habilitado_admin'
            ORDER BY pa.fecha ASC, pa.hora_inicio ASC";
    
    $result = $conn->query($sql);
    $paseos = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $paseos[] = $row;
        }
    }
    
    $conn->close();
    return $paseos;
}

/**
 * Cambia el estado del paseo (ej: de "no_iniciado" a "en_curso").
 */
function actualizarEstadoPaseo($id_paseo, $id_paseador, $nuevo_estado) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Consulta directa (sin sentencias preparadas)
    $sql = "UPDATE paseo 
            SET estado_paseo = '$nuevo_estado' 
            WHERE id_paseo = $id_paseo 
              AND id_paseador = $id_paseador";
              
    $resultado = $conn->query($sql);
    $conn->close();
    return $resultado;
}
?>

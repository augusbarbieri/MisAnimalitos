<?php
/**
 * =========================================================================
 * ARCHIVO: models/UsuarioModel.php
 * =========================================================================
 * PROPÓSITO: El Músculo de los Clientes (Procedimental, sin clases).
 * Contiene todas las consultas SQL que los dueños de mascotas necesitan.
 * =========================================================================
 */

require_once __DIR__ . '/../config/conexion.php';

/**
 * Trae la lista de mascotas que le pertenecen a este dueño específico.
 */
function getMascotas($id_dueno) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Consulta directa sin sentencias preparadas
    $sql = "SELECT id_mascota, nombre, raza, tamano, observaciones 
            FROM mascota 
            WHERE id_dueno = $id_dueno";
            
    $result = $conn->query($sql);
    $mascotas = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $mascotas[] = $row;
        }
    }
    
    $conn->close();
    return $mascotas;
}

/**
 * Registra un nuevo perrito en la base de datos.
 */
function crearMascota($data) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Escapamos strings para evitar roturas por comillas
    $nombre = $conn->real_escape_string($data['nombre']);
    $raza = $conn->real_escape_string($data['raza']);
    $tamano = $conn->real_escape_string($data['tamano']);
    $observaciones = $conn->real_escape_string($data['observaciones']);
    $id_dueno = (int)$data['id_dueno'];

    // Inserción directa
    $sql = "INSERT INTO mascota (id_dueno, nombre, raza, tamano, observaciones, creada_en, img) 
            VALUES ($id_dueno, '$nombre', '$raza', '$tamano', '$observaciones', CURDATE(), '')";
            
    $resultado = $conn->query($sql);
    $conn->close();
    return $resultado;
}

/**
 * Trae todos los paseadores que tengan la cuenta "activa" para mostrarlos en el select.
 */
function getPaseadoresActivos() {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $sql = "SELECT id_paseador, nombre, apellido, zona, disponibilidad, rating 
            FROM paseador 
            WHERE estado = 'activo'";
            
    $result = $conn->query($sql);
    $paseadores = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $paseadores[] = $row;
        }
    }
    
    $conn->close();
    return $paseadores;
}

/**
 * Lógica de Solicitud de Paseo (Procedimental).
 * Crea el Paseo y la Factura a pagar (Pago) atada a ese paseo.
 */
function solicitarPaseo($data) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $conn->begin_transaction(); // Pausamos la BD

    $id_mascota = (int)$data['id_mascota'];
    $id_paseador = (int)$data['id_paseador'];
    $fecha = $conn->real_escape_string($data['fecha']);
    $hora_inicio = $conn->real_escape_string($data['hora_inicio']);
    $tipo_paseo = $conn->real_escape_string($data['tipo_paseo']);

    // Calculamos que el paseo dura 1 hora exacta
    $hora_fin = date('H:i', strtotime($hora_inicio . ' + 1 hour'));

    // ACCIÓN 1: Crear el Paseo (Consulta directa)
    $sqlPaseo = "INSERT INTO paseo (id_mascota, id_paseador, fecha, hora_inicio, hora_fin, zona, precio, estado_paseo, tipo_paseo, estado_habilitacion) 
                 VALUES ($id_mascota, $id_paseador, '$fecha', '$hora_inicio', '$hora_fin', 'Por definir', 0, 'no_iniciado', '$tipo_paseo', 'pendiente_pago')";
    
    $res1 = $conn->query($sqlPaseo);
    
    // Obtenemos el ID Autonumérico recién asignado
    $id_paseo = $conn->insert_id;

    // ACCIÓN 2: Crear la factura (Pago) pendiente usando el ID del paseo anterior
    $sqlPago = "INSERT INTO pago (id_paseo, monto, fecha_pago, estado_pago) 
                VALUES ($id_paseo, 0, CURDATE(), 'pendiente')";
    
    $res2 = $conn->query($sqlPago);

    // Guardamos solo si ambas consultas fueron exitosas
    if ($res1 && $res2 && $id_paseo > 0) {
        $conn->commit();
        $conn->close();
        return true;
    } else {
        $conn->rollback();
        $conn->close();
        return false;
    }
}

/**
 * Trae el historial de todos los paseos que este dueño ha pedido alguna vez.
 * Simplifica la unión de paseo y mascota con WHERE implícito.
 */
function getMisPaseos($id_dueno) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Consulta directa usando INNER JOIN y LEFT JOIN
    $sql = "SELECT 
                pa.id_paseo, pa.fecha, pa.hora_inicio, pa.tipo_paseo, pa.estado_paseo, pa.estado_habilitacion,
                pg.estado_pago,
                m.nombre as mascota_nombre,
                pas.nombre as paseador_nombre, pas.apellido as paseador_apellido
            FROM paseo pa
            INNER JOIN mascota m ON pa.id_mascota = m.id_mascota
            LEFT JOIN pago pg ON pa.id_paseo = pg.id_paseo
            LEFT JOIN paseador pas ON pa.id_paseador = pas.id_paseador
            WHERE m.id_dueno = $id_dueno
            ORDER BY pa.fecha DESC";
            
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
?>

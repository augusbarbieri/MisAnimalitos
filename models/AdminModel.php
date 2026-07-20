<?php
/**
 * =========================================================================
 * ARCHIVO: models/AdminModel.php
 * =========================================================================
 * PROPÓSITO: Es el "Músculo" del Administrador (Procedimental, sin clases).
 * Contiene todas las consultas SQL (SELECT, INSERT, UPDATE) 
 * que el Administrador necesita para interactuar con la Base de Datos.
 * =========================================================================
 */

require_once __DIR__ . '/../config/conexion.php';

/**
 * Obtiene TODOS los dueños de mascotas.
 */
function getUsuarios() {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $sql = "SELECT id_usuario, nombre, apellido, email, telefono, direccion, fecha_registro, img FROM usuarios";
    $result = $conn->query($sql);
    
    $usuarios = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }
    
    $conn->close();
    return $usuarios;
}

/**
 * Obtiene TODOS los paseadores.
 */
function getPaseadores() {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $sql = "SELECT id_paseador, nombre, apellido, email, telefono, zona, disponibilidad, estado, rating, fecha_alta FROM paseador";
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
 * Obtiene TODOS los Pedidos combinando 4 tablas distintas usando JOIN.
 */
function getPedidos() {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $sql = "SELECT 
                pa.id_paseo, pa.fecha, pa.hora_inicio, pa.hora_fin, pa.zona, pa.tipo_paseo, pa.estado_paseo, pa.estado_habilitacion, pa.precio,
                pg.id_pago, pg.monto, pg.estado_pago,
                m.nombre as mascota_nombre,
                u.nombre as dueno_nombre, u.apellido as dueno_apellido,
                pas.nombre as paseador_nombre, pas.apellido as paseador_apellido
            FROM paseo pa
            LEFT JOIN pago pg ON pa.id_paseo = pg.id_paseo
            LEFT JOIN mascota m ON pa.id_mascota = m.id_mascota
            LEFT JOIN usuarios u ON m.id_dueno = u.id_usuario
            LEFT JOIN paseador pas ON pa.id_paseador = pas.id_paseador
            ORDER BY pa.fecha DESC";
            
    $result = $conn->query($sql);
    $pedidos = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = $row;
        }
    }
    
    $conn->close();
    return $pedidos;
}

/**
 * Confirma el pago de un paseo (Usa transacción con consultas directas).
 */
function confirmarPago($id_pago, $id_paseo) {
    $conn = conectarBDManadas();
    if (!$conn) {
        return false;
    }

    $conn->begin_transaction(); // Modo pausa

    // ACCIÓN 1: Actualizamos la tabla 'pago' (directa)
    $res1 = $conn->query("UPDATE pago SET estado_pago = 'confirmado' WHERE id_pago = $id_pago");

    // ACCIÓN 2: Actualizamos la tabla 'paseo' (directa)
    $res2 = $conn->query("UPDATE paseo SET estado_habilitacion = 'habilitado_admin' WHERE id_paseo = $id_paseo");

    if ($res1 && $res2) {
        $conn->commit(); // Todo OK, guarda
        $conn->close();
        return true;
    } else {
        $conn->rollback(); // Falla, cancela
        $conn->close();
        return false;
    }
}

/**
 * Agrega un nuevo paseador a la Base de Datos.
 */
function crearPaseador($data) {
    $conn = conectarBDManadas();
    if (!$conn) {
        return false;
    }

    // Escapamos strings para evitar roturas por comillas
    $nombre = $conn->real_escape_string($data['nombre']);
    $apellido = $conn->real_escape_string($data['apellido']);
    $email = $conn->real_escape_string($data['email']);
    $telefono = $conn->real_escape_string($data['telefono']);
    $zona = $conn->real_escape_string($data['zona']);
    $disponibilidad = $conn->real_escape_string($data['disponibilidad']);
    $bio = $conn->real_escape_string($data['bio']);

    // HASH DE CONTRASEÑA
    $hash = password_hash($data['password'], PASSWORD_DEFAULT);

    // Consulta de inserción directa sin Prepared Statements
    $sql = "INSERT INTO paseador (nombre, apellido, email, password, telefono, zona, disponibilidad, estado, bio, rating, fecha_alta) 
            VALUES ('$nombre', '$apellido', '$email', '$hash', '$telefono', '$zona', '$disponibilidad', 'activo', '$bio', 5, CURDATE())";
    
    $resultado = $conn->query($sql);
    $conn->close();
    return $resultado;
}
?>

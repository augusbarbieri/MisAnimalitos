<?php
/**
 * =========================================================================
 * ARCHIVO: models/AuthModel.php
 * =========================================================================
 * PROPÓSITO: El detective encargado de ir a la Base de Datos, buscar 
 * a la persona con un Email específico, y comprobar que la contraseña
 * proporcionada sea correcta (Procedimental, sin clases ni prepared statements).
 * =========================================================================
 */

require_once __DIR__ . '/../config/conexion.php';

/**
 * Función verificar_password()
 * Compara la contraseña en texto plano con el hash.
 */
function verificar_password($plain, $stored) {
    return password_verify($plain, $stored) || ($plain === $stored);
}

/**
 * Busca el email en una de las 3 tablas (admin, paseador, usuarios).
 */
function autenticarEnTabla($email, $password, $tabla) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Escapamos el string para evitar inyección SQL y roturas por comillas
    $email = $conn->real_escape_string($email);

    // Consulta directa concatenando variables (sin Prepared Statements)
    $sql = "SELECT * FROM $tabla WHERE email = '$email' LIMIT 1";
    $resultado = $conn->query($sql);

    // ¿Encontró una fila que coincida con ese Email?
    if ($resultado && $resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc(); // Extraemos los datos de esa fila
        
        // Si el email existe, verificamos la contraseña
        if (verificar_password($password, $usuario['password'])) {
            $conn->close();
            return $usuario; // Éxito! Devolvemos todo el perfil del usuario
        }
    }
    
    $conn->close();
    return null; // El email no existe o la contraseña era mala
}

/**
 * LÓGICA PRINCIPAL DEL LOGIN
 * Busca el email en cada una de las 3 tablas por orden.
 */
function autenticarUsuario($email, $password) {
    // 1. ¿Es el jefe (Admin)?
    $usuario = autenticarEnTabla($email, $password, 'admin');
    if ($usuario) return ['datos' => $usuario, 'rol' => 'admin', 'id_col' => 'id_admin'];

    // 2. ¿Es un empleado (Paseador)?
    $usuario = autenticarEnTabla($email, $password, 'paseador');
    if ($usuario) return ['datos' => $usuario, 'rol' => 'paseador', 'id_col' => 'id_paseador'];

    // 3. ¿Es un cliente (Usuario dueño de mascota)?
    $usuario = autenticarEnTabla($email, $password, 'usuarios');
    if ($usuario) return ['datos' => $usuario, 'rol' => 'usuario', 'id_col' => 'id_usuario'];

    // Si pasó las 3 tablas y no lo encontró, lo rechazamos
    return null; 
}

/**
 * Comprueba si un email ya está registrado en alguna de las 3 tablas.
 */
function emailExiste($email) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $email = $conn->real_escape_string($email);

    $tablas = ['admin', 'paseador', 'usuarios'];
    foreach ($tablas as $tabla) {
        $sql = "SELECT email FROM $tabla WHERE email = '$email' LIMIT 1";
        $resultado = $conn->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            $conn->close();
            return true;
        }
    }

    $conn->close();
    return false;
}

/**
 * Registra un nuevo dueño de mascota (usuario) en la tabla 'usuarios'.
 */
function registrarCliente($data) {
    $conn = conectarBDManadas();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Escapamos strings para evitar roturas por comillas
    $nombre = $conn->real_escape_string($data['nombre']);
    $apellido = $conn->real_escape_string($data['apellido']);
    $email = $conn->real_escape_string($data['email']);
    $telefono = $conn->real_escape_string($data['telefono']);
    $direccion = $conn->real_escape_string($data['direccion']);
    // Ciframos la contraseña usando password_hash (es simple y seguro)
    $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, apellido, email, password, telefono, direccion, fecha_registro, img) 
            VALUES ('$nombre', '$apellido', '$email', '$password_hash', '$telefono', '$direccion', NOW(), 'uploads/perfiles/default.png')";

    $resultado = $conn->query($sql);
    $conn->close();
    return $resultado;
}
?>

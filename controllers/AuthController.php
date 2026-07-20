<?php
/**
 * =========================================================================
 * ARCHIVO: controllers/AuthController.php
 * =========================================================================
 * PROPÓSITO: El Guardia de Seguridad Principal de la app.
 * Recibe el email y contraseña del login.php, se los pasa al AuthModel
 * para verificar si existen, y si es correcto, crea la sesión y redirige 
 * a la pantalla correcta dependiendo del Rol (Admin, Paseador, Dueño).
 * =========================================================================
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/sesion.php';
require_once __DIR__ . '/../models/AuthModel.php';

// 1. Obtenemos la acción (por defecto intentaremos iniciar sesión)
$action = $_GET['action'] ?? 'login';

// 2. CASO: LOGIN
// Comprobamos que vengan de hacer clic en "Ingresar" (método POST)
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Limpiamos los datos que escribió el usuario (quitamos espacios extras con trim)
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validación básica: Si no escribió nada, lo pateamos de vuelta al form
    if ($email === '' || $password === '') {
        header("Location: " . BASE_URL . "views/login.php?error=campos_vacios");
        exit();
    }

    // 3. Hablamos con el Modelo (Base de Datos)
    // Le decimos: "¿Existe alguien con este email y esta password?"
    $resultadoAuth = autenticarUsuario($email, $password);
    
    // 4. Si el modelo nos devolvió datos... ¡El login fue un Éxito!
    if ($resultadoAuth) {
        $usuario_autenticado = $resultadoAuth['datos']; // Array con datos del usuario
        $rol = $resultadoAuth['rol'];                   // Qué es: 'admin', 'usuario', 'paseador'
        $id_col = $resultadoAuth['id_col'];             // Cómo se llama la columna de su ID

        // 5. Preparamos las variables para guardarlas en la "memoria" (Sesión)
        $id_usuario = $usuario_autenticado[$id_col];
        $nombre = trim(($usuario_autenticado['nombre'] ?? '') . ' ' . ($usuario_autenticado['apellido'] ?? ''));
        $img = $usuario_autenticado['img'] ?? null;

        // 6. CREAMOS LA SESIÓN (Mirar config/sesion.php)
        crearSesion($email, $rol, $id_usuario, $nombre, $img);

        // 7. ENRUTADOR MÁGICO SEGÚN EL ROL
        // Si el portero te reconoce, te manda a tu piso correspondiente
        switch ($rol) {
            case 'admin':
                header("Location: " . BASE_URL . "controllers/AdminController.php?action=inicio");
                break;
            case 'paseador':
                header("Location: " . BASE_URL . "controllers/PaseadorController.php?action=inicio");
                break;
            case 'usuario': // Dueño de Mascota
                header("Location: " . BASE_URL . "controllers/UsuarioController.php?action=inicio");
                break;
            default:
                header("Location: " . BASE_URL . "views/login.php");
                break;
        }
        exit();
        
    } else {
        // 8. LOGIN FALLIDO: Las contraseñas no coinciden o no existe el email
        header("Location: " . BASE_URL . "views/login.php?error=credenciales_invalidas");
        exit();
    }
    
// 9. CASO: REGISTRO (Guardar datos en BD)
} else if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'apellido' => trim($_POST['apellido'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'telefono' => trim($_POST['telefono'] ?? ''),
        'direccion' => trim($_POST['direccion'] ?? '')
    ];

    // Validación básica simplificada
    if ($data['nombre'] === '' || $data['apellido'] === '' || $data['email'] === '' || $data['password'] === '') {
        header("Location: " . BASE_URL . "views/registro.php?error=campos_vacios");
        exit();
    }

    // Verificar si el correo ya existe
    if (emailExiste($data['email'])) {
        header("Location: " . BASE_URL . "views/registro.php?error=email_existente");
        exit();
    }

    // Registrar al cliente
    if (registrarCliente($data)) {
        header("Location: " . BASE_URL . "views/login.php?msg=registrado");
    } else {
        header("Location: " . BASE_URL . "views/registro.php?error=error_db");
    }
    exit();

// 10. CASO: LOGOUT (Cerrar Sesión)
} else if ($action === 'logout') {
    cerrarSesion(); // Esta función (en sesion.php) ya destruye todo y redirige al login
    exit();
    
} else {
    // Si entró a este archivo sin mandar datos (ej: por URL), al login de vuelta
    header("Location: " . BASE_URL . "views/login.php");
    exit();
}

<?php
/**
 * =========================================================================
 * ARCHIVO: config/sesion.php
 * =========================================================================
 * PROPÓSITO: Manejar el "Estado" del usuario. HTTP es un protocolo sin 
 * estado (no tiene memoria). Usamos $_SESSION de PHP para que el servidor 
 * "recuerde" que el usuario ya puso su contraseña y no se la pida en cada clic.
 * =========================================================================
 */

// Incluimos config.php para tener disponible la constante BASE_URL
require_once __DIR__ . '/config.php';

// 1. INICIAR SESIÓN (Motor de Cookies de PHP)
// Preguntamos: ¿La sesión ya arrancó? Si no es así, la iniciamos.
// Esto le envía una cookie (PHPSESSID) al navegador del usuario.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Función crearSesion()
 * Toma los datos validados de la Base de Datos (en el login) 
 * y los guarda permanentemente en la memoria del servidor ($_SESSION).
 */
function crearSesion($email, $role, $user_id, $name, $img) {
    $_SESSION['email'] = $email;
    $_SESSION['role'] = strtolower($role); // Guardamos el rol ('admin', 'usuario', 'paseador')
    $_SESSION['user_id'] = $user_id;       // El ID para saber qué paseos le pertenecen
    $_SESSION['user_name'] = $name;        // Para saludarlo en la barra superior
    $_SESSION['user_img'] = $img;
}

/**
 * Función cerrarSesion()
 * Borra por completo la memoria que el servidor tenía de este usuario.
 */
function cerrarSesion() {
    session_unset();    // Vacía las variables de $_SESSION
    session_destroy();  // Destruye el archivo físico de la sesión en el servidor

    // Redirige al login usando nuestra constante global
    header("Location: " . BASE_URL . "views/login.php");
    exit(); // IMPORTANTE: Mata la ejecución para que no se envíe más código HTML
}

/**
 * Función is_logged_in()
 * Pregunta sencilla: "¿Hay un ID de usuario en la memoria de la sesión?"
 * @return bool True si está logueado, false si no.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Función require_login()
 * EL ESCUDO PROTECTOR. Esta función se coloca arriba de todos los Controladores.
 * Si alguien intenta entrar tipeando la URL a escondidas y no está logueado,
 * esta función lo patea de vuelta al login instantáneamente.
 */
function require_login() {
    if (!is_logged_in()) {
        header("Location: " . BASE_URL . "views/login.php");
        exit(); // Corta el cable rojo. No procesa ni una línea más de código.
    }
}

/**
 * Función get_user_role()
 * Devuelve el rol actual ('admin', 'usuario' o 'paseador').
 * Si no está definido (null), devuelve null.
 */
function get_user_role() {
    return $_SESSION['role'] ?? null;
}

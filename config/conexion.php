<?php
/**
 * =========================================================================
 * ARCHIVO: config/conexion.php
 * =========================================================================
 * PROPÓSITO: Este archivo es el único encargado de hablar con el servidor 
 * de la Base de Datos (MySQL). Usamos este archivo para que, si el día 
 * de mañana cambiamos la contraseña o el servidor, solo tengamos que 
 * modificar estas 4 líneas y no buscar por todo el proyecto.
 * =========================================================================
 */

/**
 * Función conectarBDManadas()
 * Crea una nueva conexión a MySQL usando la librería "mysqli" orientada a objetos.
 * 
 * @return mysqli|null Retorna el objeto de conexión si es exitoso, o null si falla.
 */
function conectarBDManadas()
{
    // 1. Definimos las credenciales de nuestro servidor local XAMPP
    $host = "127.0.0.1"; // Servidor local (localhost)
    $user = "root";      // Usuario por defecto de XAMPP
    $pass = "";          // Contraseña por defecto (vacía)
    $db = "manadas";     // El nombre exacto de nuestra base de datos

    try {
        // 2. Intentamos crear el túnel de conexión
        $conn = new mysqli($host, $user, $pass, $db);
        
        // 3. Verificamos si hubo un error interno en la conexión
        if ($conn->connect_error) {
            // "Lanzamos" una excepción que detiene la ejecución normal
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // 4. Si todo salió bien, devolvemos el túnel (la conexión)
        return $conn;
        
    } catch (Exception $e) {
        // 5. Si algo falló (ej: XAMPP apagado), capturamos el error
        // En vez de mostrar un error feo al usuario, lo guardamos en un log
        error_log("Error de conexión a la base de datos: " . $e->getMessage());
        return null;
    }
}

/**
 * Función cerrarBDConexion()
 * Buena práctica: Cuando terminamos de pedirle datos a MySQL, debemos
 * cerrar el túnel para no saturar la memoria del servidor.
 * 
 * @param mysqli $conn El objeto de conexión abierto
 */
function cerrarBDConexion($conn)
{
    if ($conn) {
        $conn->close();
    }
}

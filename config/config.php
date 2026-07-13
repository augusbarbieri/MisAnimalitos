<?php
/**
 * =========================================================================
 * ARCHIVO: config/config.php
 * =========================================================================
 * PROPÓSITO: Define variables y "Constantes" globales que se usan en todo 
 * el sistema. La más importante es "BASE_URL", que calcula automáticamente 
 * en qué carpeta está instalado nuestro proyecto.
 * =========================================================================
 */

// Verificamos si BASE_URL ya fue definida antes (para no declararla 2 veces y causar error)
if (!defined('BASE_URL')) {
    
    // 1. Calculamos dinámicamente la ruta base. 
    // ¿Por qué hacemos esto? Para que si mueves el proyecto de "htdocs/Grupo6" a "htdocs/Produccion",
    // no tengas que reescribir a mano todas las rutas de imágenes y CSS en el código.
    $config_dir = str_replace('\\', '/', __DIR__);
    $document_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

    // 2. Comprobamos si estamos dentro de la ruta pública del servidor web
    if (!empty($document_root) && strpos($config_dir, $document_root) === 0) {
        
        // Extraemos la porción de la URL que corresponde a nuestro proyecto
        $base_path = substr($config_dir, strlen($document_root));
        
        // Le quitamos la carpeta '/config' para quedarnos solo con la raíz '/Grupo6/'
        $base_url = str_replace('/config', '', $base_path);
        
        // 3. ¡MOMENTO CLAVE! Declaramos la Constante BASE_URL.
        // Las constantes (en mayúsculas) se pueden usar en cualquier archivo PHP sin importar.
        // Ejemplo de uso: <a href="<?php echo BASE_URL; ?>views/login.php">
        define('BASE_URL', rtrim($base_url, '/') . '/');
    } else {
        // Plan B: Si la lógica de arriba falla (ej. en servidores raros), caemos en la raíz simple '/'
        define('BASE_URL', '/');
    }
}

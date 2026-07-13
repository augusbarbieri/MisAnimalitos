<?php
/**
 * =========================================================================
 * ARCHIVO: index.php (Punto de Entrada)
 * =========================================================================
 * PROPÓSITO: Cuando un usuario entra a "localhost/Grupo6/", el servidor 
 * busca automáticamente este archivo. Actúa como un semáforo que redirige
 * todo el tráfico inicial hacia la pantalla de Inicio de Sesión.
 * =========================================================================
 */

// header() envía un comando al navegador del usuario para que cambie de página
header("Location: views/login.php");

// exit() es crucial: Detiene la ejecución de PHP aquí mismo.
// Evita que el servidor siga procesando código innecesariamente después de redirigir.
exit();
?>

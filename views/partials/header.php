<?php
/**
 * =========================================================================
 * ARCHIVO: views/partials/header.php
 * =========================================================================
 * PROPÓSITO: Es la "Cabeza" de todas las páginas de nuestro sistema.
 * En lugar de copiar y pegar el <head> y el menú superior en las 15 páginas,
 * lo escribimos una sola vez aquí y lo "requerimos" en las demás.
 * =========================================================================
 */

// Traemos la configuración para poder usar la constante BASE_URL en los links CSS
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título Dinámico: Si la vista definió $tituloPagina, lo usamos, si no, ponemos 'Manadas' -->
    <title><?php echo $tituloPagina ?? 'Manadas'; ?></title>
    
    <!-- Tipografía Externa de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Nuestra Hoja de Estilos Principal -->
    <!-- El ?v=time() es un truco para que el navegador no cachee el CSS antiguo si hacemos cambios -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>Assets/css/new-style.css?v=<?php echo time(); ?>">
</head>

<!-- Inyectamos una clase especial en el <body> si la vista la necesita (ej: login-page para cambiar el fondo) -->
<body class="<?php echo $bodyClass ?? ''; ?>">

<!-- LÓGICA DE BARRA DE NAVEGACIÓN -->
<!-- Si ESTAMOS en la página de login, ocultamos la barra superior para que quede limpia. -->
<?php if (!isset($bodyClass) || $bodyClass !== 'login-page'): ?>
<header class="main-header">
    <a href="<?php echo BASE_URL; ?>" class="logo">
        <i class="fas fa-paw"></i> Manadas
    </a>
    
    <!-- Si hay alguien logueado (existe su ID en sesión), mostramos su nombre y el botón de Salir -->
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="header-actions">
            <!-- explode() corta el nombre por los espacios y [0] agarra solo el primer nombre (ej: "Juan Perez" -> "Juan") -->
            <span class="user-greeting">Hola, <?php echo htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]); ?></span>
            
            <a href="<?php echo BASE_URL; ?>controllers/AuthController.php?action=logout" class="btn-secondary" style="padding: 6px 15px; font-size: 0.9em; border-color: #EF4444; color: #EF4444 !important;">
                Salir <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    <?php endif; ?>
</header>
<?php endif; ?>

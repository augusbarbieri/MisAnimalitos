<?php
/**
 * =========================================================================
 * VISTA: views/paseador/inicio.php
 * =========================================================================
 * PROPÓSITO: El menú principal para los empleados (Paseadores). 
 * Es muy sencillo porque su único trabajo es revisar su agenda.
 * =========================================================================
 */
$tituloPagina = "Panel del Paseador";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container" style="padding: 20px;">
    <h1>Panel del Paseador</h1>
    <p>¡Hola, <?php echo $_SESSION['user_name']; ?>! Listo para un día de paseos?</p>
    
    <div style="display: flex; gap: 20px; margin-top: 20px;">
        <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=agenda" class="btn-login" style="text-decoration:none; text-align:center; display:inline-block; padding:10px; background-color:#17a2b8;">Ver Mi Agenda</a>
        
        <!-- Reutilizamos el AuthController para cerrar sesión sin importar el tipo de usuario -->
        <a href="<?php echo BASE_URL; ?>controllers/AuthController.php?action=logout" class="btn-login" style="text-decoration:none; text-align:center; display:inline-block; padding:10px; background-color:#dc3545;">Cerrar Sesión</a>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

<?php
/**
 * =========================================================================
 * VISTA: views/usuario/inicio.php (Dashboard del Dueño)
 * =========================================================================
 * PROPÓSITO: Es el panel de control amigable que ve el dueño de la mascota
 * al iniciar sesión. Le ofrece 3 tarjetas gigantes para ir a las secciones
 * más importantes.
 * =========================================================================
 */
$tituloPagina = "Panel de Dueño";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="hero-contained" style="margin-bottom: 20px;">
    <h1>Panel de Dueño de Mascota</h1>
    <!-- La variable $_SESSION['user_name'] fue guardada durante el Login (ver AuthController) -->
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>. ¿Qué necesitas hoy?</p>
</div>

<div class="container">
    <div class="dashboard-cards">
        
        <!-- Botón a Mis Mascotas -->
        <div class="dashboard-card">
            <h2>🐶 Mis Mascotas</h2>
            <p>Gestiona los perfiles de tus mejores amigos.</p>
            <br>
            <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=mascotas" class="btn-dashboard-card">Ver Mascotas</a>
        </div>
        
        <!-- Botón a Pedir Paseo (Destacado en color verde para que resalte) -->
        <div class="dashboard-card" style="border: 2px solid var(--primary);">
            <h2>📅 Pedir Paseo</h2>
            <p>Reserva un nuevo paseo para tu mascota.</p>
            <br>
            <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=pedir_paseo" class="btn-dashboard-card" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">Solicitar Ahora</a>
        </div>
        
        <!-- Botón al Historial -->
        <div class="dashboard-card">
            <h2>📋 Mis Reservas</h2>
            <p>Historial y estado de tus paseos.</p>
            <br>
            <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=mis_paseos" class="btn-dashboard-card">Ver Historial</a>
        </div>
        
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

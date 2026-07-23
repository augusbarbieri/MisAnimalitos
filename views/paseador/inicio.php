<?php
/**
 * =========================================================================
 * VISTA: views/paseador/inicio.php
 * =========================================================================
 * PROPÓSITO: El menú principal para los empleados (Paseadores). 
 * Muestra el resumen de sus paseos asignados.
 * =========================================================================
 */
$tituloPagina = "Panel del Paseador";
require_once __DIR__ . '/../partials/header.php';
?>

<!-- Sección Héroe (Banner superior) -->
<div class="hero-contained" style="margin-bottom: 20px;">
    <h1>Panel de Control</h1>
    <!-- Usamos htmlspecialchars para evitar ataques XSS -->
    <p>¡Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! Listo para un día de paseos?</p>
</div>

<div class="container">
    <!-- Grid CSS para acomodar las tarjetas una al lado de otra -->
    <div class="dashboard-cards">
        
        <!-- Tarjeta 1: Paseos Pendientes -->
        <div class="dashboard-card">
            <h2>Paseos Pendientes</h2>
            <p>Servicios aprobados para comenzar</p>
            <div class="dashboard-card-count" style="background: linear-gradient(135deg, var(--info) 0%, #2563EB 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <?php echo $pendientes ?? 0; ?>
            </div>
            <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=agenda" class="btn-dashboard-card">Ver Mi Agenda</a>
        </div>

        <!-- Tarjeta 2: Paseos En Curso -->
        <div class="dashboard-card">
            <h2>En Curso</h2>
            <p>Paseos que estás realizando ahora</p>
            <div class="dashboard-card-count" style="background: linear-gradient(135deg, var(--warning) 0%, #EA580C 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <?php echo $en_curso ?? 0; ?>
            </div>
            <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=agenda" class="btn-dashboard-card">Ir a la Agenda</a>
        </div>

        <!-- Tarjeta 3: Mi Perfil -->
        <div class="dashboard-card">
            <h2>Mi Perfil</h2>
            <p>Ver y actualizar tus datos personales</p>
            <div class="dashboard-card-count" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <i class="fas fa-user-cog" style="font-size: 0.8em;"></i>
            </div>
            <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=perfil" class="btn-dashboard-card">Ver Mi Perfil</a>
        </div>

        <!-- Tarjeta 4: Total del Día -->
        <div class="dashboard-card">
            <h2>Agenda Total</h2>
            <p>Total de paseos asignados hoy</p>
            <div class="dashboard-card-count">
                <?php echo $totalPaseos ?? 0; ?>
            </div>
            <a href="<?php echo BASE_URL; ?>controllers/AuthController.php?action=logout" class="btn-dashboard-card" style="background: linear-gradient(135deg, var(--danger) 0%, #B91C1C 100%); box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);">Cerrar Sesión</a>
        </div>

    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

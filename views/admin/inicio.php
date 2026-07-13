<?php
/**
 * =========================================================================
 * VISTA: views/admin/inicio.php (Dashboard del Admin)
 * =========================================================================
 * PROPÓSITO: Es la pantalla principal que ve el administrador al loguearse.
 * Muestra métricas rápidas (tarjetas). Las variables $totalPaseadores, 
 * $totalUsuarios y $pendientes fueron calculadas previamente por el 
 * AdminController antes de incluir este archivo.
 * =========================================================================
 */
$tituloPagina = "Dashboard Administrador";
require_once __DIR__ . '/../partials/header.php';
?>

<!-- Sección Héroe (Banner superior) -->
<div class="hero-contained" style="margin-bottom: 20px;">
    <h1>Panel de Control</h1>
    <!-- Usamos htmlspecialchars para evitar ataques XSS si el nombre tuviera código malicioso -->
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>. Aquí tienes el resumen de tu plataforma.</p>
</div>

<div class="container">
    <!-- Grid CSS para acomodar las tarjetas una al lado de otra -->
    <div class="dashboard-cards">
        
        <!-- Tarjeta 1: Paseadores -->
        <div class="dashboard-card">
            <h2>Paseadores</h2>
            <p>Equipo activo registrado</p>
            <!-- Imprimimos la variable calculada en el controlador. '?? 0' previene errores si está vacía -->
            <div class="dashboard-card-count"><?php echo $totalPaseadores ?? 0; ?></div>
            <!-- Botón de acción que redirige al Controlador con action=paseadores -->
            <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=paseadores" class="btn-dashboard-card">Gestionar</a>
        </div>
        
        <!-- Tarjeta 2: Dueños -->
        <div class="dashboard-card">
            <h2>Dueños / Clientes</h2>
            <p>Usuarios registrados</p>
            <div class="dashboard-card-count"><?php echo $totalUsuarios ?? 0; ?></div>
            <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=usuarios" class="btn-dashboard-card">Ver Usuarios</a>
        </div>
        
        <!-- Tarjeta 3: Paseos Pendientes -->
        <div class="dashboard-card">
            <h2>Paseos Activos</h2>
            <p>Pedidos en curso o pendientes</p>
            <!-- A esta tarjeta le aplicamos un degradado naranja directo en el CSS en línea para resaltarla -->
            <div class="dashboard-card-count" style="background: linear-gradient(135deg, #F59E0B 0%, #EA580C 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <?php echo $pendientes ?? 0; ?>
            </div>
            <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=pedidos" class="btn-dashboard-card">Ver Pedidos</a>
        </div>
        
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

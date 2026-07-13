<?php
require_once __DIR__ . '/../../php/config.php'; // Defines BASE_URL
include_once __DIR__ . '/../../componentes/header.php';
?>

<!-- HERO -->
<section class.php="hero text-center text-white bg-dark py-5 mt-3">
    <div class="container">
        <h1 class="display-6 fw-bold mb-2">¡Bienvenido, Paseador!</h1>
        <p class="lead mb-0">Gestioná tus paseos y tu perfil desde este panel.</p>
    </div>
</section>

<!-- RESUMEN DEL DÍA -->
<div class="container my-4">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Paseos hoy</h6>
                    <div class="display-6 fw-bold">2</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">En curso</h6>
                    <div class="display-6 fw-bold">1</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Finalizados</h6>
                    <div class="display-6 fw-bold">0</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ACCESOS RÁPIDOS -->
<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">📅 Mis Paseos</h5>
                    <p class="text-muted flex-grow-1">Ver y actualizar el estado de los paseos asignados.</p>
                    <a href="<?php echo BASE_URL; ?>paginas/paseador/misPaseosPaseador.php" class="btn btn-primary mt-auto">Ir a Mis Paseos</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">👤 Mi Perfil</h5>
                    <p class="text-muted flex-grow-1">Editar datos personales, zona y disponibilidad.</p>
                    <a href="<?php echo BASE_URL; ?>paginas/paseador/perfilPaseador.php" class="btn btn-outline-primary mt-auto">Ir a Mi Perfil</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../componentes/footer.php'; ?>

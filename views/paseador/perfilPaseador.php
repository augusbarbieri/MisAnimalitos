<?php
require_once __DIR__ . '/../../php/config.php'; // Defines BASE_URL
include_once __DIR__ . '/../../componentes/header.php';
?>

<!-- Hero Paseador -->
<section class="hero text-center text-white bg-dark py-5 mt-3">
    <div class="container">
        <h1 class="display-4 fw-bold">Este es tu perfil (Paseador)</h1>
        <p class="lead">Gestioná tu información personal y disponibilidad 🐕</p>
    </div>
</section>
<!-- FIN Hero Paseador -->

<!-- Contenedor Perfil Paseador -->
<div class="perfil-container">
    <div class="perfil-card text-center bg-light p-4 rounded shadow">

        <!-- Foto de perfil -->
        <img src="<?php echo BASE_URL; ?>Assets/img/yo.jpeg" alt="Foto del paseador" class="rounded-circle border d-block mx-auto mb-3" width="200" height="200">

        <!-- Nombre -->
        <input type="text" class="form-control mb-3" placeholder="Nombre del paseador">

        <!-- Zona -->
        <input type="text" class="form-control mb-3" placeholder="Zona de trabajo (ej: Palermo)">

        <!-- Disponibilidad -->
        <select class="form-select mb-3">
            <option value="">Disponibilidad</option>
            <option value="manana">Mañana</option>
            <option value="tarde">Tarde</option>
            <option value="noche">Noche</option>
        </select>

        <!-- Botón logout -->
        <button class="btn btn-danger w-100" onclick="window.location.href='<?php echo BASE_URL; ?>php/logout.php'">
            Logout
        </button>
    </div>
</div>

<?php include_once __DIR__ . '/../../componentes/footer.php'; ?>

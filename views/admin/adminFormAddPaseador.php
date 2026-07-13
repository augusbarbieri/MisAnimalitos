<?php
require_once __DIR__ . '/../../php/config.php'; // Defines BASE_URL
include_once __DIR__ . '/../../componentes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Agregar Paseador</h2>
    <form id="formPaseador" action="<?php echo BASE_URL; ?>paginas/admin/formPaseadorComplete.php" method="post">
        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del paseador *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <!-- Apellido -->
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido del paseador</label>
            <input type="text" class="form-control" id="apellido" name="apellido">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email del paseador</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Telefono -->
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono del paseador</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" required>
        </div>

        <!-- Botón -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Agregar Paseador</button>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/../../componentes/footer.php'; ?>

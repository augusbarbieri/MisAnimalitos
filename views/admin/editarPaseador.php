<?php
require_once __DIR__ . '/../../php/config.php';
require_once __DIR__ . '/../../php/conexion.php';
require_once __DIR__ . '/../../php/paseadores.php';
include_once __DIR__ . '/../../componentes/header.php';

$id_paseador = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_paseador > 0) {
    $conn = conectarBDManadas();
    $paseador = obtenerPaseadorPorId($conn, $id_paseador);
    cerrarBDConexion($conn);

    if (!$paseador) {
        echo "<p>Paseador no encontrado.</p>";
        exit;
    }
} else {
    echo "<p>ID de paseador inválido.</p>";
    exit;
}
?>

<main class="container">
    <h2>Editar Paseador</h2>
    <form action="<?= BASE_URL ?>php/actualizarPaseador.php" method="post">
        <input type="hidden" name="id_paseador" value="<?= htmlspecialchars($paseador['id_paseador']) ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($paseador['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($paseador['apellido']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($paseador['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($paseador['telefono']) ?>">
        </div>
        <div class="mb-3">
            <label for="zona" class="form-label">Zona</label>
            <input type="text" class="form-control" id="zona" name="zona" value="<?= htmlspecialchars($paseador['zona']) ?>">
        </div>
        <div class="mb-3">
            <label for="disponibilidad" class="form-label">Disponibilidad</label>
            <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" value="<?= htmlspecialchars($paseador['disponibilidad']) ?>">
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option value="activo" <?= $paseador['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                <option value="inactivo" <?= $paseador['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="3"><?= htmlspecialchars($paseador['bio']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="adminPaseadores.php" class="btn btn-secondary">Cancelar</a>
    </form>
</main>

<?php include_once __DIR__ . '/../../componentes/footer.php'; ?>

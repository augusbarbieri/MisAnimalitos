<?php
require_once __DIR__ . '/../../php/config.php';
require_once __DIR__ . '/../../php/conexion.php';
require_once __DIR__ . '/../../php/usuarios.php';
include_once __DIR__ . '/../../componentes/header.php';

$id_usuario = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_usuario > 0) {
    $conn = conectarBDManadas();
    $cliente = obtenerUsuarioPorId($conn, $id_usuario);
    cerrarBDConexion($conn);

    if (!$cliente) {
        echo "<p>Cliente no encontrado.</p>";
        exit;
    }
} else {
    echo "<p>ID de cliente inválido.</p>";
    exit;
}
?>

<main class="container">
    <h2>Editar Cliente</h2>
    <form action="<?= BASE_URL ?>php/actualizarCliente.php" method="post">
        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($cliente['id_usuario']) ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($cliente['apellido']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($cliente['direccion']) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="adminClientes.php" class="btn btn-secondary">Cancelar</a>
    </form>
</main>

<?php include_once __DIR__ . '/../../componentes/footer.php'; ?>

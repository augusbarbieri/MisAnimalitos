<?php
require_once __DIR__ . '/../../php/config.php'; // Defines BASE_URL
require_once '../../php/conexion.php';
require_once '../../php/paseadores.php';
include_once '../../componentes/header.php';

$conn = conectarBDManadas();
$paseadores = obtenerPaseadores($conn);
cerrarBDConexion($conn);
?>

<main class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Paseadores</h2>
        <a href="adminFormAddPaseador.php" class="btn btn-primary">Agregar Paseador</a>
    </div>
    <div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($paseadores && $paseadores->num_rows > 0): ?>
                <?php while($row = $paseadores->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if ($row['estado'] == 'activo'): ?>
                                ✅
                            <?php else: ?>
                                ❌
                            <?php endif; ?>
                            <?= htmlspecialchars($row['id_paseador']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['apellido']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['telefono']) ?></td>
                        <td>
                            <a href="editarPaseador.php?id=<?= htmlspecialchars($row['id_paseador']) ?>" class="btn btn-primary btn-sm">Editar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay paseadores registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</main>

<?php include_once '../../componentes/footer.php'; ?>

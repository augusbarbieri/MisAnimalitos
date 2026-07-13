<?php
/**
 * =========================================================================
 * VISTA: views/admin/usuarios.php
 * =========================================================================
 * PROPÓSITO: Dibuja una tabla HTML con la lista de Dueños de Mascotas.
 * Recibe del Controlador un Array llamado $usuarios y usa un bucle 
 * "foreach" de PHP para dibujar un <tr> (fila) por cada usuario.
 * =========================================================================
 */
$tituloPagina = "Usuarios Registrados";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container" style="padding: 20px;">
    <h2>Listado de Dueños de Mascotas</h2>
    <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=inicio" style="display:inline-block; margin-bottom:15px;">&larr; Volver al Panel</a>
    
    <div class="table-container">
        <table class="table">
            <thead style="background-color: #f4f4f4;">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
                <!-- BUCLE FOREACH: Por cada "usuario" en el array $usuarios, llamaremos temporalmente a ese elemento "$u" -->
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <!-- Imprimimos las columnas de la base de datos de ESTE usuario ($u) -->
                    <td><?php echo $u['id_usuario']; ?></td>
                    <td><?php echo htmlspecialchars($u['nombre'] . ' ' . $u['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo htmlspecialchars($u['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($u['direccion']); ?></td>
                    <td><?php echo $u['fecha_registro']; ?></td>
                </tr>
                <?php endforeach; ?>
                
                <!-- Si el array está vacío (count == 0), mostramos un mensaje amigable -->
                <?php if(empty($usuarios)): ?>
                    <tr><td colspan="6" style="text-align:center;">No hay usuarios registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

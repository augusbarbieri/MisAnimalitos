<?php
/**
 * =========================================================================
 * VISTA: views/admin/paseadores.php
 * =========================================================================
 * PROPÓSITO: Similar a usuarios.php, pero dibuja la tabla de Paseadores.
 * Además, incluye el botón de "Nuevo Paseador" para abrir el formulario ABM.
 * =========================================================================
 */
$tituloPagina = "Gestión de Paseadores";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container" style="padding: 20px;">
    <h2>Listado de Paseadores (ABM)</h2>
    <div style="margin-bottom: 15px; display:flex; justify-content:space-between;">
        <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=inicio">&larr; Volver al Panel</a>
        <!-- Botón que redirige al Controlador apuntando a la acción 'nuevo_paseador' -->
        <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=nuevo_paseador" class="btn-login" style="padding: 5px 15px; text-decoration:none;">+ Nuevo Paseador</a>
    </div>

    <!-- Si en la URL viene ?msg=creado (puesto por el Controlador al guardar exitosamente), mostramos este aviso -->
    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'creado'): ?>
        <div style="color: green; margin-bottom: 15px;">Paseador creado con éxito.</div>
    <?php endif; ?>
    
    <div class="table-container">
        <table class="table">
            <thead style="background-color: #f4f4f4;">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Zona</th>
                    <th>Disponibilidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <!-- Iteramos sobre el array de $paseadores -->
                <?php foreach ($paseadores as $p): ?>
                <tr>
                    <td><?php echo $p['id_paseador']; ?></td>
                    <td><?php echo htmlspecialchars($p['nombre'] . ' ' . $p['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($p['email']); ?></td>
                    <td><?php echo htmlspecialchars($p['zona']); ?></td>
                    <td><?php echo htmlspecialchars($p['disponibilidad']); ?></td>
                    <td><?php echo htmlspecialchars($p['estado']); ?></td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($paseadores)): ?>
                    <tr><td colspan="6" style="text-align:center;">No hay paseadores registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

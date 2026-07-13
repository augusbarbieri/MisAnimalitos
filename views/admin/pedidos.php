<?php
/**
 * =========================================================================
 * VISTA: views/admin/pedidos.php
 * =========================================================================
 * PROPÓSITO: Dibuja la tabla más compleja de todo el sistema. Aquí se ve 
 * la información combinada de Paseos, Pagos, Mascotas y Paseadores.
 * Muestra el botón de "Confirmar Pago" para autorizar el servicio.
 * =========================================================================
 */
$tituloPagina = "Pedidos / Paseos";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container" style="padding: 20px;">
    <h2>Listado de Pedidos y Pagos</h2>
    <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=inicio" style="display:inline-block; margin-bottom:15px;">&larr; Volver al Panel</a>
    
    <div class="table-container">
        <table class="table">
            <thead style="background-color: #f4f4f4;">
                <tr>
                    <th>ID Paseo</th>
                    <th>Fecha/Hora</th>
                    <th>Mascota (Dueño)</th>
                    <th>Paseador Asignado</th>
                    <th>Tipo</th>
                    <th>Estado Pago</th>
                    <th>Estado Habilitación</th>
                    <th>Estado Paseo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $p): ?>
                <tr>
                    <td>#<?php echo $p['id_paseo']; ?></td>
                    <td><?php echo $p['fecha'] . ' ' . substr($p['hora_inicio'], 0, 5); ?></td>
                    <td><?php echo htmlspecialchars($p['mascota_nombre']) . ' (' . htmlspecialchars($p['dueno_nombre']) . ')'; ?></td>
                    <td><?php echo htmlspecialchars($p['paseador_nombre'] . ' ' . $p['paseador_apellido']); ?></td>
                    <td><?php echo ucfirst($p['tipo_paseo']); ?></td>
                    
                    <!-- Lógica Visual Ternaria (condición ? si_verdadero : si_falso) para poner el texto verde o naranja -->
                    <td style="font-weight:bold; color: <?php echo $p['estado_pago'] === 'confirmado' ? 'green' : 'orange'; ?>">
                        <?php echo strtoupper($p['estado_pago'] ?? 'Sin Pago'); ?>
                    </td>
                    
                    <td style="font-weight:bold; color: <?php echo $p['estado_habilitacion'] === 'habilitado_admin' ? 'blue' : 'gray'; ?>">
                        <?php echo ucfirst(str_replace('_', ' ', $p['estado_habilitacion'])); ?>
                    </td>
                    
                    <td><?php echo ucfirst(str_replace('_', ' ', $p['estado_paseo'])); ?></td>
                    
                    <td>
                        <!-- Si no ha pagado, mostramos el botón para que el Admin confirme el pago -->
                        <?php if ($p['estado_pago'] !== 'confirmado' && $p['id_pago']): ?>
                            <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=confirmar_pago&id_pago=<?php echo $p['id_pago']; ?>&id_paseo=<?php echo $p['id_paseo']; ?>" class="btn-login" style="padding:5px 10px; font-size:12px; text-decoration:none;">Confirmar Pago (Habilitar)</a>
                        
                        <!-- Si ya está habilitado, simplemente mostramos un check verde -->
                        <?php elseif($p['estado_habilitacion'] === 'habilitado_admin'): ?>
                            <span style="color:green;">&#10003; Habilitado</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($pedidos)): ?>
                    <tr><td colspan="9" style="text-align:center;">No hay pedidos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

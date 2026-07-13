<?php
/**
 * =========================================================================
 * VISTA: views/usuario/mis_paseos.php
 * =========================================================================
 * PROPÓSITO: Muestra el historial completo de paseos solicitados por el 
 * dueño. Esta tabla es crucial porque le dice si el admin ya le aprobó
 * el pago o si el paseador ya inició el servicio.
 * =========================================================================
 */
$tituloPagina = "Mis Reservas";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container" style="padding: 20px;">
    <h2>Mi Historial de Paseos</h2>
    <div style="margin-bottom: 15px; display:flex; justify-content:space-between;">
        <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=inicio">&larr; Volver al Panel</a>
        <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=pedir_paseo" class="btn-login" style="padding: 5px 15px; text-decoration:none;">+ Nuevo Paseo</a>
    </div>

    <!-- Si acaba de reservar un paseo (redirigido desde pedir_paseo), le mostramos un mensaje de confirmación -->
    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'solicitado'): ?>
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px;">
            ¡Tu paseo ha sido solicitado con éxito! El administrador debe confirmar el pago para habilitarlo.
        </div>
    <?php endif; ?>
    
    <div class="table-container">
        <table class="table">
            <thead style="background-color: #f4f4f4;">
                <tr>
                    <th>Fecha / Hora</th>
                    <th>Mascota</th>
                    <th>Paseador</th>
                    <th>Tipo</th>
                    <th>Estado del Pago</th>
                    <th>Estado de Habilitación</th>
                    <th>Estado del Paseo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paseos as $p): ?>
                <tr>
                    <!-- Combinamos Fecha y los primeros 5 caracteres de la Hora (HH:MM:SS -> HH:MM) -->
                    <td><?php echo $p['fecha'] . ' ' . substr($p['hora_inicio'], 0, 5); ?></td>
                    <td><?php echo htmlspecialchars($p['mascota_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($p['paseador_nombre'] . ' ' . $p['paseador_apellido']); ?></td>
                    <td><?php echo ucfirst($p['tipo_paseo']); ?></td>
                    
                    <!-- Lógica condicional (ternario) para el color de pago -->
                    <td style="font-weight:bold; color: <?php echo $p['estado_pago'] === 'confirmado' ? 'green' : 'orange'; ?>">
                        <?php echo strtoupper($p['estado_pago'] ?? 'Sin Pago'); ?>
                    </td>
                    
                    <!-- Lógica condicional para el color de habilitación -->
                    <td style="font-weight:bold; color: <?php echo $p['estado_habilitacion'] === 'habilitado_admin' ? 'blue' : 'gray'; ?>">
                        <?php echo ucfirst(str_replace('_', ' ', $p['estado_habilitacion'])); ?>
                    </td>
                    
                    <!-- Lógica condicional pesada con IFs completos para poner bonito el texto de Estado de Paseo -->
                    <td>
                        <?php if($p['estado_paseo'] === 'finalizado'): ?>
                            <span style="color:green; font-weight:bold;">Finalizado</span>
                        <?php elseif($p['estado_paseo'] === 'en_curso'): ?>
                            <span style="color:blue; font-weight:bold;">En Curso</span>
                        <?php else: ?>
                            <span style="color:gray;">Pendiente</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($paseos)): ?>
                    <tr><td colspan="7" style="text-align:center;">No has solicitado ningún paseo todavía.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

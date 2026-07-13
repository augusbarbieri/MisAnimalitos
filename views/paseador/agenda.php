<?php
/**
 * =========================================================================
 * VISTA: views/paseador/agenda.php
 * =========================================================================
 * PROPÓSITO: Muestra las tarjetas con los paseos asignados al paseador.
 * Incluye los botones interactivos para cambiar el estado en tiempo real 
 * (Comenzar -> Finalizar).
 * =========================================================================
 */
$tituloPagina = "Mi Agenda";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container" style="padding: 20px;">
    <h2>Mi Agenda de Paseos</h2>
    <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=inicio" style="display:inline-block; margin-bottom:15px;">&larr; Volver al Panel</a>

    <!-- Mensaje de éxito si acaba de apretar el botón de "Comenzar" o "Finalizar" -->
    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'estado_actualizado'): ?>
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px;">
            Estado del paseo actualizado correctamente.
        </div>
    <?php endif; ?>
    
    <div class="dashboard-cards" style="margin-top: 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));">
        
        <?php foreach ($paseos as $p): ?>
            <div class="clean-card" style="padding: 25px; text-align: left;">
                
                <!-- Cabecera de la Tarjeta: Fecha y Hora -->
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid var(--border-color); padding-bottom:15px; margin-bottom:15px;">
                    <span style="font-weight:600; color:var(--primary);">🗓️ <?php echo date('d/m/Y', strtotime($p['fecha'])); ?></span>
                    <span style="font-weight:700; background-color:var(--bg-color); padding:5px 12px; border-radius:var(--radius-pill); font-size:0.9rem; color:var(--text-dark);">⏰ <?php echo substr($p['hora_inicio'], 0, 5); ?></span>
                </div>
                
                <!-- Datos del Perro -->
                <h3 style="margin-top:0; color:var(--text-dark); font-size:1.4rem;">🐕 <?php echo htmlspecialchars($p['mascota_nombre']); ?> <span style="font-size:0.9rem; font-weight:normal; color:var(--text-muted);">(<?php echo htmlspecialchars($p['mascota_raza']); ?>)</span></h3>
                
                <!-- Datos del Dueño para que el paseador sepa a dónde ir -->
                <div style="font-size:0.95rem; color:var(--text-muted); margin-bottom:20px; line-height:1.6;">
                    <p style="margin:8px 0;"><strong>👤 Dueño:</strong> <?php echo htmlspecialchars($p['dueno_nombre'] . ' ' . $p['dueno_apellido']); ?></p>
                    <p style="margin:8px 0;"><strong>📍 Dir:</strong> <?php echo htmlspecialchars($p['dueno_direccion']); ?></p>
                    <p style="margin:8px 0;"><strong>📞 Tel:</strong> <?php echo htmlspecialchars($p['dueno_telefono']); ?></p>
                    
                    <!-- Si el perro muerde o tiene algo especial, lo mostramos en un cuadro de alerta amarilla -->
                    <?php if($p['mascota_observaciones']): ?>
                        <div style="margin-top:12px; color:#B45309; background-color:#FEF3C7; padding:10px 15px; border-radius:8px; border-left:4px solid #F59E0B; font-weight:500;">
                            ⚠️ <?php echo htmlspecialchars($p['mascota_observaciones']); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- LÓGICA DE BOTONES INTERACTIVOS -->
                <div style="text-align:center; padding-top:15px; border-top: 1px solid var(--border-color);">
                    
                    <!-- Si no ha empezado, botón azul de "Comenzar" -->
                    <?php if($p['estado_paseo'] === 'no_iniciado'): ?>
                        <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=cambiar_estado&estado=en_curso&id_paseo=<?php echo $p['id_paseo']; ?>" class="btn btn-primary" style="width:100%;">▶️ Comenzar Paseo</a>
                    
                    <!-- Si ya lo empezó, el botón se vuelve verde para "Finalizar" -->
                    <?php elseif($p['estado_paseo'] === 'en_curso'): ?>
                        <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=cambiar_estado&estado=finalizado&id_paseo=<?php echo $p['id_paseo']; ?>" class="btn" style="background: linear-gradient(135deg, var(--success) 0%, #059669 100%); color:white; width:100%;">✅ Finalizar Paseo</a>
                    
                    <!-- Si ya terminó, ya no hay botones, solo un cartel de éxito -->
                    <?php elseif($p['estado_paseo'] === 'finalizado'): ?>
                        <div style="color:var(--success); font-weight:bold; padding:10px 0; background:var(--success-bg); border-radius:var(--radius-md);">¡Paseo Completado! 🎉</div>
                    <?php endif; ?>
                    
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if(empty($paseos)): ?>
            <p style="width:100%; text-align:center; font-size:18px; color:#666; margin-top:50px;">No tienes paseos asignados por el momento. ¡Disfruta tu tiempo libre!</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

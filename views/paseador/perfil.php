<?php
/**
 * =========================================================================
 * VISTA: views/paseador/perfil.php
 * =========================================================================
 * PROPÓSITO: Muestra el perfil del paseador y le permite editar sus datos
 * de contacto y biografía de forma limpia y moderna.
 * =========================================================================
 */
$tituloPagina = "Mi Perfil de Paseador";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container" style="max-width: 800px; padding: 20px;">
    <h2>Mi Perfil de Paseador</h2>
    <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=inicio" style="display:inline-block; margin-bottom:20px;">&larr; Volver al Panel</a>

    <!-- Mensaje de éxito si acaba de actualizar el perfil -->
    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'perfil_actualizado'): ?>
        <div style="padding: 12px 20px; background-color: var(--success-bg); color: var(--success); border-radius: var(--radius-md); margin-bottom: 20px; border-left: 4px solid var(--success); font-weight: 500;">
            <i class="fas fa-check-circle"></i> Perfil actualizado correctamente.
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div style="padding: 12px 20px; background-color: var(--danger-bg); color: var(--danger); border-radius: var(--radius-md); margin-bottom: 20px; border-left: 4px solid var(--danger); font-weight: 500;">
            <i class="fas fa-exclamation-circle"></i> Hubo un error al guardar los cambios. Inténtalo de nuevo.
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr; gap: 30px;">
        
        <!-- Tarjeta de Información General y Estadísticas -->
        <div class="clean-card" style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 30px; position: relative;">
            <!-- Avatar del Paseador -->
            <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); display: flex; justify-content: center; align-items: center; margin-bottom: 15px; box-shadow: var(--shadow-md); border: 4px solid white; overflow: hidden;">
                <?php if (!empty($perfil['img'])): ?>
                    <img src="<?php echo BASE_URL . htmlspecialchars($perfil['img']); ?>" alt="Foto Perfil" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <i class="fas fa-user-tie" style="font-size: 3.5rem; color: white;"></i>
                <?php endif; ?>
            </div>

            <h3 style="margin-bottom: 5px; font-size: 1.8rem;"><?php echo htmlspecialchars($perfil['nombre'] . ' ' . $perfil['apellido']); ?></h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($perfil['email']); ?></p>

            <!-- Datos Fijos Clave (Antigüedad) -->
            <div style="display: flex; justify-content: center; width: 100%; border-top: 1px solid var(--border-color); padding-top: 20px; margin-top: 10px;">
                <div>
                    <span style="display: block; font-size: 0.85rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; letter-spacing: 0.05em;">Miembro desde</span>
                    <span style="font-size: 1.2rem; font-weight: 700; color: var(--text-dark); display: inline-block; margin-top: 6px;">
                        <?php echo !empty($perfil['fecha_alta']) ? date('d/m/Y', strtotime($perfil['fecha_alta'])) : '-'; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Edición de Datos -->
        <div class="form-card" style="padding: 30px;">
            <h3 style="border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 25px;"><i class="fas fa-user-edit"></i> Editar Mis Datos</h3>
            
            <form action="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=perfil" method="post">
                <div class="form-group">
                    <label for="telefono"><i class="fas fa-phone"></i> Teléfono de Contacto</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($perfil['telefono'] ?? ''); ?>" placeholder="Ej: 1135467890">
                </div>

                <div class="form-group">
                    <label for="zona"><i class="fas fa-map-marker-alt"></i> Zona de Paseo</label>
                    <input type="text" id="zona" name="zona" value="<?php echo htmlspecialchars($perfil['zona'] ?? ''); ?>" placeholder="Ej: Palermo, Belgrano, Recoleta...">
                </div>

                <div class="form-group">
                    <label for="disponibilidad"><i class="fas fa-clock"></i> Disponibilidad Horaria</label>
                    <select id="disponibilidad" name="disponibilidad" style="width: 100%;">
                        <option value="" <?php echo empty($perfil['disponibilidad']) ? 'selected' : ''; ?>>Seleccione una opción...</option>
                        <option value="manana" <?php echo ($perfil['disponibilidad'] === 'manana') ? 'selected' : ''; ?>>Mañana</option>
                        <option value="tarde" <?php echo ($perfil['disponibilidad'] === 'tarde') ? 'selected' : ''; ?>>Tarde</option>
                        <option value="noche" <?php echo ($perfil['disponibilidad'] === 'noche') ? 'selected' : ''; ?>>Noche</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="bio"><i class="fas fa-info-circle"></i> Sobre mí (Biografía corta)</label>
                    <textarea id="bio" name="bio" rows="4" placeholder="Cuéntales a los dueños sobre tu experiencia paseando perros..."><?php echo htmlspecialchars($perfil['bio'] ?? ''); ?></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                    <a href="<?php echo BASE_URL; ?>controllers/PaseadorController.php?action=inicio" class="btn btn-secondary" style="border-radius: var(--radius-pill); font-size: 0.95rem; padding: 10px 20px;">Cancelar</a>
                    <button type="submit" class="btn btn-primary" style="font-size: 0.95rem; padding: 10px 24px;">Guardar Cambios</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

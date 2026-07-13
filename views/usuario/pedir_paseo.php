<?php
/**
 * =========================================================================
 * VISTA: views/usuario/pedir_paseo.php
 * =========================================================================
 * PROPÓSITO: El formulario estrella del sistema. Permite a un dueño 
 * agendar un paseo. Cruza datos de las tablas Mascotas y Paseadores.
 * =========================================================================
 */
$tituloPagina = "Pedir Paseo";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="login-container" style="max-width: 600px; margin: 50px auto;">
    <div class="login-form-panel" style="width: 100%;">
        <div class="login-form-content">
            <h3>Contratar un Paseo</h3>
            <p class="subtitle">Elige a tu perro, tu paseador favorito y el horario</p>

            <?php if (isset($_GET['error'])): ?>
                <div style="color: red; margin-bottom: 10px;">Hubo un error al solicitar el paseo. Intenta de nuevo.</div>
            <?php endif; ?>

            <!-- LÓGICA DE NEGOCIO: No puedes pedir paseo si no tienes perros registrados -->
            <?php if(empty($mascotas)): ?>
                <div style="padding: 20px; background-color: #fff3cd; color: #856404; border-radius: 5px;">
                    Debes registrar al menos una mascota antes de poder pedir un paseo.
                    <br><br>
                    <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=nueva_mascota" class="btn-login" style="padding: 5px 15px; text-decoration:none; display:inline-block;">Agregar Mascota</a>
                </div>
            <?php else: ?>
                <!-- Si tiene perros, mostramos el formulario que envía los datos por POST -->
                <form action="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=pedir_paseo" method="post">
                    
                    <div class="form-group">
                        <label>¿A quién van a pasear?</label>
                        <!-- name="id_mascota" es vital: relaciona el paseo con ESTE perro en la BD -->
                        <select name="id_mascota" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                            <?php foreach($mascotas as $m): ?>
                                <!-- El 'value' es el ID numérico oculto, pero el usuario lee el texto (Nombre y Raza) -->
                                <option value="<?php echo $m['id_mascota']; ?>">🐕 <?php echo htmlspecialchars($m['nombre']); ?> (<?php echo htmlspecialchars($m['raza']); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Elige a tu paseador</label>
                        <select name="id_paseador" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                            <?php foreach($paseadores as $p): ?>
                                <option value="<?php echo $p['id_paseador']; ?>">
                                    🚶‍♂️ <?php echo htmlspecialchars($p['nombre'] . ' ' . $p['apellido']); ?> 
                                    (Zona: <?php echo htmlspecialchars($p['zona']); ?> - Turno: <?php echo htmlspecialchars($p['disponibilidad']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display:flex; gap:10px;">
                        <div class="form-group" style="flex:1;">
                            <label>Fecha</label>
                            <!-- Evitamos paseos en el pasado poniendo 'min' con la fecha de hoy usando PHP date() -->
                            <input type="date" name="fecha" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group" style="flex:1;">
                            <label>Hora de inicio</label>
                            <!-- El input type="time" fuerza al usuario a escribir HH:MM válido -->
                            <input type="time" name="hora_inicio" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tipo de Paseo</label>
                        <select name="tipo_paseo" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="individual">Paseo Individual (Exclusivo para tu perro)</option>
                            <option value="grupal">Paseo Grupal (Con otros perros)</option>
                        </select>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
                        <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=inicio">Cancelar</a>
                        <button type="submit" class="btn-login" style="width:auto; padding:10px 20px;">Confirmar Solicitud</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

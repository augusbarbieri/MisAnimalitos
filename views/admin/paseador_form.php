<?php
/**
 * =========================================================================
 * VISTA: views/admin/paseador_form.php
 * =========================================================================
 * PROPÓSITO: Es un formulario HTML para crear un nuevo paseador. 
 * Todos los <input> deben tener el atributo "name" correcto, ya que ese 
 * nombre es el que usará el Controlador para leerlos desde $_POST.
 * =========================================================================
 */
$tituloPagina = "Nuevo Paseador";
require_once __DIR__ . '/../partials/header.php';
?>

<!-- Reutilizamos el estilo "login-container" porque se ve bien para formularios centrados -->
<div class="login-container" style="max-width: 600px; margin: 50px auto;">
    <div class="login-form-panel" style="width: 100%;">
        <div class="login-form-content">
            <h3>Dar de alta un Paseador</h3>
            <p class="subtitle">Completa los datos del nuevo paseador fijo</p>

            <?php if (isset($_GET['error'])): ?>
                <div style="color: red; margin-bottom: 10px;">Error al crear el paseador. Verifique los datos.</div>
            <?php endif; ?>

            <!-- Al enviar (Submit), el navegador empaqueta todo y lo manda por POST a la acción 'crear_paseador' -->
            <form action="<?php echo BASE_URL; ?>controllers/AdminController.php?action=crear_paseador" method="post">
                <div style="display:flex; gap:10px;">
                    <div class="form-group" style="flex:1;">
                        <label>Nombre</label>
                        <input type="text" name="nombre" required> <!-- name="nombre" irá a $_POST['nombre'] -->
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Apellido</label>
                        <input type="text" name="apellido" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Contraseña (Temporal)</label>
                    <input type="text" name="password" required>
                </div>

                <div style="display:flex; gap:10px;">
                    <div class="form-group" style="flex:1;">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" required>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Zona</label>
                        <input type="text" name="zona" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Disponibilidad</label>
                    <select name="disponibilidad" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="manana">Mañana</option>
                        <option value="tarde">Tarde</option>
                        <option value="noche">Noche</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Biografía corta</label>
                    <!-- textareas se leen igual que los input: $_POST['bio'] -->
                    <textarea name="bio" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
                    <a href="<?php echo BASE_URL; ?>controllers/AdminController.php?action=paseadores">Cancelar</a>
                    <button type="submit" class="btn-login" style="width:auto; padding:10px 20px;">Crear Paseador</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

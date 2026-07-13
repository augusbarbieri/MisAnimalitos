<?php
/**
 * =========================================================================
 * VISTA: views/usuario/mascota_form.php
 * =========================================================================
 * PROPÓSITO: Formulario simple (ABM) para que el dueño registre un perrito.
 * =========================================================================
 */
$tituloPagina = "Agregar Mascota";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="login-container" style="max-width: 600px; margin: 50px auto;">
    <div class="login-form-panel" style="width: 100%;">
        <div class="login-form-content">
            <h3>Registrar un Perro</h3>
            <p class="subtitle">Añade los datos de tu mascota para pedir paseos</p>

            <?php if (isset($_GET['error'])): ?>
                <div style="color: red; margin-bottom: 10px;">Error al registrar mascota.</div>
            <?php endif; ?>

            <!-- action dirige hacia UsuarioController con la acción 'nueva_mascota'. 
                 Como es method="post", los datos no se verán en la URL -->
            <form action="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=nueva_mascota" method="post">
                <div class="form-group">
                    <label>Nombre del perro</label>
                    <input type="text" name="nombre" required>
                </div>

                <div style="display:flex; gap:10px;">
                    <div class="form-group" style="flex:1;">
                        <label>Raza</label>
                        <input type="text" name="raza" required>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Tamaño</label>
                        <!-- Selector desplegable (<select>) para forzar valores específicos y evitar errores tipográficos -->
                        <select name="tamano" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="chico">Chico</option>
                            <option value="mediano">Mediano</option>
                            <option value="grande">Grande</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Observaciones (Comportamiento, alergias, etc.)</label>
                    <textarea name="observaciones" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
                    <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=mascotas">Cancelar</a>
                    <button type="submit" class="btn-login" style="width:auto; padding:10px 20px;">Guardar Mascota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

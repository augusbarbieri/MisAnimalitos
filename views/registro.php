<?php
/**
 * =========================================================================
 * ARCHIVO: views/registro.php
 * =========================================================================
 * PROPÓSITO: Formulario de registro para nuevos clientes (dueños de mascotas).
 * (De baja complejidad, sin frameworks y utilizando estilos nativos).
 * =========================================================================
 */
$tituloPagina = "Crear Cuenta - Manadas";
$bodyClass = "login-page"; // Reusamos el fondo estético de la pantalla de login
require_once __DIR__ . '/partials/header.php';
?>

<div class="login-container">
    <!-- Panel Izquierdo: Decorativo con mensaje de bienvenida -->
    <div class="login-info-panel">
        <div class="login-info-content">
            <h2>Únete a nuestra manada hoy mismo.</h2>
            <p>Registra tu cuenta de dueño para comenzar a solicitar paseos para tus mejores amigos.</p>
        </div>
    </div>

    <!-- Panel Derecho: Formulario interactivo -->
    <div class="login-form-panel" style="padding: 20px 40px; overflow-y: auto;">
        <div class="login-form-content" style="max-width: 450px;">
            <div class="login-logo" style="margin-bottom: 5px; text-align: center;">
                <i class="fas fa-paw"></i>
            </div>
            <h3 style="margin-top: 0; text-align: center;">Crea tu Cuenta</h3>
            <p class="subtitle" style="text-align: center; margin-bottom: 20px; color: var(--text-muted);">Completá tus datos de contacto</p>

            <!-- Sistema de Errores capturados de la URL -->
            <?php if (isset($_GET['error'])): ?>
                <div style="color: var(--danger); background-color: var(--danger-bg); padding: 10px; border-radius: 8px; margin-bottom: 15px; font-weight: 500; font-size: 0.9em; border-left: 4px solid var(--danger);">
                    <?php 
                    if ($_GET['error'] === 'campos_vacios') echo "Por favor, completa todos los campos obligatorios.";
                    elseif ($_GET['error'] === 'email_existente') echo "El correo ingresado ya se encuentra registrado.";
                    elseif ($_GET['error'] === 'error_db') echo "Hubo un problema al guardar tus datos. Inténtalo de nuevo.";
                    else echo "Ha ocurrido un error.";
                    ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de envío por POST a AuthController.php -->
            <form action="<?php echo BASE_URL; ?>controllers/AuthController.php?action=register" method="POST">
                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label for="nombre" style="display: block; margin-bottom: 5px; font-weight: 500;">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-family: inherit;">
                    </div>
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label for="apellido" style="display: block; margin-bottom: 5px; font-weight: 500;">Apellido</label>
                        <input type="text" name="apellido" id="apellido" placeholder="Apellido" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-family: inherit;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Correo Electrónico</label>
                    <input type="email" name="email" id="email" placeholder="ejemplo@correo.com" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-family: inherit;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="password" style="display: block; margin-bottom: 5px; font-weight: 500;">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Ingresá una contraseña" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-family: inherit;">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="telefono" style="display: block; margin-bottom: 5px; font-weight: 500;">Teléfono de Contacto</label>
                    <input type="tel" name="telefono" id="telefono" placeholder="Ej: 1135975802" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-family: inherit;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="direccion" style="display: block; margin-bottom: 5px; font-weight: 500;">Dirección Residencial</label>
                    <input type="text" name="direccion" id="direccion" placeholder="Ej: Av. Rivadavia 1234" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-family: inherit;">
                </div>

                <button type="submit" class="btn-login" style="width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: var(--radius-sm); font-size: 1rem; font-weight: 600; cursor: pointer; transition: var(--transition); font-family: inherit;">Registrarme</button>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.95rem; color: var(--text-muted);">
                ¿Ya tenés cuenta? <a href="login.php" style="color: var(--primary); font-weight: 600; text-decoration: none;">Iniciar sesión</a>
            </p>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/partials/footer.php';
?>

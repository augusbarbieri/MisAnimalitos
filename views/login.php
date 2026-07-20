<?php
/**
 * =========================================================================
 * ARCHIVO: views/login.php
 * =========================================================================
 * PROPÓSITO: Es la interfaz visual donde los usuarios escriben sus credenciales.
 * No procesa lógica, solo envía la información al AuthController.
 * =========================================================================
 */

// 1. Definimos variables que leerá el header.php
$tituloPagina = "Iniciar Sesión - Manadas";
$bodyClass = "login-page"; // Le decimos al CSS que le ponga la foto de fondo perrito

// 2. Traemos la cabecera (esto dibuja todo el <head> y el fondo)
require_once __DIR__ . '/partials/header.php';
?>

    <div class="login-container">
        <!-- Panel Izquierdo: Solo texto decorativo con imagen de fondo -->
        <div class="login-info-panel">
            <div class="login-info-content">
                <h2>Conectando dueños y paseadores de mascotas.</h2>
                <p>Encuentra el paseador perfecto para tu mejor amigo.</p>
            </div>
        </div>

        <!-- Panel Derecho: El formulario interactivo -->
        <div class="login-form-panel">
            <div class="login-form-content">
                <div class="login-logo">
                    <i class="fas fa-paw"></i>
                </div>
                <h3>Inicia Sesión en tu Cuenta</h3>
                <p class="subtitle">Bienvenido de nuevo</p>

                <!-- 
                SISTEMA DE ERRORES:
                Si el AuthController detecta que la contraseña es mala, 
                redirige a "login.php?error=credenciales_invalidas".
                Aquí capturamos ese "?error" de la URL y mostramos un texto rojo.
                -->
                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'registrado'): ?>
                    <div style="color: var(--success); background-color: var(--success-bg); padding: 10px; border-radius: 8px; margin-bottom: 15px; font-weight: 500; border-left: 4px solid var(--success); font-size: 0.9em;">
                        ¡Registro exitoso! Ya puedes iniciar sesión con tu cuenta.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div style="color: var(--danger); background-color: var(--danger-bg); padding: 10px; border-radius: 8px; margin-bottom: 15px; font-weight: 500; border-left: 4px solid var(--danger); font-size: 0.9em;">
                        <?php 
                        if ($_GET['error'] === 'campos_vacios') echo "Por favor, complete todos los campos.";
                        elseif ($_GET['error'] === 'credenciales_invalidas') echo "Email o contraseña incorrectos.";
                        else echo "Ha ocurrido un error.";
                        ?>
                    </div>
                <?php endif; ?>

                <!-- 
                EL FORMULARIO:
                Al apretar Submit, agarra todo lo que esté en los <input> 
                y lo envía por POST a la URL de AuthController.php 
                -->
                <form action="<?php echo BASE_URL; ?>controllers/AuthController.php?action=login" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <!-- 'name="email"' es como lo va a leer PHP en $_POST['email'] -->
                        <input type="email" name="email" id="email" placeholder="Ingresá tu email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" placeholder="Ingresá tu contraseña" required>
                    </div>

                    <button type="submit" class="btn-login">Ingresar</button>
                </form>

                <p style="text-align: center; margin-top: 20px; font-size: 0.95rem; color: var(--text-muted);">
                    ¿Aún no tienes cuenta? <a href="registro.php" style="color: var(--primary); font-weight: 600; text-decoration: none;">Crea una cuenta</a>
                </p>
            </div>
        </div>
    </div>

<?php
// 3. Cerramos las etiquetas HTML trayendo el footer
require_once __DIR__ . '/partials/footer.php';
?>

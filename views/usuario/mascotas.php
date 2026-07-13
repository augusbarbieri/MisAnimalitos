<?php
/**
 * =========================================================================
 * VISTA: views/usuario/mascotas.php
 * =========================================================================
 * PROPÓSITO: Muestra la lista de mascotas registradas por este dueño.
 * A diferencia del administrador (que usa tablas aburridas), aquí lo 
 * mostramos como "tarjetas de perfil" de cada perro para que se vea lindo.
 * =========================================================================
 */
$tituloPagina = "Mis Mascotas";
require_once __DIR__ . '/../partials/header.php';
?>

<div class="container" style="padding: 20px;">
    <h2>Mis Mascotas</h2>
    <div style="margin-bottom: 15px; display:flex; justify-content:space-between;">
        <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=inicio">&larr; Volver al Panel</a>
        <a href="<?php echo BASE_URL; ?>controllers/UsuarioController.php?action=nueva_mascota" class="btn-login" style="padding: 5px 15px; text-decoration:none;">+ Agregar Mascota</a>
    </div>

    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'creada'): ?>
        <div style="color: green; margin-bottom: 15px;">Mascota registrada con éxito.</div>
    <?php endif; ?>
    
    <!-- flex-wrap: wrap; permite que si hay muchos perros, salten a la línea de abajo en vez de amontonarse -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <!-- Iteramos por cada mascota que nos pasó el UsuarioController -->
        <?php foreach ($mascotas as $m): ?>
            <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; width: 250px; background-color: #f9f9f9;">
                <h3 style="margin-top:0; color:#4a2b8e;">🐕 <?php echo htmlspecialchars($m['nombre']); ?></h3>
                <p><strong>Raza:</strong> <?php echo htmlspecialchars($m['raza']); ?></p>
                <!-- ucfirst() capitaliza la primera letra (ej: 'grande' -> 'Grande') -->
                <p><strong>Tamaño:</strong> <?php echo ucfirst(htmlspecialchars($m['tamano'])); ?></p>
            </div>
        <?php endforeach; ?>
        
        <?php if(empty($mascotas)): ?>
            <p>Aún no has registrado ninguna mascota. ¡Agrega una para poder pedir paseos!</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>

<?php
require_once __DIR__ . '/../../php/config.php';
require_once __DIR__ . '/../../php/conexion.php';
require_once __DIR__ . '/../../php/paseadores.php';
include_once __DIR__ . '/../../componentes/header.php';

$mensaje = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';

    $conn = conectarBDManadas();
    if (agregarPaseador($conn, $nombre, $apellido, $email, $telefono)) {
        $mensaje = "Paseador agregado con éxito.";
    } else {
        $mensaje = "Error al agregar el paseador.";
    }
    $conn->close();
}
?>

<!-- Hero-->
<section class="hero">
    <h1 class="display-4 fw-bold">Estado del Registro</h1>
</section>
<div class="container mt-5">
    <div class="alert <?php echo ($mensaje === "Paseador agregado con éxito.") ? 'alert-success' : 'alert-danger'; ?>" role="alert">
        <?php echo $mensaje; ?>
    </div>
    <div class="d-grid">
        <a href="<?php echo BASE_URL; ?>paginas/admin/landingAdmin.php" class="btn btn-primary">Volver</a>
    </div>
</div>

<?php include_once __DIR__ . '/../../componentes/footer.php'; ?>

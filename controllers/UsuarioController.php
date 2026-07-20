<?php
/**
 * =========================================================================
 * ARCHIVO: controllers/UsuarioController.php
 * =========================================================================
 * PROPÓSITO: El "Gerente" de los Clientes (Dueños de Mascotas).
 * Maneja las acciones como registrar nuevas mascotas o solicitar paseos.
 * =========================================================================
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/sesion.php';
require_once __DIR__ . '/../models/UsuarioModel.php';

// 1. SEGURIDAD: Solo 'usuarios' logueados
require_login();
if (get_user_role() !== 'usuario') {
    die("Acceso denegado. Solo dueños de mascotas.");
}

$action = $_GET['action'] ?? 'inicio';

// Obtenemos el ID del dueño que está navegando (desde la sesión)
$id_dueno = $_SESSION['user_id'];

switch ($action) {
    // CASO: Pantalla inicial (Dashboard del Dueño)
    case 'inicio':
        require_once __DIR__ . '/../views/usuario/inicio.php';
        break;

    // CASO: Ver lista de mascotas
    case 'mascotas':
        $mascotas = getMascotas($id_dueno);
        require_once __DIR__ . '/../views/usuario/mascotas.php';
        break;

    // CASO DUAL: Agregar nueva mascota
    // Esto es un patrón clásico en MVC. La misma URL hace 2 cosas:
    // 1. Si entras normalmente (GET), te muestra el formulario vacío.
    // 2. Si entras enviando datos (POST), guarda la mascota en la BD.
    case 'nueva_mascota':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Acción POST: El usuario apretó "Guardar" en el formulario
            $data = [
                'id_dueno' => $id_dueno,
                'nombre' => $_POST['nombre'] ?? '',
                'raza' => $_POST['raza'] ?? '',
                'tamano' => $_POST['tamano'] ?? 'mediano',
                'observaciones' => $_POST['observaciones'] ?? ''
            ];
            
            if (crearMascota($data)) {
                // Si guardó, redireccionar a la lista de mascotas
                header("Location: " . BASE_URL . "controllers/UsuarioController.php?action=mascotas&msg=creada");
            } else {
                header("Location: " . BASE_URL . "controllers/UsuarioController.php?action=nueva_mascota&error=1");
            }
            exit();
        } else {
            // Acción GET: El usuario simplemente hizo clic en "Nueva Mascota"
            require_once __DIR__ . '/../views/usuario/mascota_form.php';
        }
        break;

    // CASO DUAL: Solicitar un nuevo paseo
    case 'pedir_paseo':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Acción POST: Formulario enviado
            $data = [
                'id_mascota' => (int)($_POST['id_mascota'] ?? 0),
                'id_paseador' => (int)($_POST['id_paseador'] ?? 0),
                'fecha' => $_POST['fecha'] ?? '',
                'hora_inicio' => $_POST['hora_inicio'] ?? '',
                'tipo_paseo' => $_POST['tipo_paseo'] ?? 'individual'
            ];
            
            // Llama al modelo para guardar la solicitud (creará Paseo y Pago)
            if (solicitarPaseo($data)) {
                header("Location: " . BASE_URL . "controllers/UsuarioController.php?action=mis_paseos&msg=solicitado");
            } else {
                header("Location: " . BASE_URL . "controllers/UsuarioController.php?action=pedir_paseo&error=1");
            }
            exit();
        } else {
            // Acción GET: Cargar el formulario
            // Necesitamos pasarle al formulario qué mascotas tiene y qué paseadores existen
            $mascotas = getMascotas($id_dueno);
            $paseadores = getPaseadoresActivos();
            require_once __DIR__ . '/../views/usuario/pedir_paseo.php';
        }
        break;

    // CASO: Ver el historial de paseos
    case 'mis_paseos':
        $paseos = getMisPaseos($id_dueno);
        require_once __DIR__ . '/../views/usuario/mis_paseos.php';
        break;

    default:
        require_once __DIR__ . '/../views/usuario/inicio.php';
        break;
}
?>

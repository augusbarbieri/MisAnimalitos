<?php
/**
 * =========================================================================
 * ARCHIVO: controllers/PaseadorController.php
 * =========================================================================
 * PROPÓSITO: El "Gerente" exclusivo para los empleados (Paseadores).
 * Aquí se maneja todo lo que el paseador puede hacer, como ver su agenda 
 * y marcar cuándo empieza o termina un paseo.
 * =========================================================================
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/sesion.php';
require_once __DIR__ . '/../models/PaseadorModel.php';

// 1. SEGURIDAD: Solo usuarios logueados que además sean 'paseador'
require_login();
if (get_user_role() !== 'paseador') {
    die("Acceso denegado. Solo paseadores autorizados.");
}

$action = $_GET['action'] ?? 'inicio';

// Obtenemos el ID del paseador que está navegando (desde la sesión)
$id_paseador = $_SESSION['user_id'];

switch ($action) {
    // CASO: Pantalla inicial (Dashboard del Paseador)
    case 'inicio':
        $paseos = getMiAgenda($id_paseador);
        $totalPaseos = count($paseos);
        $pendientes = 0;
        $en_curso = 0;
        foreach ($paseos as $p) {
            if ($p['estado_paseo'] === 'no_iniciado') {
                $pendientes++;
            } elseif ($p['estado_paseo'] === 'en_curso') {
                $en_curso++;
            }
        }
        $perfil = getPaseadorPerfil($id_paseador);
        require_once __DIR__ . '/../views/paseador/inicio.php';
        break;

    // CASO: Ver y editar perfil del paseador
    case 'perfil':
        $perfil = getPaseadorPerfil($id_paseador);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'telefono' => trim($_POST['telefono'] ?? ''),
                'zona' => trim($_POST['zona'] ?? ''),
                'disponibilidad' => !empty($_POST['disponibilidad']) ? $_POST['disponibilidad'] : null,
                'bio' => trim($_POST['bio'] ?? '')
            ];
            
            if (actualizarPaseadorPerfil($id_paseador, $data)) {
                // Actualizar el nombre/imagen en la sesión por si cambiara (aunque en este caso no lo cambiamos, pero es buena práctica)
                header("Location: " . BASE_URL . "controllers/PaseadorController.php?action=perfil&msg=perfil_actualizado");
            } else {
                header("Location: " . BASE_URL . "controllers/PaseadorController.php?action=perfil&error=1");
            }
            exit();
        }
        
        require_once __DIR__ . '/../views/paseador/perfil.php';
        break;

    // CASO: Ver los paseos que tiene asignados
    case 'agenda':
        // Le pedimos al modelo solo los paseos de ESTE paseador en particular
        $paseos = getMiAgenda($id_paseador);
        require_once __DIR__ . '/../views/paseador/agenda.php';
        break;

    // CASO: El paseador presiona "Comenzar Paseo" o "Finalizar Paseo"
    case 'cambiar_estado':
        $id_paseo = (int)($_GET['id_paseo'] ?? 0);
        $nuevo_estado = $_GET['estado'] ?? ''; // 'en_curso' o 'finalizado'
        
        // 1. Validar que no nos inyecten estados falsos por URL
        if (in_array($nuevo_estado, ['en_curso', 'finalizado'])) {
            
            // 2. Le pedimos al modelo que haga el UPDATE en la Base de Datos
            if (actualizarEstadoPaseo($id_paseo, $id_paseador, $nuevo_estado)) {
                // Si funcionó, recargamos la agenda mostrando un mensaje verde de éxito
                header("Location: " . BASE_URL . "controllers/PaseadorController.php?action=agenda&msg=estado_actualizado");
                exit();
            }
        }
        
        // Si falló o el estado era inválido, mostramos error
        header("Location: " . BASE_URL . "controllers/PaseadorController.php?action=agenda&error=1");
        break;

    // CASO POR DEFECTO
    default:
        require_once __DIR__ . '/../views/paseador/inicio.php';
        break;
}
?>

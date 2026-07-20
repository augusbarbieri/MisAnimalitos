<?php
/**
 * =========================================================================
 * ARCHIVO: controllers/AdminController.php
 * =========================================================================
 * PROPÓSITO: Es el "Gerente" de la sección del Administrador.
 * Recibe las peticiones del usuario (ej: "quiero ver los paseadores"), 
 * le pide los datos al Modelo (AdminModel), y luego carga la Vista correcta
 * para mostrar esos datos.
 * =========================================================================
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/sesion.php';
require_once __DIR__ . '/../models/AdminModel.php';

// 1. SEGURIDAD: Comprobamos que el usuario haya iniciado sesión
require_login();

// 2. SEGURIDAD ADICIONAL: Comprobamos que su rol sea estrictamente 'admin'
if (get_user_role() !== 'admin') {
    die("Acceso denegado. Solo administradores.");
}

// 3. ENRUTADOR (Router)
// Leemos qué acción quiere hacer el admin desde la URL (?action=...)
// Si no hay acción en la URL, asumimos que quiere ir al 'inicio' (Dashboard)
$action = $_GET['action'] ?? 'inicio';

// 4. EL CEREBRO DEL CONTROLADOR (Switch)
// Dependiendo de la acción, hacemos una cosa u otra
switch ($action) {
    
    // CASO: Cargar el Dashboard principal
    case 'inicio':
        // Pedimos datos estadísticos al modelo usando count()
        $totalUsuarios = count(getUsuarios());
        $totalPaseadores = count(getPaseadores());
        $pedidos = getPedidos();
        $totalPedidos = count($pedidos);
        $pendientes = 0;
        
        // Contamos cuántos pedidos no están finalizados
        foreach($pedidos as $p) {
            if($p['estado_paseo'] !== 'finalizado') $pendientes++;
        }
        
        // Cargamos el archivo visual (HTML/PHP) pasándole todas estas variables
        require_once __DIR__ . '/../views/admin/inicio.php';
        break;

    // CASO: Ver lista de usuarios dueños de mascotas
    case 'usuarios':
        // 1. Pedimos los usuarios al modelo
        $usuarios = getUsuarios();
        // 2. Cargamos la vista que dibuja la tabla
        require_once __DIR__ . '/../views/admin/usuarios.php';
        break;

    // CASO: Ver lista de paseadores
    case 'paseadores':
        $paseadores = getPaseadores();
        require_once __DIR__ . '/../views/admin/paseadores.php';
        break;

    // CASO: Procesar el formulario de creación de un nuevo paseador
    case 'crear_paseador':
        // Si el formulario fue enviado usando POST...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recolectamos los datos (y si algo falta, ponemos un texto vacío '')
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'apellido' => $_POST['apellido'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'zona' => $_POST['zona'] ?? '',
                'disponibilidad' => $_POST['disponibilidad'] ?? '',
                'bio' => $_POST['bio'] ?? ''
            ];
            
            // Le pasamos el paquete de datos al modelo para que lo inserte
            if (crearPaseador($data)) {
                // Si fue exitoso, redireccionamos a la lista de paseadores
                header("Location: " . BASE_URL . "controllers/AdminController.php?action=paseadores&msg=creado");
            } else {
                // Si falló, lo devolvemos al formulario con un mensaje de error
                header("Location: " . BASE_URL . "controllers/AdminController.php?action=nuevo_paseador&error=1");
            }
            exit(); // Matamos el script después de un header (buena práctica)
        }
        break;
        
    // CASO: Mostrar la pantalla (formulario HTML) para crear paseador
    case 'nuevo_paseador':
        require_once __DIR__ . '/../views/admin/paseador_form.php';
        break;

    // CASO: Ver todos los pedidos y paseos del sistema
    case 'pedidos':
        $pedidos = getPedidos();
        require_once __DIR__ . '/../views/admin/pedidos.php';
        break;

    // CASO: Acción del admin cuando presiona el botón "Confirmar Pago"
    case 'confirmar_pago':
        $id_pago = (int)($_GET['id_pago'] ?? 0);
        $id_paseo = (int)($_GET['id_paseo'] ?? 0);
        
        // Si nos llegaron los dos IDs correctamente
        if ($id_pago && $id_paseo) {
            // Le ordenamos al modelo que modifique el estado en la base de datos
            confirmarPago($id_pago, $id_paseo);
        }
        
        // Volvemos a la lista de pedidos para ver el cambio reflejado
        header("Location: " . BASE_URL . "controllers/AdminController.php?action=pedidos");
        exit();

    // CASO POR DEFECTO: Si alguien escribe cualquier verdura en la URL
    default:
        require_once __DIR__ . '/../views/admin/inicio.php';
        break;
}
?>

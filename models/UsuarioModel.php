<?php
/**
 * =========================================================================
 * ARCHIVO: models/UsuarioModel.php
 * =========================================================================
 * PROPÓSITO: El Músculo de los Clientes. 
 * Contiene todas las consultas SQL que los dueños de mascotas necesitan.
 * =========================================================================
 */

require_once __DIR__ . '/../config/conexion.php';

class UsuarioModel {
    private $conn;

    public function __construct() {
        $this->conn = conectarBDManadas();
        if (!$this->conn) {
            die("Error de conexión a la base de datos.");
        }
    }

    /**
     * Trae la lista de mascotas que le pertenecen a este dueño específico.
     */
    public function getMascotas($id_dueno) {
        $sql = "SELECT id_mascota, nombre, raza, tamano, observaciones FROM mascota WHERE id_dueno = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_dueno);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Registra un nuevo perrito en la base de datos.
     */
    public function crearMascota($data) {
        $sql = "INSERT INTO mascota (id_dueno, nombre, raza, tamano, observaciones, creada_en, img) 
                VALUES (?, ?, ?, ?, ?, CURDATE(), '')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issss", 
            $data['id_dueno'], $data['nombre'], $data['raza'], 
            $data['tamano'], $data['observaciones']
        );
        return $stmt->execute();
    }

    /**
     * Trae todos los paseadores que tengan la cuenta "activa" para mostrarlos en el select.
     */
    public function getPaseadoresActivos() {
        $sql = "SELECT id_paseador, nombre, apellido, zona, disponibilidad, rating FROM paseador WHERE estado = 'activo'";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * ¡OTRA PREGUNTA DE EXAMEN! Lógica de Solicitud de Paseo.
     * Usamos una "Transacción" porque al pedir un paseo, el sistema TIENE que crear:
     * 1. El registro del Paseo.
     * 2. La Factura a pagar (Pago) atada a ese paseo.
     * Si alguna falla, no creamos ninguna de las dos.
     */
    public function solicitarPaseo($data) {
        $this->conn->begin_transaction(); // Pausamos la BD
        try {
            // ACCIÓN 1: Crear el Paseo
            $sqlPaseo = "INSERT INTO paseo (id_mascota, id_paseador, fecha, hora_inicio, hora_fin, zona, precio, estado_paseo, tipo_paseo, estado_habilitacion) 
                         VALUES (?, ?, ?, ?, ?, 'Por definir', 0, 'no_iniciado', ?, 'pendiente_pago')";
            $stmt1 = $this->conn->prepare($sqlPaseo);
            
            // Calculamos automáticamente que el paseo dura 1 hora exacta (usando la función strtotime nativa de PHP)
            $hora_fin = date('H:i', strtotime($data['hora_inicio'] . ' + 1 hour'));
            
            $stmt1->bind_param("iissss", 
                $data['id_mascota'], $data['id_paseador'], $data['fecha'], 
                $data['hora_inicio'], $hora_fin, $data['tipo_paseo']
            );
            $stmt1->execute();
            
            // Obtenemos el ID Autonumérico que MySQL le acaba de asignar al paseo que insertamos arriba
            $id_paseo = $this->conn->insert_id;

            // ACCIÓN 2: Crear la factura (Pago) pendiente usando el ID del paseo anterior
            $sqlPago = "INSERT INTO pago (id_paseo, monto, fecha_pago, estado_pago) VALUES (?, 0, CURDATE(), 'pendiente')";
            $stmt2 = $this->conn->prepare($sqlPago);
            $stmt2->bind_param("i", $id_paseo); // Pasamos el ID del paseo
            $stmt2->execute();

            $this->conn->commit(); // Todo OK, Guardamos permanentemente.
            return true;
        } catch (Exception $e) {
            $this->conn->rollback(); // Falla catastrófica, deshacemos todo.
            return false;
        }
    }

    /**
     * Trae el historial de todos los paseos que este dueño ha pedido alguna vez.
     */
    public function getMisPaseos($id_dueno) {
        $sql = "SELECT 
                    pa.id_paseo, pa.fecha, pa.hora_inicio, pa.tipo_paseo, pa.estado_paseo, pa.estado_habilitacion,
                    pg.estado_pago,
                    m.nombre as mascota_nombre,
                    pas.nombre as paseador_nombre, pas.apellido as paseador_apellido
                FROM paseo pa
                INNER JOIN mascota m ON pa.id_mascota = m.id_mascota
                LEFT JOIN pago pg ON pa.id_paseo = pg.id_paseo
                LEFT JOIN paseador pas ON pa.id_paseador = pas.id_paseador
                WHERE m.id_dueno = ?
                ORDER BY pa.fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_dueno);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function cerrarConexion() {
        cerrarBDConexion($this->conn);
    }
}

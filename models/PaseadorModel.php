<?php
/**
 * =========================================================================
 * ARCHIVO: models/PaseadorModel.php
 * =========================================================================
 * PROPÓSITO: El Músculo de los Paseadores. 
 * Contiene todas las consultas SQL que los empleados necesitan hacer.
 * =========================================================================
 */

require_once __DIR__ . '/../config/conexion.php';

class PaseadorModel {
    private $conn;

    public function __construct() {
        $this->conn = conectarBDManadas();
        if (!$this->conn) {
            die("Error de conexión a la base de datos.");
        }
    }

    /**
     * Obtiene todos los paseos asignados a este paseador que el Admin ya aprobó.
     * Combina 3 tablas: Paseos + Mascotas + Usuarios (Dueños).
     */
    public function getMiAgenda($id_paseador) {
        // INNER JOIN es más estricto que LEFT JOIN.
        // Significa: "Traeme el paseo SOLO SI tiene una mascota y un dueño válidos".
        $sql = "SELECT 
                    pa.id_paseo, pa.fecha, pa.hora_inicio, pa.hora_fin, pa.tipo_paseo, pa.estado_paseo,
                    m.nombre as mascota_nombre, m.raza as mascota_raza, m.observaciones as mascota_observaciones,
                    u.nombre as dueno_nombre, u.apellido as dueno_apellido, u.telefono as dueno_telefono, u.direccion as dueno_direccion
                FROM paseo pa
                INNER JOIN mascota m ON pa.id_mascota = m.id_mascota
                INNER JOIN usuarios u ON m.id_dueno = u.id_usuario
                WHERE pa.id_paseador = ? AND pa.estado_habilitacion = 'habilitado_admin'
                ORDER BY pa.fecha ASC, pa.hora_inicio ASC"; // Orden cronológico, los más próximos primero
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_paseador);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Cambia el estado del paseo (ej: de "no_iniciado" a "en_curso").
     */
    public function actualizarEstadoPaseo($id_paseo, $id_paseador, $nuevo_estado) {
        // SEGURIDAD: Añadimos "AND id_paseador = ?" en el WHERE.
        // Esto evita que un paseador malicioso intente finalizar el paseo de OTRO paseador.
        $sql = "UPDATE paseo SET estado_paseo = ? WHERE id_paseo = ? AND id_paseador = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $nuevo_estado, $id_paseo, $id_paseador); // (String, Integer, Integer)
        return $stmt->execute();
    }

    public function cerrarConexion() {
        cerrarBDConexion($this->conn);
    }
}

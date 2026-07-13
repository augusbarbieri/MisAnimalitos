<?php
/**
 * =========================================================================
 * ARCHIVO: models/AdminModel.php
 * =========================================================================
 * PROPÓSITO: Es el "Músculo" del Administrador.
 * Contiene absolutamente todas las consultas SQL (SELECT, INSERT, UPDATE) 
 * que el Administrador necesita para interactuar con la Base de Datos.
 * El Controlador NUNCA escribe SQL, siempre le pide ayuda a este Modelo.
 * =========================================================================
 */

require_once __DIR__ . '/../config/conexion.php';

class AdminModel {
    private $conn; // Variable interna para guardar el "túnel" a la BD

    // CONSTRUCTOR: Se ejecuta automáticamente cada vez que alguien hace `new AdminModel()`
    public function __construct() {
        $this->conn = conectarBDManadas(); // Abre el túnel
        if (!$this->conn) {
            die("Error de conexión a la base de datos.");
        }
    }

    /**
     * Obtiene TODOS los dueños de mascotas.
     */
    public function getUsuarios() {
        $sql = "SELECT id_usuario, nombre, apellido, email, telefono, direccion, fecha_registro, img FROM usuarios";
        // ->query() se usa cuando no hay variables externas en el SQL (es seguro)
        $result = $this->conn->query($sql);
        // MYSQLI_ASSOC convierte la respuesta cruda de MySQL en un Array Asociativo de PHP (muy fácil de leer)
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Obtiene TODOS los paseadores.
     */
    public function getPaseadores() {
        $sql = "SELECT id_paseador, nombre, apellido, email, telefono, zona, disponibilidad, estado, rating, fecha_alta FROM paseador";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Obtiene TODOS los Pedidos combinando 4 tablas distintas usando JOIN.
     * Esto es código avanzado de BD. Un pedido involucra: Paseo + Pago + Mascota + Paseador.
     */
    public function getPedidos() {
        // LEFT JOIN junta tablas. "Traeme el Paseo (pa), y pégale al lado su Pago (pg) correspondiente,
        // su Mascota (m) correspondiente, el Dueño (u) de esa mascota, y el Paseador (pas) asignado."
        $sql = "SELECT 
                    pa.id_paseo, pa.fecha, pa.hora_inicio, pa.hora_fin, pa.zona, pa.tipo_paseo, pa.estado_paseo, pa.estado_habilitacion, pa.precio,
                    pg.id_pago, pg.monto, pg.estado_pago,
                    m.nombre as mascota_nombre,
                    u.nombre as dueno_nombre, u.apellido as dueno_apellido,
                    pas.nombre as paseador_nombre, pas.apellido as paseador_apellido
                FROM paseo pa
                LEFT JOIN pago pg ON pa.id_paseo = pg.id_paseo
                LEFT JOIN mascota m ON pa.id_mascota = m.id_mascota
                LEFT JOIN usuarios u ON m.id_dueno = u.id_usuario
                LEFT JOIN paseador pas ON pa.id_paseador = pas.id_paseador
                ORDER BY pa.fecha DESC"; // Los más nuevos primero
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * ¡PREGUNTA DE EXAMEN! Uso de "Transacciones SQL" (begin_transaction)
     * Cuando queremos hacer 2 o más cambios en la BD que están obligatoriamente atados, 
     * usamos Transacciones. Si uno falla, TODO se cancela (rollback).
     */
    public function confirmarPago($id_pago, $id_paseo) {
        $this->conn->begin_transaction(); // Ponemos a MySQL en modo "Pausa, no guardes nada hasta que yo avise"
        try {
            // ACCIÓN 1: Actualizamos la tabla 'pago'
            // Usamos "?" (Prepared Statements) para evitar Inyección SQL (Hackers)
            $stmt1 = $this->conn->prepare("UPDATE pago SET estado_pago = 'confirmado' WHERE id_pago = ?");
            $stmt1->bind_param("i", $id_pago); // "i" significa Integer (Número entero)
            $stmt1->execute();

            // ACCIÓN 2: Actualizamos la tabla 'paseo'
            $stmt2 = $this->conn->prepare("UPDATE paseo SET estado_habilitacion = 'habilitado_admin' WHERE id_paseo = ?");
            $stmt2->bind_param("i", $id_paseo);
            $stmt2->execute();

            $this->conn->commit(); // Si llegamos aquí sin errores, le decimos a MySQL "¡Ahora sí, GUARDA TODO!"
            return true;
        } catch (Exception $e) {
            $this->conn->rollback(); // Si algo explotó arriba, CANCELA TODO. No cobramos ni habilitamos nada a medias.
            return false;
        }
    }

    /**
     * Agrega un nuevo paseador a la Base de Datos
     */
    public function crearPaseador($data) {
        // Preparamos el esqueleto de la consulta SQL con los signos de interrogación para seguridad
        $sql = "INSERT INTO paseador (nombre, apellido, email, password, telefono, zona, disponibilidad, estado, bio, rating, fecha_alta) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'activo', ?, 5, CURDATE())";
        
        $stmt = $this->conn->prepare($sql);
        
        // HASH DE CONTRASEÑA: NUNCA guardamos contraseñas en texto plano. 
        // Generamos un Hash seguro indescifrable.
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Atamos los datos del formulario a los signos de interrogación (8 "s" porque son 8 Strings)
        $stmt->bind_param("ssssssss", 
            $data['nombre'], $data['apellido'], $data['email'], $hash, 
            $data['telefono'], $data['zona'], $data['disponibilidad'], $data['bio']
        );
        return $stmt->execute();
    }

    // DESTRUCTOR: Al finalizar, liberamos memoria
    public function cerrarConexion() {
        cerrarBDConexion($this->conn);
    }
}

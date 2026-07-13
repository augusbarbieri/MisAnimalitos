<?php
/**
 * =========================================================================
 * ARCHIVO: models/AuthModel.php
 * =========================================================================
 * PROPÓSITO: El detective encargado de ir a la Base de Datos, buscar 
 * a la persona con un Email específico, y comprobar que la contraseña
 * proporcionada sea correcta.
 * =========================================================================
 */

require_once __DIR__ . '/../config/conexion.php';

class AuthModel {
    private $conn;

    public function __construct() {
        $this->conn = conectarBDManadas();
        if (!$this->conn) {
            die("Error de conexión a la base de datos.");
        }
    }

    /**
     * Función verificar_password()
     * Aquí ocurre la magia. Las contraseñas en BD suelen estar cifradas (Hash).
     * Esta función usa 'password_verify' nativo de PHP para comparar el texto plano
     * contra el hash indescifrable almacenado.
     * (Opcional: Si el sistema es viejo y guardó texto plano, verifica eso también por compatibilidad).
     */
    private function verificar_password($plain, $stored) {
        return password_verify($plain, $stored) || ($plain === $stored);
    }

    /**
     * Busca el email en una de las 3 tablas (admin, paseador, usuarios).
     */
    private function autenticarEnTabla($email, $password, $tabla) {
        // Usamos Prepared Statements (?) para que no nos inyecten SQL a través del email
        $sql = "SELECT * FROM $tabla WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param('s', $email); // Reemplazamos el '?' por el String del Email
        $stmt->execute();
        
        $resultado = $stmt->get_result(); // Nos traemos la respuesta de MySQL

        // ¿Encontró una fila que coincida con ese Email?
        if ($resultado && $resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc(); // Extraemos los datos de esa fila
            
            // Si el email existe, verificamos la contraseña
            if ($this->verificar_password($password, $usuario['password'])) {
                return $usuario; // Éxito! Devolvemos todo el perfil del usuario
            }
        }
        return null; // El email no existe o la contraseña era mala
    }

    /**
     * ¡LÓGICA PRINCIPAL DEL LOGIN!
     * Como Manadas tiene 3 roles separados en 3 tablas distintas,
     * tenemos que buscar el email en cada una de ellas por orden.
     */
    public function autenticarUsuario($email, $password) {
        
        // 1. ¿Es el jefe (Admin)?
        $usuario = $this->autenticarEnTabla($email, $password, 'admin');
        if ($usuario) return ['datos' => $usuario, 'rol' => 'admin', 'id_col' => 'id_admin'];

        // 2. ¿Es un empleado (Paseador)?
        $usuario = $this->autenticarEnTabla($email, $password, 'paseador');
        if ($usuario) return ['datos' => $usuario, 'rol' => 'paseador', 'id_col' => 'id_paseador'];

        // 3. ¿Es un cliente (Usuario dueño de mascota)?
        $usuario = $this->autenticarEnTabla($email, $password, 'usuarios');
        if ($usuario) return ['datos' => $usuario, 'rol' => 'usuario', 'id_col' => 'id_usuario'];

        // Si pasó las 3 tablas y no lo encontró, lo rechazamos
        return null; 
    }

    public function cerrarConexion() {
        cerrarBDConexion($this->conn);
    }
}

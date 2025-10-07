<?php
class RegisterModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crearUsuario($nombre, $email, $identificacion, $password)
    {
        try {
            $count = 0;  
            // Verificar si el correo ya existe
            $sqlCheck = "SELECT COUNT(*) FROM HUELLITAS_USUARIOS_TB WHERE USUARIO_CORREO = ?";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->bind_param("s", $email);
            $stmtCheck->execute();
            $stmtCheck->bind_result($count);
            $stmtCheck->fetch();
            $stmtCheck->close();

            
            if ($count > 0) {
                return ['status' => 'error', 'message' => 'El correo ya está registrado.'];
            }

            $rol = 1;
            $estado = 1;

            // Insertar usuario
            $sqlInsert = "INSERT INTO HUELLITAS_USUARIOS_TB 
                          (ID_ESTADO_FK, ID_ROL_USUARIO_FK, USUARIO_NOMBRE, USUARIO_CORREO, USUARIO_CONTRASENNA, USUARIO_IDENTIFICACION)
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sqlInsert);
            $stmt->bind_param("iisssi", $estado, $rol, $nombre, $email, $password, $identificacion);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Usuario registrado exitosamente.'];
            } else {
                return ['status' => 'error', 'message' => 'Error al registrar el usuario: ' . $stmt->error];
            }

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Excepción: ' . $e->getMessage()];
        }
    }
}

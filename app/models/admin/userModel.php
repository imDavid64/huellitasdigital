<?php
class UsuarioModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function validarLogin($email, $password)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_VALIDAR_LOGIN_SP(?, ?)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getAllUsuarios()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_USUARIO_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUsuarioById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT u.ID_USUARIO_PK, u.USUARIO_NOMBRE, u.USUARIO_CORREO,
                   u.ID_ROL_USUARIO_FK, r.DESCRIPCION_ROL_USUARIO AS ROL,
                   u.ID_ESTADO_FK, e.ESTADO_DESCRIPCION AS ESTADO
            FROM HUELLITAS_USUARIOS_TB u
            INNER JOIN HUELLITAS_ROL_USUARIO_TB r ON u.ID_ROL_USUARIO_FK = r.ID_ROL_USUARIO_PK
            INNER JOIN HUELLITAS_ESTADO_TB e ON u.ID_ESTADO_FK = e.ID_ESTADO_PK
            WHERE u.ID_USUARIO_PK = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateUsuario($id_usuario, $username, $email, $estado, $rol, $password = null, $profile_pic = null)
    {
        $query = "UPDATE HUELLITAS_USUARIOS_TB 
                  SET USUARIO_NOMBRE = ?, USUARIO_CORREO = ?, ID_ESTADO_FK = ?, ID_ROL_USUARIO_FK = ?";
        $params = [$username, $email, $estado, $rol];
        $types = "ssii";

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", USUARIO_PASSWORD = ?";
            $types .= "s";
            $params[] = $hashed_password;
        }

        if ($profile_pic !== null) {
            $query .= ", USUARIO_FOTO = ?";
            $types .= "s";
            $params[] = $profile_pic;
        }

        $query .= " WHERE ID_USUARIO_PK = ?";
        $types .= "i";
        $params[] = $id_usuario;

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function addUsuario($username, $email, $password, $estado, $rol, $direccionId = null, $telefonoId = null)
    {
        $sql = "INSERT INTO HUELLITAS_USUARIOS_TB 
                (USUARIO_NOMBRE, USUARIO_CORREO, USUARIO_CONTRASENNA, 
                 ID_ESTADO_FK, ID_ROL_USUARIO_FK, ID_DIRECCION_FK, ID_TELEFONO_CONTACTO_FK)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Error en prepare: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssiiii",
            $username,
            $email,
            $password, // el trigger lo encripta
            $estado,
            $rol,
            $direccionId,
            $telefonoId
        );

        return $stmt->execute();
    }
}

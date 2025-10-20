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

    public function searchUserPaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_USUARIOS_ADMIN_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countUsers($query)
    {
        $stmt = $this->conn->prepare("
        SELECT COUNT(*) AS total
        FROM HUELLITAS_USUARIOS_TB u
        INNER JOIN HUELLITAS_ROL_USUARIO_TB r ON u.ID_ROL_USUARIO_FK = r.ID_ROL_USUARIO_PK
        INNER JOIN HUELLITAS_ESTADO_TB e ON u.ID_ESTADO_FK = e.ID_ESTADO_PK
        LEFT JOIN HUELLITAS_DIRECCION_TB d ON u.ID_DIRECCION_FK = d.ID_DIRECCION_PK
        LEFT JOIN HUELLITAS_DIRECCION_PROVINCIA_TB prov ON d.ID_DIRECCION_PROVINCIA_FK = prov.ID_DIRECCION_PROVINCIA_PK
        LEFT JOIN HUELLITAS_DIRECCION_CANTON_TB cant ON d.ID_DIRECCION_CANTON_FK = cant.ID_DIRECCION_CANTON_PK
        LEFT JOIN HUELLITAS_DIRECCION_DISTRITO_TB dist ON d.ID_DIRECCION_DISTRITO_FK = dist.ID_DIRECCION_DISTRITO_PK
        WHERE 
            u.USUARIO_NOMBRE LIKE CONCAT('%', ?, '%')
            OR u.USUARIO_CORREO LIKE CONCAT('%', ?, '%')
            OR r.DESCRIPCION_ROL_USUARIO LIKE CONCAT('%', ?, '%')
            OR e.ESTADO_DESCRIPCION LIKE CONCAT('%', ?, '%')
            OR prov.NOMBRE_PROVINCIA LIKE CONCAT('%', ?, '%')
            OR cant.NOMBRE_CANTON LIKE CONCAT('%', ?, '%')
            OR dist.NOMBRE_DISTRITO LIKE CONCAT('%', ?, '%')
    ");
        $stmt->bind_param("sssssss", $query, $query, $query, $query, $query, $query, $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }



}

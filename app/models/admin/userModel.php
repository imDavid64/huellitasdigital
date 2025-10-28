<?php
namespace App\Models\Admin;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
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
        $stmt = $this->conn->prepare("CALL HUELLITAS_ADMIN_OBTENER_USUARIO_POR_ID_SP(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateUsuario($id, $username, $email, $estado, $rol, $identificacion, $telefono, $password = null, $imagen = null)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ADMIN_ACTUALIZAR_USUARIO_SP(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "issiissss",
            $id,
            $username,
            $email,
            $estado,
            $rol,
            $identificacion,
            $telefono,
            $password,
            $imagen
        );
        return $stmt->execute();
    }

    public function addUsuario($username, $email, $password, $estado, $rol, $identificacion, $telefono)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ADMIN_AGREGAR_USUARIO_SP(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssiiis",
            $username,
            $email,
            $password,
            $estado,
            $rol,
            $identificacion,
            $telefono
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

    // Contar total de usuarios para paginación
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

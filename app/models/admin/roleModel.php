<?php
namespace App\Models\Admin;

use App\Models\BaseModel;

class RoleModel extends BaseModel
{
    public function updateRole($id_rol, $rol_nombre, $estado)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_ROL_SP(?, ?, ?)");
        $stmt->bind_param("isi", $id_rol, $rol_nombre, $estado);
        $stmt->execute();
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getRoleById($id_rol)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_ROL_POR_ID_SP(?)");
        $stmt->bind_param("i", $id_rol);
        $stmt->execute();
        $result = $stmt->get_result();
        $rol = $result->fetch_assoc();
        $stmt->close();
        return $rol;
    }

    public function getAllRoles()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_ROLES_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addRole($rolename, $estado)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_AGREGAR_ROL_SP(?, ?)");
        $stmt->bind_param("si", $rolename, $estado);
        $stmt->execute();
        $stmt->bind_param(
            "si",
            $rolename,
            $estado,
        );
        return $stmt->execute();
    }

    public function searchRolePaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_ROLES_ADMIN_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Contar total de roles para paginación
    public function countRoles($query)
    {
        $stmt = $this->conn->prepare("
        SELECT COUNT(*) AS total
        FROM HUELLITAS_ROL_USUARIO_TB r
        INNER JOIN HUELLITAS_ESTADO_TB e ON r.ID_ESTADO_FK = e.ID_ESTADO_PK
        WHERE 
            r.DESCRIPCION_ROL_USUARIO LIKE CONCAT('%', ?, '%')
            OR e.ESTADO_DESCRIPCION LIKE CONCAT('%', ?, '%')
    ");
        $stmt->bind_param("ss", $query, $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

}
?>
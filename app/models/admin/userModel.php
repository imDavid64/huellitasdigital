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
        $stmt = $this->conn->prepare("CALL HUELLITAS_CONTAR_USUARIOS_SP(?)");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result['TOTAL'] ?? 0;
    }

}

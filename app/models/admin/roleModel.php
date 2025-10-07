<?php
class RoleModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function updateRole($id_rol, $rol_nombre, $estado)
    {
        $query = "UPDATE HUELLITAS_ROL_USUARIO_TB
                  SET DESCRIPCION_ROL_USUARIO = ?, ID_ESTADO_FK = ?
                  WHERE ID_ROL_USUARIO_PK = ?";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("❌ Error en prepare: " . $this->conn->error);
        }

        $stmt->bind_param("sii", $rol_nombre, $estado, $id_rol);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function getRoleById($id_rol)
    {
        $stmt = $this->conn->prepare("SELECT * FROM HUELLITAS_ROL_USUARIO_TB WHERE ID_ROL_USUARIO_PK = ?");
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
        $sql = "INSERT INTO HUELLITAS_ROL_USUARIO_TB 
                (DESCRIPCION_ROL_USUARIO, ID_ESTADO_FK)
                VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Error en prepare: " . $this->conn->error);
        }

        $stmt->bind_param(
            "si",
            $rolename,
            $estado,
        );

        return $stmt->execute();
    }
}
?>
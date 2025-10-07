<?php
class GeSettingModel
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

    public function getAllGeSettings()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_SLIDER_BANNER_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addSliderBanner($descripcion, $imagen_url, $id_estado)
    {
        // ⬇️ SE CORRIGIERON LOS NOMBRES DE LAS COLUMNAS AQUÍ ⬇️
        $sql = "INSERT INTO HUELLITAS_SLIDER_BANNER_TB
            (DESCRIPCION_SLIDER_BANNER, IMAGEN_URL, ID_ESTADO_FK)
            VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar consulta: " . $this->conn->error);
        }

        // El bind_param ya era correcto (iissdis), no necesita cambios.
        $stmt->bind_param("ssi", $descripcion, $imagen_url, $id_estado);

        $result = $stmt->execute();

        // 💡 Consejo: Agrega esta verificación para obtener el error específico de MySQL
        if (!$result) {
            throw new Exception("Error al ejecutar consulta: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }
}
?>
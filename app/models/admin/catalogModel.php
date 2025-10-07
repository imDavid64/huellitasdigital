<?php
include_once __DIR__ . "/../conexionDB.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();

class CatalogModel
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllRoles()
    {
        $stmt = $this->conn->prepare("SELECT ID_ROL_USUARIO_PK, DESCRIPCION_ROL_USUARIO FROM HUELLITAS_ROL_USUARIO_TB");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllEstados()
    {
        $stmt = $this->conn->prepare("SELECT ID_ESTADO_PK, ESTADO_DESCRIPCION FROM HUELLITAS_ESTADO_TB");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllProveedores()
    {
        $stmt = $this->conn->prepare("SELECT ID_PROVEEDOR_PK, PROVEEDOR_NOMBRE FROM HUELLITAS_PROVEEDORES_TB");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
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

    public function getAllCategorias()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_CATEGORIAS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllMarcas()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_MARCAS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllEsNuevo()
    {
        $stmt = $this->conn->prepare("SELECT ID_NUEVO_PK, NUEVO_DESCRIPCION FROM HUELLITAS_NUEVO_TB");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllProvincias()
    {
        $stmt = $this->conn->prepare("SELECT ID_DIRECCION_PROVINCIA_PK, NOMBRE_PROVINCIA FROM HUELLITAS_DIRECCION_PROVINCIA_TB");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllCantones()
    {
        $stmt = $this->conn->prepare("SELECT ID_DIRECCION_CANTON_PK, ID_PROVINCIA_FK, NOMBRE_CANTON FROM HUELLITAS_DIRECCION_CANTON_TB");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllDistritos()
    {
        $stmt = $this->conn->prepare("SELECT ID_DIRECCION_DISTRITO_PK, ID_CANTON_FK, NOMBRE_DISTRITO FROM HUELLITAS_DIRECCION_DISTRITO_TB");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCantonesByProvincia($idProvincia)
    {
        $stmt = $this->conn->prepare("SELECT ID_DIRECCION_CANTON_PK, NOMBRE_CANTON FROM HUELLITAS_DIRECCION_CANTON_TB WHERE ID_PROVINCIA_FK = ?");
        $stmt->bind_param("i", $idProvincia);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDistritosByCanton($idCanton)
    {
        $stmt = $this->conn->prepare("SELECT ID_DIRECCION_DISTRITO_PK, NOMBRE_DISTRITO FROM HUELLITAS_DIRECCION_DISTRITO_TB WHERE ID_CANTON_FK = ?");
        $stmt->bind_param("i", $idCanton);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>
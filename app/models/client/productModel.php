<?php
class ProductModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Obtener todos los productos
    public function getAllProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Obtener todos los productos "Activos"
    public function getAllActiveProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_ACTIVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Obtener todos los productos "Activos" y "Nuevos"
    public function getAllNewActiveProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_ACTIVOS_NUEVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>
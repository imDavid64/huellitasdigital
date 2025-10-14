<?php
class BrandModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Obtener todos los productos "Activos"
    public function getAllActiveBrands()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_MARCAS_ACTIVAS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
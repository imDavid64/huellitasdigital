<?php
namespace App\Models\Client;

use App\Models\BaseModel;

class BrandModel extends BaseModel
{

    //Obtener todos las marcas "Activas"
    public function getAllActiveBrands()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_MARCAS_ACTIVAS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
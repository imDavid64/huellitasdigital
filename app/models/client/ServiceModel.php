<?php
// app/models/client/ProductModel.php
namespace App\Models\Client;

use App\Models\BaseModel;

class ServiceModel extends BaseModel
{

    // ✅ Listar solo servicios activos
    public function getAllActiveServices()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_SERVICIOS_ACTIVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $servicios = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $servicios;
    }

    public function getServiceById($id_service)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_SERVICIO_POR_ID_SP(?)");
        $stmt->bind_param("i", $id_service);
        $stmt->execute();
        $result = $stmt->get_result();
        $servicio = $result->fetch_assoc();
        $stmt->close();
        return $servicio;
    }
}
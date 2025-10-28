<?php
namespace App\Models\Admin;

use App\Models\BaseModel;

class GeSettingModel extends BaseModel
{
    public function getAllSliderBanner()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_SLIDER_BANNER_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSliderBannerById($id_slider_banner)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_SLIDER_BANNER_POR_ID_SP(?)");
        $stmt->bind_param("i", $id_slider_banner);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addSliderBanner($descripcion, $imagen_url, $id_estado)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_AGREGAR_SLIDER_BANNER_SP(?, ?, ?)");
        $stmt->bind_param("ssi", $imagen_url, $descripcion, $id_estado);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    function updateSliderBanner($id_slider_banner, $imagen_url, $descripcion, $estado)
    {
        $query = "CALL HUELLITAS_ACTUALIZAR_SLIDER_BANNER_SP(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "issi",
            $id_slider_banner,
            $imagen_url,
            $descripcion,
            $estado
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /* =========================SERVICIOS========================= */
    public function getAllServices()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_SERVICIOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    public function getServiceById($id_servicio)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_SERVICIO_POR_ID_SP(?)");
        $stmt->bind_param("i", $id_servicio);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    public function addService($id_estado, $nombre_servicio, $descripcion_servicio, $imagen_url)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_AGREGAR_SERVICIO_SP(?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_estado, $nombre_servicio, $descripcion_servicio, $imagen_url);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateService($id_servicio, $id_estado, $nombre_servicio, $descripcion_servicio, $imagen_url)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_SERVICIO_SP(?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $id_servicio, $id_estado, $nombre_servicio, $descripcion_servicio, $imagen_url);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>
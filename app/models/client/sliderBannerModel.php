<?php
namespace App\Models\Client;

use App\Models\BaseModel;

class SliderBannerModel extends BaseModel
{
    public function getAllActiveSliderBanner()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_SLIDER_BANNER_ACTIVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

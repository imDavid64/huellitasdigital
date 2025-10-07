<?php
require_once __DIR__ . '/../../models/client/sliderBannerModel.php';
require_once __DIR__ . '/../../models/conexionDB.php';

class SliderBannerController
{
    private $sliderModel;

    public function __construct()
    {
        $db = new ConexionDatabase();
        $conn = $db->connectDB();
        $this->sliderModel = new SliderBannerModel($conn);
    }

    public function obtenerBanners()
    {
        return $this->sliderModel->listarBanners();
    }
}

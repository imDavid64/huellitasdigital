<?php
class SliderBannerModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function listarBanners()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_SLIDER_BANNER_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

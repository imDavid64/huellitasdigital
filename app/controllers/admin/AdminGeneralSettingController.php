<?php
namespace App\Controllers\Admin;

use App\Models\Admin\CatalogModel;
use App\Config\FirebaseConfig;
use App\Models\Admin\GeSettingModel;

class AdminGeneralSettingController
{
    private GeSettingModel $geSettingModel;
    private CatalogModel $catalogModel;
    private FirebaseConfig $firebase;

    public function __construct()
    {
        // ✅ Solo administradores
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }
        $this->geSettingModel = new GeSettingModel();
        $this->catalogModel = new CatalogModel();
        $this->firebase = new FirebaseConfig();
    }

    // =======================================
    // ✅ VISTA PRINCIPAL DEL PANEL
    // =======================================
    public function index()
    {
        $sliderbanners = $this->geSettingModel->getAllSliderBanner();
        $services = $this->geSettingModel->getAllServices();

        require VIEW_PATH . "/admin/geSettings-mgmt/general-settings.php";
    }

    // =======================================
    // ✅ SLIDER / BANNERS
    // =======================================
    public function createSliderBanner()
    {
        $estados = $this->catalogModel->getActiveInactiveStates();
        require VIEW_PATH . "/admin/geSettings-mgmt/add-slider-banner.php";
    }

    public function editSliderBanner()
    {
        $id = intval($_GET['id'] ?? 0);
        $sliderbanner = $this->geSettingModel->getSliderBannerById($id);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/admin/geSettings-mgmt/edit-slider-banner.php";
    }

    public function storeSliderBanner()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit("🚫 Acceso denegado");

        $descripcion = trim($_POST['descripcion']);
        $estado = intval($_POST['estado']);

        $imgUrl = null;
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $file = $_FILES['imagen']['tmp_name'];
            $fileName = uniqid() . "_" . $_FILES['imagen']['name'];
            $imgUrl = $this->firebase->uploadSliderBannerImage($file, $fileName);
        }

        $ok = $this->geSettingModel->addSliderBanner($descripcion, $imgUrl, $estado);

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Banner agregado" : "❌ Error al agregar";

        header("Location: " . BASE_URL . "/index.php?controller=adminGeneralSetting&action=index");
        exit;
    }

    public function updateSliderBanner()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit("🚫 Acceso denegado");

        $id = intval($_POST['id_sliderbanner']);
        $descripcion = trim($_POST['sliderbannerdescription']);
        $estado = intval($_POST['state']);
        $currentImg = $_POST['current_image_url'];
        $newImg = $currentImg;

        if (!empty($_FILES['sliderbannerimagen']['tmp_name'])) {
            $file = $_FILES['sliderbannerimagen']['tmp_name'];
            $fileName = uniqid() . "_" . $_FILES['sliderbannerimagen']['name'];

            $uploaded = $this->firebase->uploadSliderBannerImage($file, $fileName);
            if ($uploaded) {
                if ($currentImg) $this->firebase->deleteImage($currentImg);
                $newImg = $uploaded;
            }
        }

        $ok = $this->geSettingModel->updateSliderBanner($id, $newImg, $descripcion, $estado);

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Banner actualizado" : "❌ Error al actualizar";

        header("Location: " . BASE_URL . "/index.php?controller=adminGeneralSetting&action=index");
        exit;
    }

    // =======================================
    // ✅ SERVICIOS
    // =======================================
    public function createService()
    {
        $estados = $this->catalogModel->getActiveInactiveStates();
        require VIEW_PATH . "/admin/geSettings-mgmt/add-service.php";
    }

    public function editService()
    {
        $id = intval($_GET['id'] ?? 0);
        $servicio = $this->geSettingModel->getServiceById($id);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/admin/geSettings-mgmt/edit-service.php";
    }

    public function storeService()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit("🚫 Acceso denegado");

        $nombre = trim($_POST['nombre_servicio']);
        $descripcion = trim($_POST['descripcion_servicio']);
        $estado = intval($_POST['estado_servicio']);

        $imgUrl = null;
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $file = $_FILES['imagen']['tmp_name'];
            $fileName = uniqid() . "_" . $_FILES['imagen']['name'];
            $imgUrl = $this->firebase->uploadServiceImage($file, $fileName);
        }

        $ok = $this->geSettingModel->addService($estado, $nombre, $descripcion, $imgUrl);

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Servicio agregado" : "❌ Error al agregar";

        header("Location: " . BASE_URL . "/index.php?controller=adminGeneralSetting&action=index");
        exit;
    }

    public function updateService()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit("🚫 Acceso denegado");

        $id = intval($_POST['id_servicio']);
        $nombre = trim($_POST['nombre_servicio']);
        $descripcion = trim($_POST['descripcion_servicio']);
        $estado = intval($_POST['estado_servicio']);
        $currentImg = $_POST['current_image_url'];
        $newImg = $currentImg;

        if (!empty($_FILES['imagen_servicio']['tmp_name'])) {
            $file = $_FILES['imagen_servicio']['tmp_name'];
            $fileName = uniqid() . "_" . $_FILES['imagen_servicio']['name'];
            $uploaded = $this->firebase->uploadServiceImage($file, $fileName);

            if ($uploaded) {
                if ($currentImg) $this->firebase->deleteImage($currentImg);
                $newImg = $uploaded;
            }
        }

        $ok = $this->geSettingModel->updateService($id, $estado, $nombre, $descripcion, $newImg);

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Servicio actualizado" : "❌ Error al actualizar";

        header("Location: " . BASE_URL . "/index.php?controller=adminGeneralSetting&action=index");
        exit;
    }
}

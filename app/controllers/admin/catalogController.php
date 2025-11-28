<?php
namespace App\Controllers\Admin;

use App\Models\Admin\CatalogModel;

class CatalogController
{
    private CatalogModel $catalogModel;

    public function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');

        // ✅ Solo administradores
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        $this->catalogModel = new CatalogModel();
    }

    // ✅ AJAX: Obtener Cantones por Provincia
    public function getCantones()
    {
        $provincia = intval($_GET['idProvincia'] ?? 0);

        if (!$provincia) {
            echo json_encode(['error' => 'Falta idProvincia']);
            return;
        }

        $data = $this->catalogModel->getCantonesByProvincia($provincia);
        echo json_encode($data);
    }

    // ✅ AJAX: Obtener Distritos por Cantón
    public function getDistritos()
    {
        $canton = intval($_GET['idCanton'] ?? 0);

        if (!$canton) {
            echo json_encode(['error' => 'Falta idCanton']);
            return;
        }

        $data = $this->catalogModel->getDistritosByCanton($canton);
        echo json_encode($data);
    }
}

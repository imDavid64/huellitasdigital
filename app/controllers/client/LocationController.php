<?php
namespace App\Controllers\Client;

use App\Models\Admin\CatalogModel;

require_once __DIR__ . '/../../config/bootstrap.php';

class LocationController
{
    public function getCantonesPorProvincia()
    {
        header('Content-Type: application/json');
        $idProvincia = $_GET['idProvincia'] ?? null;
        $model = new CatalogModel();
        echo json_encode($model->getCantonesByProvincia($idProvincia));
    }

    public function getDistritosPorCanton()
    {
        header('Content-Type: application/json');
        $idCanton = $_GET['idCanton'] ?? null;
        $model = new CatalogModel();
        echo json_encode($model->getDistritosByCanton($idCanton));
    }
}

<?php
namespace App\Controllers\Client;

use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;

require_once __DIR__ . '/../../config/bootstrap.php';

class ServiceController
{
    public function index()
    {
        $productModel = new ProductModel();
        $serviceModel = new serviceModel();
        $categories = $productModel->getAllActiveCategories();
        $services = $serviceModel->getAllActiveServices();
        require __DIR__ . '/../../views/client/services/services.php';
    }

    public function serviceDetails()
    {
        $productModel = new ProductModel();
        $serviceModel = new serviceModel();
        $categories = $productModel->getAllActiveCategories();
        $services = $serviceModel->getAllActiveServices();
        $id_service = intval($_GET['idService'] ?? 0);
        $serviceSelected = $serviceModel->getServiceById($id_service);
        require __DIR__ . '/../../views/client/services/serviceDetails.php';
    }
}

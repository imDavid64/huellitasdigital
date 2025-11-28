<?php
namespace App\Controllers\Client;

use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;

require_once __DIR__ . '/../../config/bootstrap.php';

class AboutUsController
{
    public function index()
    {
        $productModel = new ProductModel();
        $serviceModel = new serviceModel();
        $categories = $productModel->getAllActiveCategories();
        $services = $serviceModel->getAllActiveServices();
        require __DIR__ . '/../../views/client/aboutUs/aboutUs.php';
    }
}

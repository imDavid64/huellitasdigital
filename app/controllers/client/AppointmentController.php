<?php
namespace App\Controllers\Client;

use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;

require_once __DIR__ . '/../../config/bootstrap.php';

class AppointmentController
{
    public function index()
    {
        $productModel = new ProductModel();
        $serviceModel = new ServiceModel();
        $categories = $productModel->getAllActiveCategories();
        $services = $serviceModel->getAllActiveServices();

        require __DIR__ . '/../../views/client/extras/contactToAppointment.php';
    }
}

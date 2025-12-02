<?php
namespace App\Controllers\Client;

use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;
use App\Models\Client\AppointmentModel;

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
    public function misCitas()
    {
        if (!isset($_SESSION["user_code"])) {
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=login");
            exit;
        }

        $codigoUsuario = $_SESSION["user_code"];

        $appointmentModel = new AppointmentModel();
        $proximascitas = $appointmentModel->obtenerProximasCitas($codigoUsuario);
        $citasPasadas = $appointmentModel->obtenerCitasPasadas($codigoUsuario);

        require __DIR__ . "/../../views/client/extras/my-appointments.php";
    }
}

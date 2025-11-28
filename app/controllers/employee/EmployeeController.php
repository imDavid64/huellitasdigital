<?php
namespace App\Controllers\Employee;

use App\Models\Employee\EmployeeModel;

require_once __DIR__ . '/../../config/bootstrap.php';

class EmployeeController
{
    private $employeeModel;
    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        // ✅ Solo empleados o administradores
        if (
            !isset($_SESSION['user_role']) ||
            ($_SESSION['user_role'] !== 'EMPLEADO' && $_SESSION['user_role'] !== 'ADMINISTRADOR')
        ) {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }
    }

    public function index()
    {
        $citas = $this->employeeModel->getAllAppointments();
        $kpis = $this->employeeModel->getDashboardKpis($_SESSION['user_id']);
        require VIEW_PATH . '/employee/home.php';
    }

}
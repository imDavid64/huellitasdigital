<?php
namespace App\Controllers\Employee;

use App\Models\Employee\DashboardModel;

class EmployeeDashboardController
{
    private DashboardModel $dashboardModel;

    public function __construct()
    {
        // Solo empleados o administradores
        $this->dashboardModel = new DashboardModel();
    }

    public function index()
    {
        // Obtener ID del empleado desde la sesión
        $id_empleado = $_SESSION['user_id'] ?? null;
        
        if (!$id_empleado) {
            throw new \Exception("Usuario no autenticado");
        }

        $data = [
            'citas_hoy' => $this->dashboardModel->getCitasHoy($id_empleado),
            'citas_pendientes' => $this->dashboardModel->getCitasPendientes($id_empleado),
            'pedidos_pendientes' => $this->dashboardModel->getPedidosPendientes(),
            'movimientos_inventario' => $this->dashboardModel->getMovimientosInventario(),
            'servicios_mes' => $this->dashboardModel->getServiciosMes($id_empleado),
            'citas_comparacion' => $this->dashboardModel->getCitasComparacionMes($id_empleado),
            'cirugias_hoy' => $this->dashboardModel->getCirugiasHoy($id_empleado)
        ];

        // Ruta corregida - siguiendo la estructura de appointment-mgmt
        require_once __DIR__ . '/../../views/employee/dashboard-mgmt/dashboard-mgmt.php';
    }

    public function apiEstadisticas()
    {
        header("Content-Type: application/json");

        try {
            $id_empleado = $_SESSION['user_id'] ?? null;
            
            if (!$id_empleado) {
                echo json_encode(['error' => 'Usuario no autenticado']);
                exit;
            }

            $estadisticas = [
                'citas_pendientes' => $this->dashboardModel->getCitasPendientes($id_empleado),
                'total_citas_hoy' => count($this->dashboardModel->getCitasHoy($id_empleado)),
                'total_pedidos_pendientes' => count($this->dashboardModel->getPedidosPendientes()),
                'total_cirugias_hoy' => count($this->dashboardModel->getCirugiasHoy($id_empleado))
            ];

            echo json_encode($estadisticas, JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }
}
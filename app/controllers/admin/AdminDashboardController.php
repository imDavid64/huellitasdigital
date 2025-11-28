<?php
namespace App\Controllers\Admin;

use App\Models\Admin\DashboardModel;
use App\Models\Admin\NotificationModel;

class AdminDashboardController
{
    private DashboardModel $dashboardModel;
    private NotificationModel $notificationModel;

    public function __construct()
    {
        // Tu lógica de autenticación existente
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        $this->dashboardModel = new DashboardModel();
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        // Obtener datos para el dashboard
        $datos = [
            'citas_hoy' => $this->dashboardModel->getCitasHoy(),
            'pedidos_pendientes' => $this->dashboardModel->getPedidosPendientes(),
            'total_clientes' => $this->dashboardModel->getTotalClientes(),
            'stock_bajo' => $this->dashboardModel->getStockBajo(),
            'clientes_activos' => $this->dashboardModel->getClientesActivos(),
            'proveedores_activos' => $this->dashboardModel->getProveedoresActivos(),
            'estadisticas_mensuales' => $this->dashboardModel->getEstadisticasMensuales(),
            'productos_mas_vendidos' => $this->dashboardModel->getProductosMasVendidos(),
            'ultimos_pedidos' => $this->dashboardModel->getUltimosPedidos()
        ];

        // Obtener notificaciones
        if (isset($_SESSION['user_id'])) {
            $datos['notificaciones'] = $this->notificationModel->getNotificationsByUser($_SESSION['user_id']);
            $datos['unread_count'] = $this->notificationModel->getUnreadCount($_SESSION['user_id']);
        }

        // ✅ RUTA CORREGIDA: apunta a dashboard-mgmt/dashboard-mgmt.php
        require VIEW_PATH . "/admin/dashboard-mgmt/dashboard-mgmt.php";
    }

    // ✅ Método para actualizar datos via AJAX
    public function getDashboardData()
    {
        $datos = [
            'citas_hoy' => $this->dashboardModel->getCitasHoy(),
            'pedidos_pendientes' => $this->dashboardModel->getPedidosPendientes(),
            'stock_bajo' => $this->dashboardModel->getStockBajo()
        ];

        echo json_encode([
            'success' => true,
            'data' => $datos
        ]);
        exit;
    }
}
?>
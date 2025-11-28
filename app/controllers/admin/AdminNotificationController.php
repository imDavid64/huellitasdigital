<?php
namespace App\Controllers\Admin;

use App\Models\Admin\NotificationModel;

class AdminNotificationController
{
    private NotificationModel $notificationModel;
    private int $userId;

    public function __construct()
    {
        header('Content-Type: application/json; charset=utf-8');

        // Verificar sesión
        if (!isset($_SESSION['user_role'])) {

            // Si es AJAX → devolver JSON
            if ($this->isAjax()) {
                echo json_encode([
                    "error" => "No autorizado",
                    "code" => 403
                ]);
                exit;
            }

            // Si NO es AJAX → redirigir a 403
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        // Verificar roles permitidos
        if (!in_array($_SESSION['user_role'], ['ADMINISTRADOR', 'EMPLEADO', 'CLIENTE'])) {

            if ($this->isAjax()) {
                echo json_encode([
                    "error" => "Acceso denegado",
                    "code" => 403
                ]);
                exit;
            }

            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        // Cargar modelos
        $this->notificationModel = new NotificationModel();
        $this->userId = intval($_SESSION['user_id']);
    }

    // 🔍 Detectar AJAX
    private function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }


    // ✅ Obtener todas las notificaciones del usuario
    public function getNotifications()
    {
        $notifications = $this->notificationModel->getNotificationsByUser($this->userId);
        echo json_encode($notifications);
        exit;
    }

    // ✅ Marcar todas como leídas
    public function markAsRead()
    {
        $this->notificationModel->markAsRead($this->userId);
        echo json_encode(["success" => true]);
        exit;
    }

    public function markOneAsRead()
    {
        if (!isset($_POST['id'])) {
            echo json_encode(["error" => "Falta ID"]);
            exit;
        }

        $id = intval($_POST['id']);
        $this->notificationModel->markOneAsRead($id);

        echo json_encode(["success" => true]);
        exit;
    }

    // ✅ Contar notificaciones no leídas
    public function getUnreadCount()
    {
        $count = $this->notificationModel->getUnreadCount($this->userId);
        echo json_encode($count);
        exit;
    }
}

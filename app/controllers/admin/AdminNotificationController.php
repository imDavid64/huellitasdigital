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

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(["error" => "No autorizado"]);
            exit;
        }

        $this->notificationModel = new NotificationModel();
        $this->userId = intval($_SESSION['user_id']);
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

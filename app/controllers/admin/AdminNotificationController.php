<?php
namespace App\Controllers\Admin;

use App\Models\Admin\NotificationModel;
use App\Models\Admin\CatalogModel;

class AdminNotificationController
{
    private NotificationModel $notificationModel;
    private CatalogModel $catalogModel;
    private int $userId;

    public function __construct()
    {
        if ($this->isAjax()) {
            header('Content-Type: application/json; charset=utf-8');
        }

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
        $this->catalogModel = new CatalogModel();
        $this->userId = intval($_SESSION['user_id']);
    }

    public function Index()
    {
        $query = $_GET['query'] ?? '';
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $notifications = $this->notificationModel->searchNotificationPaginated($query, $limit, $offset);
        $total = $this->notificationModel->countNotifications($query);
        $totalPages = ceil($total / $limit);
        require VIEW_PATH . "/admin/notification-mgmt/notification-mgmt.php";
    }

    public function search()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $notifications = $this->notificationModel->searchNotificationPaginated($query, $limit, $offset);
        $total = $this->notificationModel->countNotifications($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/notification-mgmt/partials/notification-table.php";
    }

    public function create()
    {
        require VIEW_PATH . "/admin/notification-mgmt/add-notification.php";
    }

    public function store()
    {
        $title = trim($_POST['addNotificationTitle'] ?? '');
        $message = trim($_POST['addNotificationMessage'] ?? '');
        $type = trim($_POST['notificationType'] ?? '');
        $priority = trim($_POST['priority'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $target = trim($_POST['notificationTarget'] ?? 'GLOBAL');
        $userId = intval($_POST['selectedUserId'] ?? 0);

        // Validaciones básicas
        if ($title === '' || $message === '' || $type === '' || $priority === '') {
            $_SESSION['error'] = "Debe completar todos los campos obligatorios.";
            header("Location: " . BASE_URL . "/index.php?controller=adminNotification&action=create");
            exit;
        }

        // -----------------------------------
        // 🔹 NOTIFICACIÓN GLOBAL
        // -----------------------------------
        if ($target === "GLOBAL") {

            $result = $this->notificationModel->addGlobalNotification(
                $title,
                $message,
                $type,
                $priority,
                $url
            );

            if ($result) {
                $_SESSION['success'] = "Notificación global enviada correctamente.";
            } else {
                $_SESSION['error'] = "Hubo un error enviando la notificación global.";
            }

            header("Location: " . BASE_URL . "/index.php?controller=adminNotification&action=index");
            exit;
        }


        // -----------------------------------
        // 🔹 NOTIFICACIÓN INDIVIDUAL
        // -----------------------------------
        if ($target === "PERSONA") {

            if ($userId <= 0) {
                $_SESSION['error'] = "Debe seleccionar un usuario válido.";
                header("Location: " . BASE_URL . "/index.php?controller=adminNotification&action=create");
                exit;
            }

            $result = $this->notificationModel->addNotificationToUser(
                $userId,
                $title,
                $message,
                $type,
                $priority
            );

            if ($result) {
                $_SESSION['success'] = "Notificación enviada correctamente al usuario.";
            } else {
                $_SESSION['error'] = "Hubo un error enviando la notificación al usuario.";
            }

            header("Location: " . BASE_URL . "/index.php?controller=adminNotification&action=index");
            exit;
        }
    }

    public function searchUserAjax()
    {
        $query = trim($_GET['query'] ?? '');

        if ($query === '') {
            echo json_encode([]);
            return;
        }

        $users = $this->notificationModel->searchUsers($query);

        echo json_encode($users);
        exit;
    }


    public function edit()
    {
        $id = intval($_GET['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = "ID inválido.";
            header("Location: " . BASE_URL . "/index.php?controller=adminNotification&action=index");
            exit;
        }

        $notification = $this->notificationModel->getNotificationById($id);

        if (!$notification) {
            $_SESSION['error'] = "La notificación no existe.";
            header("Location: " . BASE_URL . "/index.php?controller=adminNotification&action=index");
            exit;
        }

        require VIEW_PATH . "/admin/notification-mgmt/edit-notification.php";
    }

    public function update()
    {
        $id = intval($_POST['id'] ?? 0);
        $title = trim($_POST['addNotificationTitle'] ?? '');
        $message = trim($_POST['addNotificationMessage'] ?? '');
        $type = trim($_POST['notificationType'] ?? '');
        $priority = trim($_POST['priority'] ?? '');

        // Nuevos campos
        $state = intval($_POST['state'] ?? 1);   // Activa, leída, etc.
        $read = intval($_POST['read'] ?? 0);
        $url = trim($_POST['url'] ?? '');

        if ($id <= 0) {
            $_SESSION['error'] = "ID inválido.";
            header("Location: " . BASE_URL . "/index.php?controller=adminNotification&action=index");
            exit;
        }

        $result = $this->notificationModel->updateNotification(
            $id,
            $state,
            $title,
            $message,
            $type,
            $priority,
            $read,
            $url
        );

        if ($result) {
            $_SESSION['success'] = "Notificación actualizada correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo actualizar la notificación.";
        }

        header("Location: " . BASE_URL . "/index.php?controller=adminNotification&action=index");
        exit;
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

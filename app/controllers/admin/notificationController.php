<?php
session_start();
require_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/admin/notificationModel.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();
$notificationModel = new NotificationModel($conn);

$action = $_GET['action'] ?? '';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "No autorizado"]);
    exit;
}

$id_usuario = intval($_SESSION['user_id']);

switch ($action) {

    case 'getNotifications':
        $notifications = $notificationModel->getNotificationsByUser($id_usuario);
        echo json_encode($notifications);
        break;

    case 'markAsRead':
        $notificationModel->markAsRead($id_usuario);
        echo json_encode(["success" => true]);
        break;

    case 'getUnreadCount':
        $sql = "SELECT COUNT(*) AS total 
            FROM HUELLITAS_NOTIFICACIONES_TB 
            WHERE ID_USUARIO_FK = ? AND ES_LEIDA = FALSE";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        echo json_encode($result);
        break;


    default:
        echo json_encode(["error" => "Acción no válida"]);
        break;
}

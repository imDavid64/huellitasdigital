<?php
include_once __DIR__ . "/../conexionDB.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();

class NotificationModel
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    // Obtener las notificaciones no leídas del usuario
    public function getNotificationsByUser($id_usuario)
    {
        $sql = "SELECT ID_NOTIFICACION_PK, TITULO_NOTIFICACION, MENSAJE_NOTIFICACION, 
                       FECHA_CREACION, ES_LEIDA, URL_REDIRECCION
                FROM HUELLITAS_NOTIFICACIONES_TB
                WHERE ID_USUARIO_FK = ? 
                ORDER BY FECHA_CREACION DESC
                LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Marcar notificaciones como leídas
    public function markAsRead($id_usuario)
    {
        $sql = "UPDATE HUELLITAS_NOTIFICACIONES_TB 
                SET ES_LEIDA = TRUE, FECHA_LECTURA = NOW() 
                WHERE ID_USUARIO_FK = ? AND ES_LEIDA = FALSE";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        return $stmt->execute();
    }
}
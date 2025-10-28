<?php
namespace App\Models\Admin;

use App\Models\BaseModel;
class NotificationModel extends BaseModel
{
    // Obtener las notificaciones no leídas del usuario
    public function getNotificationsByUser($id_usuario)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_NOTIFICACIONES_SP(?)");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $notificaciones = $result->fetch_all(MYSQLI_ASSOC);
        // Limpieza
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $notificaciones;
    }

    // Contar notificaciones no leídas
    public function getUnreadCount(int $userId)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_CONTAR_NOTIFICACIONES_NO_LEIDAS_SP(?)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc();
        // Limpieza
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $count;
    }

    // Marcar una notificación como leída al hacer clic
    public function markOneAsRead($id_notificacion)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_MARCAR_NOTIFICACION_LEIDA_SP(?)");
        $stmt->bind_param("i", $id_notificacion);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


    // Marcar toda las notificaciones como leídas
    public function markAsRead($id_usuario)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_MARCAR_TODAS_LEIDAS_SP(?)");
        $stmt->bind_param("i", $id_usuario);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
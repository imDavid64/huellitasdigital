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

    // Búsqueda paginada de notificaciones
    public function searchNotificationPaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_NOTIFICACIONES_ADMIN_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // limpiezas obligatorias
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $rows;
    }


    // Contar total de notificaciones para paginación
    public function countNotifications($query)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_CONTAR_NOTIFICACIONES_SP(?)");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        // limpieza
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $result['TOTAL'] ?? 0;
    }

    // Crear notificación individual
    public function addNotificationToUser($userId, $title, $message, $type, $priority)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_AGREGAR_NOTIFICACION_SP(?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $userId, $title, $message, $type, $priority);

        $result = $stmt->execute();

        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $result;
    }


    // Crear notificaciones globales (masivas)
    public function addGlobalNotification($title, $message, $type, $priority, $url)
    {
        // En tu SP, el primer parámetro es P_ID_ESTADO → siempre 1 (ACTIVO)
        $estado = 1;

        $stmt = $this->conn->prepare(
            "CALL HUELLITAS_NOTIFICACION_MASIVA_SP(?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isssss", $estado, $title, $message, $type, $priority, $url);

        $result = $stmt->execute();

        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $result;
    }


    public function searchUsers($term)
    {
        $limit = 10;
        $offset = 0;

        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_TODOS_CLIENTES_USUARIOS_SP(?, ?, ?)");
        $stmt->bind_param("sii", $term, $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();
        $users = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->free_result();
        $stmt->close();

        // Limpieza obligatoria para múltiples result sets
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $users;
    }



}
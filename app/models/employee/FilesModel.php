<?php
namespace App\Models\Employee;

use App\Models\BaseModel;

class FilesModel extends BaseModel
{

    public function obtenerExpedientes($busqueda = "")
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_EXPEDIENTES_SP(?)");

            if (!$stmt) {
                throw new \Exception("Error preparando SP: " . $this->conn->error);
            }

            $stmt->bind_param("s", $busqueda);
            $stmt->execute();

            $result = $stmt->get_result();
            $expedientes = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            // Evitar “commands out of sync”
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $expedientes;

        } catch (\Throwable $e) {
            error_log("Error en obtenerExpedientes: " . $e->getMessage());
            return [];
        }
    }

}
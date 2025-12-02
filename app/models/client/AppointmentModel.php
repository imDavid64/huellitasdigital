<?php
namespace App\Models\Client;

use App\Models\BaseModel;

class AppointmentModel extends BaseModel
{
    public function obtenerProximasCitas($codigoUsuario)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PROXIMAS_CITAS_SP(?)");
            $stmt->bind_param("s", $codigoUsuario);
            $stmt->execute();

            $result = $stmt->get_result();
            $citas = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $citas;

        } catch (\Throwable $e) {
            error_log("Error obtenerProximasCitas: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerCitasPasadas($codigoUsuario)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_CITAS_PASADAS_SP(?)");
            $stmt->bind_param("s", $codigoUsuario);
            $stmt->execute();

            $result = $stmt->get_result();
            $citas = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $citas;

        } catch (\Throwable $e) {
            error_log("Error obtenerCitasPasadas: " . $e->getMessage());
            return [];
        }
    }

}
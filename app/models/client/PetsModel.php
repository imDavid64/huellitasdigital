<?php
namespace App\Models\Client;

use App\Models\BaseModel;

class PetsModel extends BaseModel
{
    public function getPetsByUserCode($codigoUsuario)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_MASCOTAS_POR_USUARIO_SP(?)");
        $stmt->bind_param("s", $codigoUsuario);
        $stmt->execute();

        $result = $stmt->get_result();
        $mascotas = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $this->conn->next_result();

        return $mascotas;
    }

    public function obtenerMascotaPorCodigo($codigoMascota)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_MASCOTA_POR_CODIGO_SP(?)");
            $stmt->bind_param("s", $codigoMascota);
            $stmt->execute();

            $result = $stmt->get_result();
            $mascota = $result->fetch_assoc();

            $stmt->close();

            // Limpieza por si el SP genera más resultsets
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $mascota ?: null;

        } catch (\Throwable $e) {
            error_log("Error en obtenerMascotaPorCodigo: " . $e->getMessage());
            return null;
        }
    }
}

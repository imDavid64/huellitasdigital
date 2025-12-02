<?php
namespace App\Models\Client;

use App\Models\BaseModel;
use mysqli_sql_exception;

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

    public function listarHistorialesResumen(string $codigoMascota): array
    {
        try {
            $stmt = $this->conn->prepare("
                CALL HUELLITAS_LISTAR_HISTORIALES_RESUMEN_SP(?)
            ");

            if (!$stmt) {
                throw new mysqli_sql_exception(
                    "Error preparando SP: " . $this->conn->error
                );
            }

            $stmt->bind_param("s", $codigoMascota);
            $stmt->execute();

            $result = $stmt->get_result();
            $historiales = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            // Evitar 'commands out of sync'
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $historiales;

        } catch (\Throwable $e) {
            error_log("Error en listarHistorialesResumen: " . $e->getMessage());
            return [];
        }
    }

    public function getMedicalHistoryByCode($codigoHistorial)
    {
        try {
            $stmt = $this->conn->prepare("
                CALL HUELLITAS_OBTENER_HISTORIAL_COMPLETO_SP(?)
            ");

            if (!$stmt) {
                throw new mysqli_sql_exception(
                    "Error preparando SP: " . $this->conn->error
                );
            }

            // Parámetros pueden ser NULL
            $stmt->bind_param(
                "s",
                $codigoHistorial
            );

            $stmt->execute();

            $result = $stmt->get_result();
            $historial = $result->fetch_assoc(); // solo devuelve 1 registro

            $stmt->close();

            // Limpiar resultsets adicionales
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $historial ?: null;

        } catch (\Throwable $e) {
            error_log("Error en obtenerHistorialCompleto: " . $e->getMessage());
            return null;
        }
    }
}

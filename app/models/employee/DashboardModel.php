<?php
namespace App\Models\Employee;

use App\Models\BaseModel;

class DashboardModel extends BaseModel
{
    public function getCitasHoy(int $id_empleado): array
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_CITAS_HOY_SP(?)");
            $stmt->bind_param("i", $id_empleado);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $data;

        } catch (\Throwable $e) {
            error_log("Error getCitasHoy: " . $e->getMessage());
            return [];
        }
    }

    public function getCitasPendientes(int $id_empleado): int
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_CITAS_PENDIENTES_SP(?)");
            $stmt->bind_param("i", $id_empleado);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $row['citas_pendientes'] ?? 0;

        } catch (\Throwable $e) {
            error_log("Error getCitasPendientes: " . $e->getMessage());
            return 0;
        }
    }

    public function getPedidosPendientes(): array
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_PEDIDOS_PENDIENTES_SP()");
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $data;

        } catch (\Throwable $e) {
            error_log("Error getPedidosPendientes: " . $e->getMessage());
            return [];
        }
    }

    public function getMovimientosInventario(): array
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_MOVIMIENTOS_INVENTARIO_SP()");
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $data;

        } catch (\Throwable $e) {
            error_log("Error getMovimientosInventario: " . $e->getMessage());
            return [];
        }
    }

    public function getServiciosMes(int $id_empleado): array
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_SERVICIOS_MES_SP(?)");
            $stmt->bind_param("i", $id_empleado);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $data;

        } catch (\Throwable $e) {
            error_log("Error getServiciosMes: " . $e->getMessage());
            return [];
        }
    }

    public function getCitasComparacionMes(int $id_empleado): array
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_CITAS_COMPARACION_MES_SP(?)");
            $stmt->bind_param("i", $id_empleado);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $data;

        } catch (\Throwable $e) {
            error_log("Error getCitasComparacionMes: " . $e->getMessage());
            return [];
        }
    }

    public function getCirugiasHoy(int $id_empleado): array
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_CIRUGIAS_HOY_SP(?)");
            $stmt->bind_param("i", $id_empleado);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $data;

        } catch (\Throwable $e) {
            error_log("Error getCirugiasHoy: " . $e->getMessage());
            return [];
        }
    }
}
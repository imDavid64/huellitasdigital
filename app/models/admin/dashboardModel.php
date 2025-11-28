<?php
namespace App\Models\Admin;

use App\Models\BaseModel;

class DashboardModel extends BaseModel
{
    // ======================================
    // MÉTRICAS PRINCIPALES
    // ======================================
    
    public function getCitasHoy()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_CITAS_HOY_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data['total_citas_hoy'] ?? 0;
    }

    public function getPedidosPendientes()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_PEDIDOS_PENDIENTES_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data['pedidos_pendientes'] ?? 0;
    }

    public function getTotalClientes()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_TOTAL_CLIENTES_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data['total_clientes'] ?? 0;
    }

    public function getStockBajo()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_STOCK_BAJO_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data['productos_stock_bajo'] ?? 0;
    }

    public function getClientesActivos()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_CLIENTES_ACTIVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data['clientes_activos'] ?? 0;
    }

    public function getProveedoresActivos()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_PROVEEDORES_ACTIVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data['proveedores_activos'] ?? 0;
    }

    public function getEstadisticasMensuales()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_ESTADISTICAS_MENSUALES_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    // ======================================
    // DATOS ADICIONALES PARA EL DASHBOARD
    // ======================================
    
    public function getProductosMasVendidos()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_PRODUCTOS_MAS_VENDIDOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    public function getUltimosPedidos()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_DASHBOARD_ULTIMOS_PEDIDOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }
}
?>
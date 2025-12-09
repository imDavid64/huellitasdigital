<?php
namespace App\Models\Admin;

use App\Models\BaseModel;

class OrderModel extends BaseModel
{

    //Buscar pedidos paginados
    public function searchOrdersPaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_PEDIDOS_ADMIN_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countOrders($query)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_CONTAR_PEDIDOS_SP(?)");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['TOTAL'] ?? 0;
    }

    //Ver detalle del pedido
    public function getOrderDetail($codigoPedido)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_VER_DETALLE_PEDIDO_SP(?)");
        $stmt->bind_param("s", $codigoPedido);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    // Cambiar estado
    public function updateOrderStatus($codigoPedido, $nuevoEstadoId)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_ESTADO_PEDIDO_SP(?, ?)");
        $stmt->bind_param("si", $codigoPedido, $nuevoEstadoId);
        return $stmt->execute();
    }

    public function updatePaymentStatus($idPago, $nuevoEstado)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_ESTADO_PAGO_SP(?, ?, @MENSAJE, @IDPEDIDO)");
        $stmt->bind_param("is", $idPago, $nuevoEstado);
        $stmt->execute();
        $stmt->close();

        // Obtener los valores OUT
        $result = $this->conn->query("SELECT @MENSAJE AS MENSAJE, @IDPEDIDO AS ID_PEDIDO");
        return $result->fetch_assoc();
    }

    public function getOrderByCode($codigoPedido)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_DETALLE_PEDIDO_SP(?)");
        $stmt->bind_param("s", $codigoPedido);
        $stmt->execute();

        // Primer resultset: encabezado
        $encabezado = $stmt->get_result()->fetch_assoc();

        // Avanzar al segundo resultset (detalle)
        $stmt->next_result();
        $productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return [
            'pedido' => $encabezado,
            'productos' => $productos
        ];
    }

    // Obtener comprobante de pago por código de pedido
    public function getPaymentProof($codigoPedido)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_COMPROBANTE_PAGO_SP(?)");
        $stmt->bind_param("s", $codigoPedido);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result ? $result->fetch_assoc() : null;

        $stmt->close();
        $this->conn->next_result();

        return $data;
    }


    public function updatePaymentProof($codigoPedido, $estado, $observaciones)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_COMPROBANTE_PAGO_SP(?, ?, ?, @EXITO, @MENSAJE)");
        $stmt->bind_param("sis", $codigoPedido, $estado, $observaciones);
        $stmt->execute();
        $stmt->close();

        $this->conn->next_result();

        $res = $this->conn
            ->query("SELECT @EXITO AS EXITO, @MENSAJE AS MENSAJE")
            ->fetch_assoc();

        return $res;
    }

    public function getPaymentByOrderCode($codigoPedido)
    {
        $sql = "CALL HUELLITAS_OBTENER_PAGO_POR_CODIGO_PEDIDO_SP(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $codigoPedido);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();
        return $row;
    }

}
?>
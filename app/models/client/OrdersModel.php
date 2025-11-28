<?php
namespace App\Models\Client;

use App\Models\BaseModel;
use mysqli_sql_exception;

class OrdersModel extends BaseModel
{
    public function getOrdersByUser($userId)
    {
        $sql = "CALL HUELLITAS_LISTAR_PEDIDOS_USUARIO_SP(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrdersByUserPaginated($userId, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PEDIDOS_USUARIO_PAG_SP(?, ?, ?)");
        $stmt->bind_param("iii", $userId, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalOrdersByUser($userId)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_CONTAR_PEDIDOS_USUARIO_SP(?)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (int) $result['total'];
    }

    public function getOrderDetail($codigoPedido)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_DETALLE_PEDIDO_SP(?)");
        $stmt->bind_param("s", $codigoPedido);
        $stmt->execute();

        $result1 = $stmt->get_result();
        $pedido = $result1->fetch_assoc();

        // Avanzar al siguiente conjunto de resultados
        $stmt->next_result();
        $result2 = $stmt->get_result();
        $productos = $result2->fetch_all(MYSQLI_ASSOC);

        return [
            'pedido' => $pedido,
            'productos' => $productos
        ];
    }

    public function cancelarPedido($pedidoId, $userId)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_CANCELAR_PEDIDO_SP(?, ?)");
            $stmt->bind_param("ii", $pedidoId, $userId);
            $stmt->execute();
            $stmt->close();
            $this->conn->next_result();
            return ['success' => true, 'message' => 'Pedido cancelado correctamente.'];
        } catch (mysqli_sql_exception $e) {
            return ['success' => false, 'message' => 'Error SQL: ' . $e->getMessage()];
        }
    }

    public function getLastPaymentProof($codigoPedido)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_ULTIMO_COMPROBANTE_SP(?)");
        $stmt->bind_param("s", $codigoPedido);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $this->conn->next_result();

        return $result;
    }


    public function uploadNewPaymentProof($codigoPedido, $userId, $urlComprobante)
    {
        $sql = "CALL HUELLITAS_SUBIR_NUEVO_COMPROBANTE_SP(?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sis", $codigoPedido, $userId, $urlComprobante);

        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result ? $result->fetch_assoc() : null;

        $stmt->close();
        $this->conn->next_result();

        if (!$data) {
            return [
                'success' => false,
                'message' => 'No se recibió respuesta del procedimiento.'
            ];
        }

        return [
            'success' => isset($data['EXITO']) ? ((int) $data['EXITO'] === 1) : false,
            'message' => $data['MENSAJE'] ?? 'Ocurrió un error desconocido.'
        ];
    }




}

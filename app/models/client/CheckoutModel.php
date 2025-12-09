<?php

namespace App\Models\Client;

use App\Models\BaseModel;

class CheckoutModel extends BaseModel
{
    public function procesarCheckout($userId, $direccion, $pago)
    {
        try {
            $tarjetaId = $pago['tarjeta_id'] ?? null;

            $stmt = $this->conn->prepare(
                "CALL HUELLITAS_PROCESAR_CHECKOUT_SP(?, ?, ?, ?, ?, ?, ?, ?, @p_pedido_id, @p_codigo)"
            );

            $stmt->bind_param(
                "isssssid",
                $userId,
                $direccion['provincia'],
                $direccion['canton'],
                $direccion['distrito'],
                $direccion['sennas'],
                $pago['metodo'],
                $tarjetaId,
                $pago['costo_envio']
            );

            $stmt->execute();
            $stmt->close();

            // Limpiar posibles resultsets pendientes del CALL
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            $res = $this->conn->query("SELECT @p_pedido_id AS pedido_id, @p_codigo AS codigo_pedido");
            $row = $res->fetch_assoc();

            return [
                'success' => true,
                'pedido_id' => (int) $row['pedido_id'],
                'codigo_pedido' => $row['codigo_pedido'],
            ];

        } catch (\mysqli_sql_exception $e) {
            return "SQL Error: " . $e->getMessage();
        }
    }

    public function registrarComprobantePago($pedidoId, $userId, $urlComprobante)
    {
        try {
            $stmt = $this->conn->prepare("
            CALL HUELLITAS_SUBIR_COMPROBANTE_PAGO_SP(?, ?, ?)
        ");

            $stmt->bind_param("iis", $pedidoId, $userId, $urlComprobante);
            $stmt->execute();

            do {
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    break;
                }
            } while ($stmt->more_results() && $stmt->next_result());

            $stmt->close();

            if (!isset($row)) {
                return [
                    'success' => false,
                    'message' => "No se obtuvo respuesta del procedimiento."
                ];
            }

            return [
                'success' => $row['EXITO'] == 1,
                'message' => $row['MENSAJE']
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => "SQL Error: " . $e->getMessage()
            ];
        }
    }


    public function getPaymentStatus($pedidoId)
    {
        $sql = "CALL HUELLITAS_OBTENER_ESTADO_PAGO_SP(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $pedidoId);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['ESTADO_PAGO'] ?? null;
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

}

<?php
namespace App\Models\Client;

use App\Models\BaseModel;

class CartModel extends BaseModel
{
    // Obtener carrito completo del usuario
    public function getCartByUser($userId)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_CARRITO_USUARIO_SP(?)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Agregar producto al carrito
    public function addToCart($userId, $productId, $cantidad)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_AGREGAR_AL_CARRITO_SP(?, ?, ?)");
            $stmt->bind_param("iii", $userId, $productId, $cantidad);
            $stmt->execute();
            $stmt->close();
            return ['success' => true];
        } catch (\mysqli_sql_exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    // Eliminar un producto específico del carrito
    public function removeItem($cartId)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ELIMINAR_ITEM_CARRITO_SP(?)");
        $stmt->bind_param("i", $cartId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Vaciar carrito completo
    public function clearCart($userId)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_VACIAR_CARRITO_SP(?)");
        $stmt->bind_param("i", $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Actualizar cantidad de un producto en el carrito
    public function updateQuantity($userId, $productId, $newQuantity)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_CANTIDAD_CARRITO_SP(?, ?, ?)");
            $stmt->bind_param("iii", $userId, $productId, $newQuantity);
            $stmt->execute();
            $stmt->close();
            return ['success' => true];
        } catch (\mysqli_sql_exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    // Calcular totales del carrito (subtotal, IVA, envío, total)
    public function calculateCartTotals($userId, $shippingCost = 2000)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_CALCULAR_TOTAL_CARRITO_SP(?, ?)");
        $stmt->bind_param("id", $userId, $shippingCost);
        $stmt->execute();
        $result = $stmt->get_result();
        $totals = $result->fetch_assoc();
        $stmt->close();
        return $totals ?: [
            'SUBTOTAL' => 0.00,
            'IVA' => 0.00,
            'ENVIO' => $shippingCost,
            'TOTAL_FINAL' => $shippingCost
        ];
    }


}

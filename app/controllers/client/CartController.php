<?php
namespace App\Controllers\Client;

use App\Models\Client\CartModel;
use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;

require_once __DIR__ . '/../../config/bootstrap.php';

class CartController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=index");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $cartModel = new CartModel();
        $productModel = new ProductModel();
        $serviceModel = new ServiceModel();

        $services = $serviceModel->getAllActiveServices();
        $categories = $productModel->getAllActiveCategories();
        $cartItems = $cartModel->getCartByUser($userId);
        $cartTotals = $cartModel->calculateCartTotals($userId, 2000);

        require __DIR__ . '/../../views/client/cart/cart.php';
    }

    // Agregar producto
    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Debe iniciar sesión antes de agregar al carrito.']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $productId = intval($_POST['productId'] ?? 0);
        $cantidad = intval($_POST['cantidad'] ?? 1);

        $cartModel = new CartModel();
        $result = $cartModel->addToCart($userId, $productId, $cantidad);

        // Ejemplo de estructura esperada por el front
        // $result debe tener ['success' => bool, 'message' => string]
        echo json_encode($result);
    }



    // Eliminar producto
    public function remove()
    {
        $cartId = $_POST['cartId'] ?? 0;

        $cartModel = new CartModel();
        $result = $cartModel->removeItem($cartId);
        echo json_encode(['success' => $result]);
    }

    // Vaciar carrito completo
    public function clear()
    {
        $userId = $_SESSION['user_id'];

        $cartModel = new CartModel();
        $result = $cartModel->clearCart($userId);
        echo json_encode(['success' => $result]);
    }

    // Actualizar cantidad de un producto en el carrito
    public function updateQuantity()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión.']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $productId = intval($_POST['productId'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);

        $cartModel = new CartModel();
        $result = $cartModel->updateQuantity($userId, $productId, $quantity);

        echo json_encode($result);
    }

    // Calcular totales del carrito
    public function totals()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $shipping = $_POST['shipping'] ?? 2000;

        $cartModel = new CartModel();
        $totals = $cartModel->calculateCartTotals($userId, $shipping);

        echo json_encode(['success' => true, 'data' => $totals]);
    }

}

<?php
namespace App\Controllers\Client;

use App\Models\Client\ProductModel;
use App\Models\Client\BrandModel;
use App\Models\Client\ServiceModel;

require_once __DIR__ . '/../../config/bootstrap.php';

class ProductController
{
    public function index()
    {
        $productModel = new ProductModel();
        $brandModel = new BrandModel();
        $serviceModel = new ServiceModel();

        $selectedCategory = isset($_GET['idCategoria']) ? (int) $_GET['idCategoria'] : null;

        $brands = $brandModel->getAllActiveBrands();
        $services = $serviceModel->getAllActiveServices();
        $categories = $productModel->getAllActiveCategories();

        // Si viene categoría, arranca ya filtrado
        if ($selectedCategory) {
            $products = $productModel->getFilteredProducts([$selectedCategory], []);
        } else {
            $products = $productModel->getAllActiveProducts();
        }

        // La vista ya usa $selectedCategory para marcar el checkbox
        require __DIR__ . '/../../views/client/products/products.php';
    }

    public function filterProducts()
    {
        $productModel = new ProductModel();

        $categories = $_POST['categories'] ?? [];
        $brands = $_POST['brands'] ?? [];

        $products = $productModel->getFilteredProducts($categories, $brands);
        $base_url = defined('BASE_URL') ? BASE_URL : '';

        require __DIR__ . '/../../views/client/products/partials/product-list.php';
    }


    public function searchProducts()
    {
        $productModel = new ProductModel();
        $query = $_GET['query'] ?? '';

        if (strlen($query) < 2) {
            echo json_encode([]);
            return;
        }

        $searchedProducts = $productModel->searchActiveProducts($query);
        echo json_encode($searchedProducts);
    }

    public function productsDetails()
    {
        $productModel = new ProductModel();
        $serviceModel = new ServiceModel();
        $id_product = intval($_GET['id'] ?? 0);

        $services = $serviceModel->getAllActiveServices();
        $categories = $productModel->getAllActiveCategories();
        $product = $productModel->getProductById($id_product);
        $comments = $productModel->getCommentsByProductId($id_product);
        $rating = $productModel->getProductRating($id_product);

        require __DIR__ . '/../../views/client/products/productDetail.php';
    }

    public function addComment()
    {
        $productModel = new ProductModel();

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(["success" => false, "error" => "Necesitas iniciar sesión"]);
            exit;
        }

        $productId = intval($_POST["id_producto"]);
        $userId = intval($_SESSION["user_id"]);
        $comment = trim($_POST["comentario"]);
        $rating = $_POST["calificacion"];

        $ok = $productModel->addComment($productId, $userId, $comment, $rating);

        echo json_encode(["success" => $ok]);
    }

    public function editComment()
    {
        $productModel = new ProductModel();
        $commentId = intval($_POST["id_comentario"]);
        $userId = intval($_SESSION["user_id"]);
        $comment = trim($_POST["comentario"]);
        $rating = $_POST["calificacion"];

        $ok = $productModel->updateComment($commentId, $userId, $comment, $rating);

        echo json_encode(["success" => $ok]);
    }

    public function deleteComment()
    {
        $productModel = new ProductModel();
        $commentId = intval($_POST["id_comentario"]);
        $userId = intval($_SESSION["user_id"]);

        $ok = $productModel->deleteComment($commentId, $userId);

        echo json_encode(["success" => $ok]);
    }


}

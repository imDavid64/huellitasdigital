<?php
require_once __DIR__ . "/../../models/client/productModel.php";
require_once __DIR__ . "/../../models/client/brandModel.php";
require_once __DIR__ . '/../../models/conexionDB.php';

$db = new ConexionDatabase();
$conn = $db->connectDB();
$productModel = new ProductModel($conn);
$brandModel = new BrandModel($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'index':
        $products = $productModel->getAllActiveProducts();
        $categories = $productModel->getAllNewAllActiveCategories();
        $brands = $brandModel->getAllActiveBrands();
        //Capturar la categoría seleccionada del navbar
        $selectedCategory = $_GET['idCategoria'] ?? null;
        require '../../views/client/products/products.php';
        break;

    case 'filterProducts':
        $categories = $_POST['categories'] ?? [];
        $brands = $_POST['brands'] ?? [];

        $filteredProducts = $productModel->getFilteredProducts($categories, $brands);

        // Renderizar solo el bloque HTML de los productos
        foreach ($filteredProducts as $product) {
            echo '
        <div class="cards product-item">
            <a href="/huellitasdigital/app/controllers/client/productController.php?action=productsDetails&id=' . $product['ID_PRODUCTO_PK'] . '">
                <div>
                    <div class="card-img">
                        <img src="' . htmlspecialchars($product['IMAGEN_URL']) . '" alt="' . htmlspecialchars($product['PRODUCTO_NOMBRE']) . '" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div class="card-name">' . htmlspecialchars($product['PRODUCTO_NOMBRE']) . '</div>
                    <div class="card-description product-description">' . htmlspecialchars($product['PRODUCTO_DESCRIPCION']) . '</div>
                </div>
            </a>
                <div class="card-price">₡' . htmlspecialchars($product['PRODUCTO_PRECIO_UNITARIO']) . '</div>
                <div class="card-button">
                    <a class="btn-orange" href="#">Añadir al Carrito</a>
                </div>
        </div>';
        }
        exit;

    case 'searchProducts':
        $query = $_GET['query'] ?? '';

        if (strlen($query) < 2) {
            echo json_encode([]); // no buscar si hay menos de 2 caracteres
            exit;
        }

        $searchedProducts = $productModel->searchActiveProducts($query);

        echo json_encode($searchedProducts);
        break;


    case 'productsDetails':
        $id_product = intval($_GET['id'] ?? 0);
        $product = $productModel->getProductById($id_product);
        $comments = $productModel->getCommentsByProductId($id_product);
        $categories = $productModel->getAllNewAllActiveCategories();
        require '../../views/client/products/productDetail.php';
        break;


    default:
        require '../../views/client/products/products.php';
}

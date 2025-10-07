<?php
session_start();
require_once __DIR__ . "/../../models/admin/productModel.php";
include_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/admin/catalogModel.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();
$productModel = new ProductModel($conn);
$catalogModel = new CatalogModel($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    // Dentro de tu switch en productController.php

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 1. Recoger todos los datos del formulario
            $id_product = intval($_POST['id_product']);
            $productname = trim($_POST['productname']);
            $productcategory = trim($_POST['productcategory']);
            $productprice = floatval($_POST['productprice']);
            $productstock = intval($_POST['productstock']);
            $productdescription = trim($_POST['productdescription']);
            $productsupplier = intval($_POST['productsupplier']);
            $state = intval($_POST['state']);
            $current_image_url = $_POST['current_image_url']; // URL de la imagen actual

            // 2. Lógica para manejar la imagen
            $new_image_url = $current_image_url; // Por defecto, mantenemos la imagen actual

            // Comprobamos si se subió un archivo nuevo y sin errores
            if (isset($_FILES['productimg']) && $_FILES['productimg']['error'] === UPLOAD_ERR_OK) {

                require_once __DIR__ . "/../../config/firebase.php";
                $firebase = new FirebaseConfig();

                // Sube la nueva imagen
                $tempFile = $_FILES['productimg']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['productimg']['name']);
                $uploaded_url = $firebase->uploadProductImage($tempFile, $fileName);

                if ($uploaded_url) {
                    // Si la subida fue exitosa, borramos la imagen anterior de Firebase
                    if (!empty($current_image_url)) {
                        $firebase->deleteImage($current_image_url);
                    }
                    // Usamos la nueva URL
                    $new_image_url = $uploaded_url;
                }
            }

            // 3. Actualizar la base de datos
            try {
                if ($productModel->updateProduct($id_product, $productsupplier, $state, $productname, $productdescription, $productcategory, $productprice, $productstock, $new_image_url)) {
                    $_SESSION['success'] = "✅ Producto actualizado correctamente.";
                } else {
                    $_SESSION['error'] = "❌ Error al actualizar el producto.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            // Redirigir de vuelta a la lista de productos
            header("Location: productController.php?action=index");
            exit;
        } else {
            die("❌ Acceso no permitido.");
        }
        break;

    case 'edit':
        $id_product = intval($_GET['id'] ?? 0);
        $product = $productModel->getProductById($id_product);
        $estados = $catalogModel->getAllEstados();
        $proveedores = $catalogModel->getAllProveedores();
        require __DIR__ . '/../../views/admin/product-mgmt/edit-product.php';
        break;

    case 'create':
        $estados = $catalogModel->getAllEstados();
        $proveedores = $catalogModel->getAllProveedores();
        require __DIR__ . "/../../views/admin/product-mgmt/add-product.php";
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $precio = floatval($_POST['precio']);
            $stock = intval($_POST['stock']);
            $id_proveedor = intval($_POST['proveedor']);
            $id_estado = intval($_POST['estado']);

            require_once __DIR__ . "/../../config/firebase.php";
            $firebase = new FirebaseConfig();

            $imagen_url = null;
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $tempFile = $_FILES['imagen']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['imagen']['name']);

                // Subir a Firebase y obtener URL
                $imagen_url = $firebase->uploadProductImage($tempFile, $fileName);
            }

            try {
                if ($productModel->addProduct($id_proveedor, $id_estado, $nombre, $descripcion, $precio, $stock, $imagen_url)) {
                    $_SESSION['success'] = "✅ Producto agregado correctamente.";
                } else {
                    $_SESSION['error'] = "❌ Error al agregar producto.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header("Location: productController.php?action=index");
            exit;
        }
        break;


    case 'index':

    default:
        $products = $productModel->getAllProducts();
        require __DIR__ . "/../../views/admin/product-mgmt/product-mgmt.php";
        break;
}

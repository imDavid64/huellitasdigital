<?php
require_once __DIR__ . "/../models/conexionDB.php";
require_once __DIR__ . '/client/sliderBannerController.php';
require_once __DIR__ . '/../models/client/productModel.php';
require_once __DIR__ . '/../models/client/brandModel.php';

$action = $_GET['action'] ?? 'index';

// Instancias
$db = new ConexionDatabase();
$conn = $db->connectDB();

$sliderController = new SliderBannerController();
$brandModel = new BrandModel($conn);
$productModel = new ProductModel($conn);

// Ejecutamos la acción correspondiente
switch ($action) {
    case 'index':
        // Obtener banners
        $banners = $sliderController->obtenerBanners();

        // Obtener marcas activas
        $brands = $brandModel->getAllActiveBrands();
        // Obtener productos activos
        $products = $productModel->getAllActiveProducts();
        // Obtener productos activos
        $newproducts = $productModel->getAllNewActiveProducts();

        // Cargar la vista principal del home
        require_once __DIR__ . '/../views/home.php';
        break;

    default:
        // Acción no válida → redirigir al inicio
        header("Location: /huellitasdigital/index.php");
        exit;
}

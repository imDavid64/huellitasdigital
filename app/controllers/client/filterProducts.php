<?php
require_once __DIR__ . "/../../models/client/productModel.php";
require_once __DIR__ . "/../../models/conexionDB.php";

header('Content-Type: application/json');

$db = new ConexionDatabase();
$conn = $db->connectDB();
$productModel = new ProductModel($conn);

$categories = $_POST['categories'] ?? [];
$brands = $_POST['brands'] ?? [];

// Llamar al modelo con los filtros seleccionados
$products = $productModel->getFilteredProducts($categories, $brands);

echo json_encode($products);

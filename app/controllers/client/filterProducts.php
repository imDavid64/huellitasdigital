<?php
namespace App\Controllers\Client;

use App\Models\Client\ProductModel;

require_once __DIR__ . '/../../config/bootstrap.php';

header('Content-Type: application/json');

$categories = $_POST['categories'] ?? [];
$brands = $_POST['brands'] ?? [];

$productModel = new ProductModel();

// Llamar al modelo con los filtros seleccionados
$products = $productModel->getFilteredProducts($categories, $brands);

echo json_encode($products);

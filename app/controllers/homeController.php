<?php
namespace App\Controllers;

use App\Models\Client\ProductModel;
use App\Models\Client\BrandModel;
use App\Models\Client\ServiceModel;
use App\Models\Client\SliderBannerModel;

require_once __DIR__ . '/../config/bootstrap.php';

class HomeController
{
    public function index()
    {
        $productModel = new ProductModel();
        $brandModel   = new BrandModel();
        $serviceModel = new ServiceModel();
        $sliderModel = new SliderBannerModel();

        $products = $productModel->getAllNewActiveProducts();
        $newproducts = $productModel->getAllNewActiveProducts();
        $categories = $productModel->getAllActiveCategories();
        $brands   = $brandModel->getAllActiveBrands();
        $services = $serviceModel->getAllActiveServices();
        $banners = $sliderModel->getAllActiveSliderBanner();

        require VIEW_PATH . '/home.php';
    }
}

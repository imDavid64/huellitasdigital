<?php
namespace App\Controllers\Admin;

use App\Models\Admin\ProductModel;
use App\Models\Admin\CatalogModel;
use App\Config\FirebaseConfig;

class AdminProductController
{
    private ProductModel $productModel;
    private CatalogModel $catalogModel;
    private FirebaseConfig $firebase;

    public function __construct()
    {
        // ✅ Solo ADMIN
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=index");
            exit;
        }

        $this->productModel = new ProductModel();
        $this->catalogModel = new CatalogModel();
        $this->firebase = new FirebaseConfig();
    }


    // ======================================
    // PRODUCTOS
    // ======================================

    public function index()
    {
        $query = $_GET['query'] ?? '';
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $products = $this->productModel->searchProductsPaginated($query, $limit, $offset);
        $total = $this->productModel->countProducts($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/product-mgmt/product-mgmt.php";
    }

    // ✅ Tabla AJAX
    public function search()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $products = $this->productModel->searchProductsPaginated($query, $limit, $offset);
        $total = $this->productModel->countProducts($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/product-mgmt/partials/product-table.php";
    }

    public function edit()
    {
        $id = intval($_GET['id'] ?? 0);
        if (!$id)
            exit("❌ ID inválido");

        $product = $this->productModel->getProductById($id);
        $estados = $this->catalogModel->getActiveInactiveStates();
        $proveedores = $this->catalogModel->getActiveProviders();
        $categorias = $this->productModel->getActiveCategories();
        $marcas = $this->catalogModel->getActiveBrands();
        $esNuevo = $this->catalogModel->getAllEsNuevo();

        require VIEW_PATH . "/admin/product-mgmt/edit-product.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            exit("❌ Acceso Denegado");

        $id = intval($_POST['id_product']);
        $proveedor = intval($_POST['productsupplier']);
        $estado = intval($_POST['state']);
        $categoria = intval($_POST['productcategory']);
        $marca = intval($_POST['productbrand']);
        $isnew = intval($_POST['productisnew']);
        $nombre = trim($_POST['productname']);
        $descripcion = trim($_POST['productdescription']);
        $precio = floatval($_POST['productprice']);
        $stock = intval($_POST['productstock']);
        $currentImage = $_POST['current_image_url'] ?? null;
        $newImage = $currentImage;

        if (!empty($_FILES['productimg']['tmp_name'])) {
            $file = $_FILES['productimg']['tmp_name'];
            $fileName = uniqid() . "_" . $_FILES['productimg']['name'];

            $uploadedUrl = $this->firebase->uploadProductImage($file, $fileName);

            if ($uploadedUrl) {
                if ($currentImage)
                    $this->firebase->deleteImage($currentImage);
                $newImage = $uploadedUrl;
            }
        }

        $ok = $this->productModel->updateProduct(
            $id,
            $proveedor,
            $estado,
            $categoria,
            $marca,
            $isnew,
            $nombre,
            $descripcion,
            $precio,
            $stock,
            $newImage
        );

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Producto actualizado" : "❌ Error al actualizar";

        header("Location: " . BASE_URL . "/index.php?controller=adminProduct&action=index");
        exit;
    }

    public function create()
    {
        $estados = $this->catalogModel->getActiveInactiveStates();
        $proveedores = $this->catalogModel->getActiveProviders();
        $categorias = $this->productModel->getActiveCategories();
        $marcas = $this->catalogModel->getActiveBrands();
        $esNuevo = $this->catalogModel->getAllEsNuevo();

        require VIEW_PATH . "/admin/product-mgmt/add-product.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            exit("❌ Acceso Denegado");

        $nombre = trim($_POST['nombre']);
        $descripcion = trim($_POST['descripcion']);
        $precio = floatval($_POST['precio']);
        $stock = intval($_POST['stock']);
        $proveedor = intval($_POST['proveedor']);
        $estado = intval($_POST['estado']);
        $categoria = intval($_POST['categoria']);
        $marca = intval($_POST['marca']);
        $nuevo = intval($_POST['nuevo']);

        $imgUrl = null;
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $file = $_FILES['imagen']['tmp_name'];
            $fileName = uniqid() . "_" . $_FILES['imagen']['name'];
            $imgUrl = $this->firebase->uploadProductImage($file, $fileName);
        }

        $ok = $this->productModel->addProduct(
            $proveedor,
            $estado,
            $categoria,
            $marca,
            $nuevo,
            $nombre,
            $descripcion,
            $precio,
            $stock,
            $imgUrl
        );

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Producto agregado" : "❌ Error al agregar";

        header("Location: " . BASE_URL . "/index.php?controller=adminProduct&action=index");
        exit;
    }


    // =================================================
    // ✅ CATEGORÍAS (CRUD + AJAX)
    // =================================================
    public function categoryMgmt()
    {
        $query = '';
        $page = 1;
        $limit = 10;
        $offset = 0;

        $categories = $this->productModel->searchCategoryPaginated($query, $limit, $offset);
        $totalPages = ceil($this->productModel->countCategories($query) / $limit);

        require VIEW_PATH . "/admin/product-mgmt/category-mgmt/category-mgmt.php";
    }

    public function searchCategory()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $categories = $this->productModel->searchCategoryPaginated($query, $limit, $offset);
        $totalPages = ceil($this->productModel->countCategories($query) / $limit);

        require VIEW_PATH . "/admin/product-mgmt/partials/category-table.php";
    }

    public function createCategory()
    {
        $estados = $this->catalogModel->getActiveInactiveStates();
        require VIEW_PATH . "/admin/product-mgmt/category-mgmt/add-category.php";
    }

    public function storeCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            exit("❌ Acceso Denegado");

        $nombre = trim($_POST['nombreCategoria']);
        $estado = intval($_POST['estado']);

        $ok = $this->productModel->addCategory($nombre, $estado);

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Categoría agregada" : "❌ Error al agregar";

        header("Location: " . BASE_URL . "/index.php?controller=adminProduct&action=categoryMgmt");
        exit;
    }

    public function editCategory()
    {
        $id = intval($_GET['id'] ?? 0);
        $categoria = $this->productModel->getCategoryById($id);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/admin/product-mgmt/category-mgmt/edit-category.php";
    }

    public function updateCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            exit("❌ Acceso Denegado");

        $id = intval($_POST['id_categoria']);
        $nombre = trim($_POST['categoryname']);
        $estado = intval($_POST['state']);

        $ok = $this->productModel->updateCategory($id, $estado, $nombre);

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Categoría actualizada" : "❌ Error al actualizar";

        header("Location: " . BASE_URL . "/index.php?controller=adminProduct&action=categoryMgmt");
        exit;
    }


    // =================================================
    // ✅ MARCAS (CRUD + AJAX + Imágenes)
    // =================================================
    public function brandMgmt()
    {
        $query = '';
        $page = 1;
        $limit = 10;
        $offset = 0;

        $brands = $this->productModel->searchBrandPaginated($query, $limit, $offset);
        $totalPages = ceil($this->productModel->countBrands($query) / $limit);

        require VIEW_PATH . "/admin/product-mgmt/brand-mgmt/brand-mgmt.php";
    }

    public function searchBrand()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $brands = $this->productModel->searchBrandPaginated($query, $limit, $offset);
        $totalPages = ceil($this->productModel->countBrands($query) / $limit);

        require VIEW_PATH . "/admin/product-mgmt/partials/brand-table.php";
    }

    public function createBrand()
    {
        $estados = $this->catalogModel->getActiveInactiveStates();
        require VIEW_PATH . "/admin/product-mgmt/brand-mgmt/add-brand.php";
    }

    public function storeBrand()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            exit("❌ Acceso Denegado");

        $nombre = trim($_POST['nombre']);
        $estado = intval($_POST['estado']);

        $imgUrl = null;
        if (!empty($_FILES['imagen']['tmp_name'])) {
            $file = $_FILES['imagen']['tmp_name'];
            $fileName = uniqid() . "_" . $_FILES['imagen']['name'];
            $imgUrl = $this->firebase->uploadBrandImage($file, $fileName);
        }

        $ok = $this->productModel->addBrand($nombre, $estado, $imgUrl);

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Marca agregada" : "❌ Error al agregar";

        header("Location: " . BASE_URL . "/index.php?controller=adminProduct&action=brandMgmt");
        exit;
    }

    public function editBrand()
    {
        $id = intval($_GET['id'] ?? 0);
        $marca = $this->productModel->getBrandById($id);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/admin/product-mgmt/brand-mgmt/edit-brand.php";
    }

    public function updateBrand()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("❌ Acceso no permitido.");
        }

        $id_marca = intval($_POST['id_brand']);
        $nombre = trim($_POST['brandname']);
        $estado = intval($_POST['state']);
        $current_image_url = $_POST['current_image_url'];

        $new_image_url = $current_image_url;

        // ✅ Subir nueva imagen si se seleccionó
        if (!empty($_FILES['brandimg']['tmp_name'])) {
            $file = $_FILES['brandimg']['tmp_name'];
            $fileName = uniqid() . "_" . $_FILES['brandimg']['name'];

            $uploadedUrl = $this->firebase->uploadBrandImage($file, $fileName);

            if ($uploadedUrl) {
                if (!empty($current_image_url)) {
                    $this->firebase->deleteImage($current_image_url);
                }
                $new_image_url = $uploadedUrl;
            }
        }

        // ✅ Ahora sí actualizamos en BD ✅
        $ok = $this->productModel->updateBrand($id_marca, $nombre, $estado, $new_image_url);

        $_SESSION[$ok ? "success" : "error"] =
            $ok ? "✅ Marca actualizada correctamente" : "❌ Error al actualizar la marca";

        header("Location: " . BASE_URL . "/index.php?controller=adminProduct&action=brandMgmt");
        exit;
    }
}

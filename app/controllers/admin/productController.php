<?php
require_once __DIR__ . "/../../models/admin/productModel.php";
require_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/admin/catalogModel.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();
$productModel = new ProductModel($conn);
$catalogModel = new CatalogModel($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'search':
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $products = $productModel->searchProductsPaginated($query, $limit, $offset);
        $total = $productModel->countProducts($query);
        $totalPages = ceil($total / $limit);

        // Si es AJAX, devolver solo tabla + paginación
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            require __DIR__ . "/../../views/admin/product-mgmt/partials/product-table.php";
            exit;
        }

        require __DIR__ . "/../../views/admin/product-mgmt/product-mgmt.php";
        break;



    case 'searchCategory':
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $categories = $productModel->searchCategoryPaginated($query, $limit, $offset);
        $total = $productModel->countProducts($query);
        $totalPages = ceil($total / $limit);

        // Si es AJAX, devolver solo tabla + paginación
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            require __DIR__ . "/../../views/admin/product-mgmt/partials/category-table.php";
            exit;
        }

        require __DIR__ . "/../../views/admin/product-mgmt/category-mgmt/category-mgmt.php";
        break;

    case 'searchBrand':
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $brands = $productModel->searchBrandPaginated($query, $limit, $offset);
        $total = $productModel->countProducts($query);
        $totalPages = ceil($total / $limit);

        // Si es AJAX, devolver solo tabla + paginación
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            require __DIR__ . "/../../views/admin/product-mgmt/partials/brand-table.php";
            exit;
        }

        require __DIR__ . "/../../views/admin/product-mgmt/brand-mgmt/brand-mgmt.php";
        break;


    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 1. Recoger todos los datos del formulario
            $id_product = intval($_POST['id_product']);
            $productname = trim($_POST['productname']);
            $productprice = floatval($_POST['productprice']);
            $productstock = intval($_POST['productstock']);
            $productdescription = trim($_POST['productdescription']);
            $state = intval($_POST['state']);
            $brand = intval($_POST['productbrand']);
            $category = intval($_POST['productcategory']);
            $productsupplier = intval($_POST['productsupplier']);
            $isnew = intval($_POST['productisnew']);
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
                $result = $productModel->updateProduct(
                    $id_product,            // ID producto
                    $productsupplier,       // ID proveedor
                    $state,                 // ID estado
                    $category,              // ID categoría
                    $brand,                 // ID marca
                    $isnew,                 // ID nuevo
                    $productname,           // Nombre
                    $productdescription,    // Descripción
                    $productprice,          // Precio
                    $productstock,          // Stock
                    $new_image_url          // Imagen
                );

                if ($result) {
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
        $categorias = $catalogModel->getAllCategorias();
        $marcas = $catalogModel->getAllMarcas();
        $esNuevo = $catalogModel->getAllEsNuevo();
        require __DIR__ . '/../../views/admin/product-mgmt/edit-product.php';
        break;

    case 'create':
        $estados = $catalogModel->getAllEstados();
        $proveedores = $catalogModel->getAllProveedores();
        $categorias = $catalogModel->getAllCategorias();
        $marcas = $catalogModel->getAllMarcas();
        $esNuevo = $catalogModel->getAllEsNuevo();
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
            $id_categoria = intval($_POST['categoria']);
            $id_marca = intval($_POST['marca']);
            $id_nuevo = intval($_POST['nuevo']);

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
                if ($productModel->addProduct($id_proveedor, $id_estado, $id_categoria, $id_marca, $id_nuevo, $nombre, $descripcion, $precio, $stock, $imagen_url)) {
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

    case 'categoryMgmt':
        $query = ''; // sin filtro
        $page = 1;
        $limit = 10;
        $offset = 0;

        $categories = $productModel->searchCategoryPaginated($query, $limit, $offset);
        $total = $productModel->countCategories($query);
        $totalPages = ceil($total / $limit);
        require __DIR__ . "/../../views/admin/product-mgmt/category-mgmt/category-mgmt.php";
        break;

    case 'createCategory':
        $estados = $catalogModel->getAllEstados();
        require __DIR__ . "/../../views/admin/product-mgmt/category-mgmt/add-category.php";
        break;

    case 'storeCategory':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombreCategoria = trim($_POST['nombreCategoria']);
            $estado = $_POST['estado'];

            try {
                if ($productModel->addCategory($nombreCategoria, $estado)) {
                    $_SESSION['success'] = "✅ Categoría agregada correctamente.";
                } else {
                    $_SESSION['error'] = "❌ Error al agregar categoría.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header("Location: productController.php?action=categoryMgmt");
            exit;
        }

    case 'editCategory':
        $id_category = intval($_GET['id'] ?? 0);
        $categoria = $productModel->getCategoryById($id_category);
        $estados = $catalogModel->getAllEstados();
        require __DIR__ . '/../../views/admin/product-mgmt/category-mgmt/edit-category.php';
        break;

    case 'updateCategory':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_categoria = intval($_POST['id_categoria']);
            $nombreCategoria = trim($_POST['categoryname']);
            $estado = intval($_POST['state']);

            try {
                if ($productModel->updateCategory($id_categoria, $estado, $nombreCategoria)) {
                    $_SESSION['success'] = "✅ Categoría actualizada correctamente.";
                } else {
                    $_SESSION['error'] = "❌ Error al actualizar la categoría.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header("Location: productController.php?action=categoryMgmt");
            exit;
        } else {
            die("❌ Acceso no permitido.");
        }
        break;

    case 'brandMgmt':
        $query = ''; // sin filtro
        $page = 1;
        $limit = 10;
        $offset = 0;

        $brands = $productModel->searchBrandPaginated($query, $limit, $offset);
        $total = $productModel->countBrands($query);
        $totalPages = ceil($total / $limit);
        require __DIR__ . "/../../views/admin/product-mgmt/brand-mgmt/brand-mgmt.php";
        break;

    case 'createBrand':
        $estados = $catalogModel->getAllEstados();
        require __DIR__ . "/../../views/admin/product-mgmt/brand-mgmt/add-brand.php";
        break;

    case 'storeBrand':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['nombre']);
            $estado = intval($_POST['estado']);

            require_once __DIR__ . "/../../config/firebase.php";
            $firebase = new FirebaseConfig();

            $imagen_url = null;
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $tempFile = $_FILES['imagen']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['imagen']['name']);

                // Subir a Firebase y obtener URL
                $imagen_url = $firebase->uploadBrandImage($tempFile, $fileName);
            }

            try {
                if ($productModel->addBrand($nombre, $estado, $imagen_url)) {
                    $_SESSION['success'] = "✅ Marca agregada correctamente.";
                } else {
                    $_SESSION['error'] = "❌ Error al agregar marca.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header("Location: productController.php?action=brandMgmt");
            exit;
        }

    case 'editBrand':
        $id_marca = intval($_GET['id'] ?? 0);
        $marca = $productModel->getBrandById($id_marca);
        $estados = $catalogModel->getAllEstados();
        require __DIR__ . '/../../views/admin/product-mgmt/brand-mgmt/edit-brand.php';
        break;

    case 'updateBrand':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_marca = intval($_POST['id_brand']);
            $nombre = trim($_POST['brandname']);
            $estado = intval($_POST['state']);
            $current_image_url = $_POST['current_image_url']; // URL de la imagen actual

            // 2. Lógica para manejar la imagen
            $new_image_url = $current_image_url; // Por defecto, mantenemos la imagen actual

            // Comprobamos si se subió un archivo nuevo y sin errores
            if (isset($_FILES['brandimg']) && $_FILES['brandimg']['error'] === UPLOAD_ERR_OK) {

                require_once __DIR__ . "/../../config/firebase.php";
                $firebase = new FirebaseConfig();

                // Sube la nueva imagen
                $tempFile = $_FILES['brandimg']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['brandimg']['name']);
                $uploaded_url = $firebase->uploadBrandImage($tempFile, $fileName);

                if ($uploaded_url) {
                    // Si la subida fue exitosa, borramos la imagen anterior de Firebase
                    if (!empty($current_image_url)) {
                        $firebase->deleteImage($current_image_url);
                    }
                    // Usamos la nueva URL
                    $new_image_url = $uploaded_url;
                }
            }

            try {
                if ($productModel->updateBrand($id_marca, $nombre, $estado, $new_image_url)) {
                    $_SESSION['success'] = "✅ Marca actualizada correctamente.";
                } else {
                    $_SESSION['error'] = "❌ Error al actualizar la marca.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header("Location: productController.php?action=brandMgmt");
            exit;
        } else {
            die("❌ Acceso no permitido.");
        }

    case 'index':

    default:
        $query = ''; // sin filtro
        $page = 1;
        $limit = 10;
        $offset = 0;

        $products = $productModel->searchProductsPaginated($query, $limit, $offset);
        $total = $productModel->countProducts($query);
        $totalPages = ceil($total / $limit);

        require __DIR__ . "/../../views/admin/product-mgmt/product-mgmt.php";
        break;
}

<?php
//NO QUITAR//
require_once __DIR__ . '/../../../config/bootstrap.php';
//NO QUITAR//
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- SweetAlert2 local -->
    <script src="<?= BASE_URL ?>/public/js/libs/sweetalert2.all.min.js"></script>
    <!-- JQuery y script.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>/public/js/script.js"></script>
</head>

<body>
    <!--HEADER-->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="static-banner">
            <img src="<?= BASE_URL ?>/public/assets/images/static-banners/img-banner-products-4.png" alt="Banner">
            <span class="tittle-static-banner">Productos</span>
        </section>
        <!--Breadcrumb-->
        <nav class="breadcrumbs-container-client">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a>
                </li>
                <li class="breadcrumb-item current-page">Productos</li>
            </ol>
        </nav>
        <section class="main-content">
            <div class="pages-product-content">
                <div class="filter-container">
                    <span><strong>Filtros</strong></span>
                    <hr />
                    <div class="filter-main-content">
                        <span class="filter-subtitle"><strong>Categoría</strong></span>
                        <div>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <div class="checkbox-container">
                                        <input type="checkbox" class="filter-category"
                                            value="<?= htmlspecialchars($category['ID_CATEGORIA_PK']) ?>"
                                            <?= (isset($selectedCategory) && $selectedCategory == $category['ID_CATEGORIA_PK']) ? 'checked' : '' ?>>
                                        <span><?= htmlspecialchars($category['DESCRIPCION_CATEGORIA']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay categorias disponibles.</p>
                            <?php endif; ?>
                            <hr />
                        </div>


                        <span class="filter-subtitle"><strong>Marcas</strong></span>
                        <?php if (!empty($brands)): ?>
                            <?php foreach ($brands as $brand): ?>
                                <div class="checkbox-container">
                                    <input type="checkbox" class="filter-brand"
                                        value="<?= htmlspecialchars($brand['ID_MARCA_PK']) ?>">
                                    <span><?= htmlspecialchars($brand['NOMBRE_MARCA']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay marcas disponibles.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <div class="tittles">
                        <div>
                            <h1><strong>Nuestros Productos</strong></h1>
                        </div>
                        <!--Filtro de mayor a menor y viceversa-->
                        <!--NO disponible
                        <div>
                            <button class="btn-filter-sortBy" id="btn-filter-sortBy"><strong>Ordenar Por:
                                </strong>Precio <i id="rotate-sortBy-icon"
                                    class="bi bi-chevron-down rotate-sortBy-icon"></i></button>
                            <div id="dropdown-menu" class="dropdown-menu">
                                <a href="#">Precio: Menor a Mayor</a>
                                <a href="#">Precio: Mayor a Menor</a>
                                <a href="#">Más Vendidos</a>
                            </div>
                        </div>
                        -->
                    </div>

                    <!--Listar todo los productos activos-->
                    <div class="cards-list-main-catalog">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="cards product-item">
                                    <a
                                        href="<?= BASE_URL ?>/index.php?controller=product&action=productsDetails&id=<?= $product['ID_PRODUCTO_PK'] ?>">
                                        <div>
                                            <div class="card-img">
                                                <img src="<?= htmlspecialchars($product['IMAGEN_URL'] ?? 'assets/images/no-img.png') ?>"
                                                    alt="<?= htmlspecialchars($product['NOMBRE_PRODUCTO'] ?? '') ?>"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            </div>
                                            <div class="card-name">
                                                <?= htmlspecialchars($product['PRODUCTO_NOMBRE'] ?? 'Sin nombre') ?>
                                            </div>
                                            <div class="card-description product-description">
                                                <?= htmlspecialchars($product['PRODUCTO_DESCRIPCION'] ?? '') ?>
                                            </div>
                                        </div>
                                        <div class="card-price">
                                            ₡<?= number_format($product['PRODUCTO_PRECIO_UNITARIO'], 2, ',', '.' ?? 'Sin precio') ?>
                                        </div>
                                    </a>
                                    <div class="card-button">
                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <button class="btn-orange btnAddToCart"
                                                data-id="<?= htmlspecialchars($product['ID_PRODUCTO_PK']) ?>"
                                                <?= ($product['PRODUCTO_STOCK'] <= 0 ? 'disabled' : '') ?>>
                                                <?= ($product['PRODUCTO_STOCK'] <= 0 ? 'Sin stock' : 'Añadir al Carrito') ?>
                                            </button>
                                        <?php else: ?>
                                            <a class="btn-orange btnLogin" href="#">Añadir al Carrito</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay productos disponibles.</p>
                        <?php endif; ?>
                    </div>
                </div>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOODER-->
<?php require_once __DIR__ . "/../partials/fooder.php"; ?>
<!--FOODER-->

</html>
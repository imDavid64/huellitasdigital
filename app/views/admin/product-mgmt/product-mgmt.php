<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->


    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>
            <section class="admin-main-content">
                <div>
                    <!--Breadcrumb-->
                    <nav class="breadcrumbs-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a
                                    href="/huellitasdigital/app/controllers/admin/dashboardController.php?action=index">Inicio</a>
                            </li>
                            <li class="breadcrumb-item current-page">Gestión de Productos</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-box2-fill"></i><strong> Gestión de Productos</strong></h2>
                        <div>
                            <a href="/huellitasdigital/app/controllers/admin/productController.php?action=create"
                                class="btn-blue"><strong>Agregar Producto</strong>
                                <i class="bi bi-bag-plus-fill"></i></a>
                        </div>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div class="search-container">
                        <div class="search">
                            <input type="text" class="admin-search-input" data-target="product"
                                placeholder="Buscar producto...">
                            <i class="bi bi-search"></i>
                        </div>

                        <div class="mgmt-header-buttons">
                            <a href="/huellitasdigital/app/controllers/admin/productController.php?action=categoryMgmt"
                                class="btn-dark-blue"><strong>Gestionar Categorías</strong>
                                <i class="bi bi-collection-fill"></i></a>
                            <a href="/huellitasdigital/app/controllers/admin/productController.php?action=brandMgmt"
                                class="btn-dark-blue"><strong>Gestionar Marcas</strong>
                                <i class="bi bi-sticky-fill"></i></a>
                            <a href="/huellitasdigital/app/controllers/admin/productController.php?action=addDiscount"
                                class="btn-dark-blue"><strong>Agregar Descuento</strong>
                                <i class="bi bi-tag-fill">+</i></a>
                        </div>
                    </div>
                    <div class="admin-mgmt-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Estado</th>
                                    <th class="text-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($product['ID_PRODUCTO_PK']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <img src="<?= htmlspecialchars($product['IMAGEN_URL']) ?>"
                                                style="min-width: 70px; min-height: 70px; max-width: 70px; max-height: 70px;">
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($product['PRODUCTO_NOMBRE']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($product['CATEGORIA']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">₡<?= $product['PRODUCTO_PRECIO_UNITARIO'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($product['PRODUCTO_STOCK']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($product['PRODUCTO_DESCRIPCION']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($product['PROVEEDOR']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit"><?= htmlspecialchars($product['ESTADO']) ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" product="group">
                                                <a href="/huellitasdigital/app/controllers/admin/productController.php?action=edit&id=<?= $product['ID_PRODUCTO_PK'] ?>"
                                                    class="btn btn-dark-blue btn-sm">
                                                    Editar <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <?php if ($totalPages > 1): ?>
                            <div class="pagination-container text-center mt-3">
                                <ul class="pagination justify-content-center">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                            <a class="page-link pagination-link" href="#" data-page="<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </section>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOOTER-->
<footer>
    <div class="post-footer" style="background-color: #002557; color: white;">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>
<!--FOOTER-->


</html>
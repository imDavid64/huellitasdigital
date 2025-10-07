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
                    <div class="tittles">
                        <h2><i class="bi bi-box2-fill"></i><strong> Gestión de Productos</strong></h2>
                        <div>
                            <a href="/huellitasdigital/app/controllers/admin/productController.php?action=create"
                                class="btn-dark-blue"><strong>Agregar Descuento</strong>
                                <i class="bi bi-tag"></i></a>
                            <a href="/huellitasdigital/app/controllers/admin/productController.php?action=create"
                                class="btn-blue"><strong>Agregar Producto</strong>
                                <i class="bi bi-bag-plus-fill"></i></a>
                        </div>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div>
                        <div class="search">
                            <input type="text" id="header-search" placeholder="Buscar producto...">
                            <i class="bi bi-search"></i>
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
                                        <td><?= $product['ID_PRODUCTO_PK'] ?></td>
                                        <td><img src="<?= htmlspecialchars($product['IMAGEN_URL']) ?>"
                                                style="min-width: 70px; min-height: 70px; max-width: 70px; max-height: 70px;">
                                        </td>
                                        <td><?= htmlspecialchars($product['PRODUCTO_NOMBRE']) ?></td>
                                        <td><?= htmlspecialchars($product['CATEGORIA']) ?></td>
                                        <td>₡<?= $product['PRODUCTO_PRECIO_UNITARIO'] ?></td>
                                        <td><?= $product['PRODUCTO_STOCK'] ?></td>
                                        <td><?= htmlspecialchars($product['PRODUCTO_DESCRIPCION']) ?></td>
                                        <td><?= htmlspecialchars($product['PROVEEDOR']) ?></td>
                                        <td><?= htmlspecialchars($product['ESTADO']) ?></td>
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
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
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
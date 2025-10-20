<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<?php include_once __DIR__ . "/../../partials/adminHead.php"; ?>

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../../partials/header.php"; ?>
    <!--HEADER-->


    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/../../partials/asideMenu.php"; ?>
            <section class="admin-main-content">
                <div>
                    <!--Breadcrumb-->
                    <nav class="breadcrumbs-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a
                                    href="/huellitasdigital/app/controllers/admin/dashboardController.php?action=index">Inicio</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/huellitasdigital/app/controllers/admin/productController.php?action=index">Gestión
                                    de Productos</a>
                            </li>
                            <li class="breadcrumb-item current-page">Gestión de Categorías</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-collection-fill"></i><strong> Gestión de Categorías</strong></h2>
                        <div>
                            <a href="/huellitasdigital/app/controllers/admin/productController.php?action=createCategory"
                                class="btn-blue"><strong>Agregar Categoría</strong>
                                <i class="bi bi-collection-fill"></i><strong>+</strong></a>
                        </div>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div class="search-container">
                        <div class="search">
                            <input type="text" class="admin-search-input" data-target="category"
                                placeholder="Buscar categoría...">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                    <div class="admin-mgmt-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estado</th>
                                    <th class="text-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= $category['ID_CATEGORIA_PK'] ?></td>
                                        <td><?= htmlspecialchars($category['DESCRIPCION_CATEGORIA']) ?></td>
                                        <td><?= htmlspecialchars($category['ESTADO']) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group" category="group">
                                                <a href="/huellitasdigital/app/controllers/admin/productController.php?action=editCategory&id=<?= $category['ID_CATEGORIA_PK'] ?>"
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
<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<?php include_once __DIR__ . "/../../partials/adminHead.php"; ?>

<body data-error="<?= $_SESSION['error'] ?? '' ?>" data-success="<?= $_SESSION['success'] ?? '' ?>">
    <?php unset($_SESSION['error'], $_SESSION['success']); ?>

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
                                <a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">Inicio</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=index">Gestión
                                    de Productos</a>
                            </li>
                            <li class="breadcrumb-item current-page">Gestión de Marcas</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-sticky-fill"></i><strong> Gestión de Marcas</strong></h2>
                        <div>
                            <a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=createBrand"
                                class="btn-blue"><strong>Agregar Marca</strong>
                                <i class="bi bi-sticky-fill"></i><strong>+</strong></a>
                        </div>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div class="search-container">
                        <div class="search">
                            <input type="text" class="admin-search-input" data-target="brand"
                                placeholder="Buscar marca...">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                    <div class="admin-mgmt-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estado</th>
                                    <th class="text-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($brands as $brand): ?>
                                    <tr>
                                        <td><?= $brand['ID_MARCA_PK'] ?></td>
                                        <td><img src="<?= htmlspecialchars($brand['MARCA_IMAGEN_URL']) ?>"
                                                style="min-width: 70px; min-height: 70px; max-width: 70px; max-height: 70px;">
                                        </td>
                                        <td><?= htmlspecialchars($brand['NOMBRE_MARCA']) ?></td>
                                        <td><?= htmlspecialchars($brand['ESTADO']) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group" brand="group">
                                                <a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=editBrand&id=<?= $brand['ID_MARCA_PK'] ?>"
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
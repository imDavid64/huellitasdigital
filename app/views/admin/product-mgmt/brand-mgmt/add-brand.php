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
            <section class="admin-main-content-add-user">
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
                            <li class="breadcrumb-item current-page">Agregar Marca</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-sticky-fill"></i><strong>+</strong><strong>Agregar Marca</strong></h2>
                        <div></div>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="/huellitasdigital/app/controllers/admin/productController.php?action=storeBrand"
                        method="POST" enctype="multipart/form-data">
                        <div class="form-container">

                            <div class="form-item">
                                <label for="nombre">Nombre de la Marca</label>
                                <input type="text" id="nombre" name="nombre" required>
                            </div>

                            <div class="form-item">
                                <label for="imagen">Imagen del Producto</label>
                                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                            </div>

                            <div class="form-item">
                                <label for="estado">Estado</label>
                                <select id="estado" name="estado" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>">
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn-blue"><strong>Agregar Producto</strong><i
                                    class="bi bi-bag-plus-fill"></i></button>
                        </div>
                    </form>
                </div>
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
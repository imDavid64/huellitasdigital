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
                            <li class="breadcrumb-item current-page">Editar Marca</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-pencil-square"></i><strong> Editar Marca</strong></h2>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="/huellitasdigital/app/controllers/admin/productController.php?action=updateBrand"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_brand" value="<?= $marca['ID_MARCA_PK'] ?>">
                        <input type="hidden" name="current_image_url"
                            value="<?= htmlspecialchars($marca['MARCA_IMAGEN_URL']) ?>">
                        <div class="form-container">
                            <div class="form-item">
                                <label for="brandname">Nombre de la Categoría</label>
                                <input type="text" id="brandname" name="brandname"
                                    value="<?= htmlspecialchars($marca['NOMBRE_MARCA']) ?>" required>
                            </div>
                            <div class="form-item">
                                <label for="brandimg">Cambiar Logo de la Marca (Opcional)</label>
                                <input type="file" id="brandimg" name="brandimg" accept="image/*">
                            </div>
                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= $marca['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn-dark-blue"><strong>Guardar Cambios</strong><i
                                    class="bi bi-floppy2"></i></button>
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
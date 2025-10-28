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
                <!--Breadcrumb-->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=admin&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=index">Configuración
                                General</a>
                        </li>
                        <li class="breadcrumb-item current-page">Agregar Slider/Banner</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-file-earmark-plus-fill"></i><strong>Agregar Slider/Banner</strong></h2>
                    <div></div>
                </div>
                <div class="admin-form-container">
                    <form action="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=storeSliderBanner"
                        method="POST" enctype="multipart/form-data">
                        <div class="form-container">
                            <div class="form-item">
                                <label for="imagen">Slider/Banner</label>
                                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                                <span><strong>Importante:</strong> La imagen debe tener una tamaño de "1080x300"</span>
                            </div>
                            <div class="form-item">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" name="descripcion" required></textarea>
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
                            <button type="submit" class="btn-blue"><strong>Agregar Slider/Banner</strong><i
                                    class="bi bi-file-earmark-plus"></i></button>
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
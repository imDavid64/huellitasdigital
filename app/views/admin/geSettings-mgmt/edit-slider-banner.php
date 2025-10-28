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
                        <li class="breadcrumb-item current-page">Editar Slider/Banner</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-pencil-square"></i><strong>Editar Slider/Banner</strong></h2>
                    <div></div>
                </div>

                <div class="admin-form-container">
                    <form action="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=updateSliderBanner"
                        method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="id_sliderbanner"
                            value="<?= htmlspecialchars($sliderbanner['ID_SLIDER_BANNER_PK']) ?>">
                        <input type="hidden" name="current_image_url"
                            value="<?= htmlspecialchars($sliderbanner['IMAGEN_URL']) ?>">

                        <div class="form-container">
                            <div class="form-item">
                                <img id="imagePreview" class="image-preview"
                                    src="<?= htmlspecialchars($sliderbanner['IMAGEN_URL']) ?>"
                                    alt="Imagen del Slider/Banner"
                                    style="width: 500px; height: 138.88px; display: block; margin-bottom: 10px;">
                            </div>
                            <div class="form-item">
                                <label for="sliderbannerimagen">Cambiar Imagen (Opcional)</label>
                                <input type="file" id="sliderbannerimagen" class="image-input" name="sliderbannerimagen"
                                    accept="image/*">
                                <span><strong>Importante:</strong> La imagen debe tener una tamaño de "1080x300"</span>
                            </div>
                            <div class="form-container">
                                <div class="form-item">
                                    <label for="sliderbannerdescription">Descripción</label>
                                    <textarea id="sliderbannerdescription" name="sliderbannerdescription"
                                        required><?= htmlspecialchars($sliderbanner['DESCRIPCION_SLIDER_BANNER']) ?></textarea>
                                </div>
                                <div class="form-item">
                                    <label for="state">Estado</label>
                                    <select id="state" name="state" required>
                                        <option value="" disabled>Seleccione un estado</option>
                                        <?php foreach ($estados as $estado): ?>
                                            <option value="<?= htmlspecialchars($estado['ID_ESTADO_PK']) ?>"
                                                <?= $sliderbanner['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small id="stateError" style="color:red; display:none;">
                                        Debe seleccionar un estado válido.
                                    </small>
                                </div>
                                <button type="submit" class="btn-blue"><strong>Guardar Cambios</strong>
                                    <i class="bi bi-pencil-square"></i></button>
                            </div>
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
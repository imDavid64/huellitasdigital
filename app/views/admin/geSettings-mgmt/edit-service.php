<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>

<body data-error="<?= $_SESSION['error'] ?? '' ?>" data-success="<?= $_SESSION['success'] ?? '' ?>">
    <?php unset($_SESSION['error'], $_SESSION['success']); ?>

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
                            <a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=index">Configuración
                                General</a>
                        </li>
                        <li class="breadcrumb-item current-page">Editar Servicio</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-pencil-square"></i><strong>Editar Servicio</strong></h2>
                    <div></div>
                </div>

                <div class="admin-form-container">
                    <form action="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=updateService"
                        method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="id_servicio"
                            value="<?= htmlspecialchars($servicio['ID_SERVICIO_PK']) ?>">
                        <input type="hidden" name="current_image_url"
                            value="<?= htmlspecialchars($servicio['IMAGEN_URL']) ?>">

                        <div class="form-container">
                            <div class="form-item">
                                <img id="imagePreview" class="image-preview"
                                    src="<?= htmlspecialchars($servicio['IMAGEN_URL']) ?>" alt="Imagen del Servicio"
                                    style="width: 100px; height: 100px; display: block; margin-bottom: 10px;">
                            </div>
                            <div class="form-item">
                                <label for="imagen_servicio">Cambiar Imagen (Opcional)</label>
                                <input type="file" id="imagen_servicio" class="image-input" name="imagen_servicio"
                                    accept="image/*">
                                <span><strong>Importante:</strong> La imagen debe tener una tamaño de "500x500"</span>
                            </div>
                            <div class="form-container">
                                <div class="form-item">
                                    <label for="nombre_servicio">Nombre del Servicio</label>
                                    <input type="text" id="nombre_servicio" name="nombre_servicio"
                                        value="<?= htmlspecialchars($servicio['NOMBRE_SERVICIO']) ?>" required>
                                </div>
                                <div class="form-item">
                                    <label for="descripcion_servicio">Descripción</label>
                                    <textarea id="descripcion_servicio" name="descripcion_servicio"
                                        required><?= htmlspecialchars($servicio['DESCRIPCION_SERVICIO']) ?></textarea>
                                </div>
                                <div class="form-item">
                                    <label for="estado_servicio">Estado</label>
                                    <select id="estado_servicio" name="estado_servicio" required>
                                        <option value="" disabled>Seleccione un estado</option>
                                        <?php foreach ($estados as $estado): ?>
                                            <option value="<?= htmlspecialchars($estado['ID_ESTADO_PK']) ?>"
                                                <?= $servicio['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
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
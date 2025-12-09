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
                <div>
                    <!--Breadcrumb-->
                    <nav class="breadcrumbs-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">Inicio</a>
                            </li>
                            <li class="breadcrumb-item current-page">Configuración General</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-gear-fill"></i><strong> Configuración General</strong></h2>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <!--Gestión de Silder Banner-->
                    <div class="subtitles mb-3 d-flex justify-content-between align-items-center">
                        <h3><i class="bi bi-images"></i> Gestión de Slider/Banner</h3>
                        <div>
                            <a href="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=createSliderBanner"
                                class="btn-blue"><strong>Agregar Slider/Banner</strong>
                                <i class="bi bi-image-fill"><strong>+</strong></i></a>
                        </div>
                    </div>
                    <div class="admin-mgmt-table mb-5">
                        <table class="table table-header-fixed">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Estado</th>
                                    <th class="text-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="table-body-scroll">
                                <?php foreach ($sliderbanners as $sliderbanner): ?>
                                    <tr>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($sliderbanner['ID_SLIDER_BANNER_PK']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <img src="<?= htmlspecialchars($sliderbanner['IMAGEN_URL']) ?>"
                                                    style="min-height: 60px; max-height: 60px;">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($sliderbanner['DESCRIPCION_SLIDER_BANNER']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($sliderbanner['ESTADO']) ?>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=editSliderBanner&id=<?= $sliderbanner['ID_SLIDER_BANNER_PK'] ?>"
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
                    <hr>
                    <!--Gestión de Servicios-->
                    <div class="subtitles mb-3 d-flex justify-content-between align-items-center">
                        <h3><i class="bi bi-file-earmark-medical"></i> Gestión de Servicios</h3>
                        <div>
                            <a href="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=createService"
                                class="btn-blue"><strong>Agregar Servicio</strong>
                                <i class="bi bi-file-earmark-medical-fill"><strong>+</strong></i></a>
                        </div>
                    </div>
                    <div class="admin-mgmt-table mb-3">
                        <table class="table table-header-fixed">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Estado</th>
                                    <th class="text-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                        </table>

                        <!-- Contenedor scroll solo del body -->
                        <div class="table-body-scroll">
                            <table class="table">
                                <tbody>
                                    <?php foreach ($services as $service): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($service['ID_SERVICIO_PK']) ?></td>
                                            <td><img src="<?= htmlspecialchars($service['IMAGEN_URL']) ?>"
                                                    style="height: 60px;"></td>
                                            <td><?= htmlspecialchars($service['NOMBRE_SERVICIO']) ?></td>
                                            <td><?= htmlspecialchars($service['DESCRIPCION_SERVICIO']) ?></td>
                                            <td><?= htmlspecialchars($service['ESTADO']) ?></td>
                                            <td class="text-center">
                                                <a href="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=editService&id=<?= $service['ID_SERVICIO_PK'] ?>"
                                                    class="btn btn-dark-blue btn-sm">
                                                    Editar <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
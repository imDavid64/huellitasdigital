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
                        <h2><i class="bi bi-gear-fill"></i><strong> Configuración General</strong></h2>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div class="subtitles mb-3 d-flex justify-content-between align-items-center">
                        <h3><i class="bi bi-images"></i> Gestión de Slider/Banner</h3>
                        <div>
                            <a href="/huellitasdigital/app/controllers/admin/generalSettingController.php?action=create_slider_banner"
                                class="btn-blue"><strong>Agregar Slider/Banner</strong>
                                <i class="bi bi-image-fill"></i></a>
                        </div>
                    </div>
                    <div class="admin-mgmt-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Estado</th>
                                    <th class="text-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($geSettings as $geSetting): ?>
                                    <tr>
                                        <td><?= $geSetting['ID_SLIDER_BANNER_PK'] ?></td>
                                        <td><img src="<?= htmlspecialchars($geSetting['IMAGEN_URL']) ?>"
                                        style="min-height: 60px; max-height: 60px;"></td>
                                        <td><?= htmlspecialchars($geSetting['DESCRIPCION_SLIDER_BANNER']) ?></td>
                                        <td><?= htmlspecialchars($geSetting['ESTADO']) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group" product="group">
                                                <a href="/huellitasdigital/app/controllers/admin/controllers/geSettingController.php?action=edit&id=<?= $geSetting['ID_SLIDER_BANNER_PK'] ?>"
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
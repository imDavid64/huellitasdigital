<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['EMPLEADO', 'ADMINISTRADOR']);
?>


<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/employeeHead.php"; ?>
<!--HEAD-->

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>

            <section class="vet-main-content">

                <div class="tittles">
                    <h2>
                        <i class="bi bi-badge-cc"></i>
                        <strong> Detalles de la Mascota</strong>
                    </h2>
                </div>
                <div class="client-container">
                    <div class="vet-main-content">
                        <div class="client-vet-info-content">
                            <div class="vet-client-container">
                                <div class="subtittles">
                                    <h3>Información de la Mascota</h3>
                                    <div>
                                        <a href="<?= BASE_URL ?>/index.php?controller=employeePet&action=edit&codigo=<?= urlencode($mascota['CODIGO_MASCOTA']) ?>"
                                            class="btn btn-blue btn-sm">
                                            <strong>Editar Mascota</strong> <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="vet-client-info">
                                    <div class="vet-client-info-container">
                                        <span><strong>Nombre de la Mascota: </strong>
                                            <?= htmlspecialchars($mascota['NOMBRE_MASCOTA']) ?></span>
                                        <span><strong>Código de Mascota: </strong>
                                            <?= htmlspecialchars($mascota['CODIGO_MASCOTA']) ?></span>
                                        <span><strong>Especie: </strong>
                                            <?= htmlspecialchars($mascota['ESPECIE']) ?></span>
                                        <span><strong>Raza: </strong>
                                            <?= htmlspecialchars($mascota['RAZA']) ?></span>
                                    </div>
                                    <div class="vet-client-info-container align-content-center">
                                        <div class="d-flex justify-content-center">
                                            <?php if (!empty($mascota['MASCOTA_IMAGEN_URL'])): ?>
                                                <img src="<?= htmlspecialchars($mascota['MASCOTA_IMAGEN_URL']) ?>"
                                                    style="width: 180px; height: 180px; object-fit: cover; border-radius: 10px;">
                                            <?php else: ?>
                                                <img src="<?= BASE_URL ?>/public/assets/images/default-pet-image.jpg"
                                                    class="rounded" style="width: 180px; height: 180px; object-fit: cover;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vet-pet-list-table">
                                <div class="subtittles">
                                    <h3>Historial Médico</h3>
                                    <div>
                                        <a href="<?= BASE_URL ?>/index.php?controller=employeePet&action=add"
                                            class="btn-blue"><strong>Crear Historial</strong>
                                            <i class="bi bi-patch-plus-fill"></i></a>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">ID</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Hora</th>
                                            <th scope="col">Motivo</th>
                                            <th style="" scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php if (empty($historiales)): ?>
                                            <tr>
                                                <td colspan="5">Sin historial medico.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($historiales as $h): ?>
                                                <tr>
                                                    <td><?= $m['ID_CONSULTA_FK'] ?></td>
                                                    <td><?= htmlspecialchars($h['CONSULTA_FECHA']) ?></td>
                                                    <td><?= htmlspecialchars($h['HORA']) ?></td>
                                                    <td><?= htmlspecialchars($h['MOTIVO']) ?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= BASE_URL ?>/index.php?controller=employeePet&action=details&codigo=<?= urlencode($cliente['CODIGO']) ?>"
                                                                class="btn btn-dark-blue btn-sm">Ver Mascota <i
                                                                    class="bi bi-pencil-square"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
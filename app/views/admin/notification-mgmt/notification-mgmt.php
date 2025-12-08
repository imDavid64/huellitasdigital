<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>
<!--HEAD-->

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
                    <!--Breadcrumb-->
                    <nav class="breadcrumbs-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">Inicio</a>
                            </li>
                            <li class="breadcrumb-item current-page">Gestión de Notificaciones</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-bell-fill"></i><strong> Gestión de Notificaciones</strong></h2>
                        <div>
                            <a href="<?= BASE_URL ?>/index.php?controller=adminNotification&action=create"
                                class="btn-blue"><strong>Agregar Notificación</strong>
                                <i class="bi bi-bell-fill">+</i></a>
                        </div>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div>
                        <div class="search">
                            <input type="text" class="admin-search-input" data-target="notification"
                                placeholder="Buscar notificación...">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                    <div class="admin-mgmt-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Mensaje</th>
                                    <th scope="col">Tipo de Notificacion</th>
                                    <th scope="col">Prioridad</th>
                                    <th class="d-flex justify-content-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($notifications as $notification): ?>
                                    <tr>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= $notification['ID_NOTIFICACION_PK'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($notification['TITULO_NOTIFICACION']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($notification['MENSAJE_NOTIFICACION']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($notification['TIPO_NOTIFICACION']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($notification['PRIORIDAD']) ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?= BASE_URL ?>/index.php?controller=adminNotification&action=edit&id=<?= $notification['ID_NOTIFICACION_PK'] ?>"
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
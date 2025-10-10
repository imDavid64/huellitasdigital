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
                                <a
                                    href="/huellitasdigital/app/controllers/admin/dashboardController.php?action=index">Inicio</a>
                            </li>
                            <li class="breadcrumb-item current-page">Gestión de Roles</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-diagram-2-fill"></i><strong> Gestión de Roles</strong></h2>
                        <div>
                            <a href="../../../app/controllers/admin/roleController.php?action=create"
                                class="btn-blue"><strong>Agregar Rol</strong>
                                <i class="bi bi-node-plus-fill"></i></a>
                        </div>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div>
                        <div class="search">
                            <input type="text" id="header-search" placeholder="Buscar rol...">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                    <div class="admin-mgmt-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estado</th>
                                    <th class="d-flex justify-content-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($roles as $role): ?>
                                    <tr>
                                        <td><?= $role['ID_ROL_USUARIO_PK'] ?></td>
                                        <td><?= htmlspecialchars($role['DESCRIPCION_ROL_USUARIO']) ?></td>
                                        <td><?= htmlspecialchars($role['ESTADO']) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="../../../app/controllers/admin/roleController.php?action=edit&id=<?= $role['ID_ROL_USUARIO_PK'] ?>"
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
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
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
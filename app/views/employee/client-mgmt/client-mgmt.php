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
                <!--Breadcrumb-->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item current-page">Gestión de Clientes</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-people-fill"></i><strong> Gestión de Clientes</strong></h2>
                    <div>
                        <a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=create"
                            class="btn-green"><strong>Agregar Cliente</strong>
                            <i class="bi bi-person-fill-add"></i></a>
                    </div>
                </div>
                <div class="client-container">
                    <div>
                        <div class="search">
                            <input type="text" class="admin-search-input" data-target="client"
                                placeholder="Buscar cliente...">
                            <i class="bi bi-search"></i>
                        </div>
                        <div class="admin-mgmt-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cod Cliente</th>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                        <th>|</th>
                                        <th>Mascotas</th>
                                        <th class="text-center" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($clientes)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No se encontraron registros.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($cliente['CODIGO']) ?></td>
                                                <td><span
                                                        class="badge <?= $cliente['TIPO'] === 'USUARIO' ? 'bg-info' : 'bg-success' ?>">
                                                        <?= htmlspecialchars($cliente['TIPO']) ?></span></td>
                                                <td><?= htmlspecialchars($cliente['NOMBRE']) ?></td>
                                                <td><?= htmlspecialchars($cliente['CORREO']) ?></td>
                                                <td><?= htmlspecialchars($cliente['ESTADO']) ?></td>
                                                <th>|</th>
                                                <td>
                                                    <?php if ($cliente['TOTAL_MASCOTAS'] > 0): ?>
                                                        <?= htmlspecialchars($cliente['NOMBRES_MASCOTAS']) ?>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Sin mascotas</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center" style="min-width: 155px;">
                                                    <a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=details&codigo=<?= $cliente['CODIGO'] ?>&tipo=<?= $cliente['TIPO'] ?>"
                                                        class="btn btn-dark-blue btn-sm">
                                                        Ver Cliente<i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>

                            </table>

                            <?php if ($totalPages > 1): ?>
                                <div class="pagination-container text-center mt-3">
                                    <ul class="pagination justify-content-center">
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                                <a class="page-link pagination-link" href="#"
                                                    data-page="<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
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
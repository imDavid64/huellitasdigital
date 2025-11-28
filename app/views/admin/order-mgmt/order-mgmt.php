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
                            <li class="breadcrumb-item current-page">Gestión de Pedidos</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-cart-fill"></i><strong> Gestión de Pedidos</strong></h2>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div>
                        <div class="search">
                            <input type="text" class="admin-search-input" data-target="order"
                                placeholder="Buscar pedido...">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                    <div class="admin-mgmt-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Código Pedido</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estado Pago</th>
                                    <th scope="col">Estado Pedido</th>
                                    <th class="text-center" scope="col" style="width: 150px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= $order['CODIGO_PEDIDO'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($order['CLIENTE']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($order['CORREO']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?= htmlspecialchars($order['FECHA_PEDIDO']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?php
                                                $estado = strtoupper($order['ESTADO_PAGO']);
                                                $badgeClass = match ($estado) {
                                                    'EN REVISIÓN' => 'bg-warning text-dark',
                                                    'PENDIENTE DE PAGO' => 'bg-warning text-dark',
                                                    'PAGADO' => 'bg-success text-dark',
                                                    'RECHAZADO' => 'bg-danger text-light',
                                                    'REEMBOLSADO' => 'bg-secondary',
                                                    default => 'bg-secondary'
                                                };
                                                ?>
                                                <span
                                                    class="badge <?= $badgeClass ?>"><?= htmlspecialchars($estado) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="admin-table-text-limit">
                                                <?php
                                                $estado = strtoupper($order['ESTADO_PEDIDO']);
                                                $badgeClass = match ($estado) {
                                                    'PENDIENTE' => 'bg-warning text-dark',
                                                    'EN PREPARACIÓN' => 'bg-info text-dark',
                                                    'ENVIADO' => 'bg-primary',
                                                    'ENTREGADO' => 'bg-success',
                                                    'CANCELADO' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                                ?>
                                                <span
                                                    class="badge <?= $badgeClass ?>"><?= htmlspecialchars($estado) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= BASE_URL ?>/index.php?controller=adminOrder&action=details&codigo=<?= $order['CODIGO_PEDIDO'] ?>"
                                                class="btn-dark-blue"> Ver Detalles
                                            </a>
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
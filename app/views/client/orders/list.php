<?php
// NO QUITAR //
require_once __DIR__ . '/../../../config/bootstrap.php';
// NO QUITAR //
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- SweetAlert2 local -->
    <script src="<?= BASE_URL ?>/public/js/libs/sweetalert2.all.min.js"></script>
    <!-- JQuery y script.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>/public/js/script.js"></script>
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!-- HEADER -->

    <!--breadcrumb-->
    <nav class="breadcrumbs-container-client">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a></li>
            <li class="breadcrumb-item current-page">Mis pedidos</li>
        </ol>
    </nav>

    <main>
        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Mis pedidos 📦</strong></h1>
                </div>

                <div class="orders_list-container my-4">
                    <?php if (!empty($orders)): ?>
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Cod Pedido</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Estado de Pedido</th>
                                        <th scope="col">Estado de Pago</th>
                                        <th class="text-center" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>
                                                <div class="admin-table-text-limit">
                                                    <?= htmlspecialchars($order['CODIGO_PEDIDO']) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="admin-table-text-limit">
                                                    <?= date('d/m/Y H:i', strtotime($order['FECHA_PEDIDO'])) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="admin-table-text-limit">
                                                    ₡<?= number_format($order['TOTAL'], 2, '.', ',') ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="admin-table-text-limit">
                                                    <?php
                                                    $estado = strtoupper($order['ESTADO']);
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
                                            <td>
                                                <div class="admin-table-text-limit">
                                                    <?php
                                                    $estadoPago = strtoupper($order['ESTADO_PAGO']);
                                                    $badgeClassPago = match ($estadoPago) {
                                                        'EN REVISIÓN' => 'bg-warning text-dark',
                                                        'PENDIENTE DE PAGO' => 'bg-warning text-dark',
                                                        'PAGADO' => 'bg-success text-light',
                                                        'RECHAZADO' => 'bg-danger text-light',
                                                        'REEMBOLSADO' => 'bg-secondary',
                                                        default => 'bg-secondary'
                                                    };
                                                    ?>
                                                    <span
                                                        class="badge <?= $badgeClassPago ?>"><?= htmlspecialchars($estadoPago) ?></span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= BASE_URL ?>/index.php?controller=orders&action=detail&codigoPedido=<?= $order['CODIGO_PEDIDO'] ?>"
                                                        class="btn btn-dark-blue btn-sm">Ver detalles <i
                                                            class="bi bi-eye"></i></a>
                                                    <?php if (strtoupper($order['ESTADO_PAGO']) === 'PAGADO'): ?>
                                                        <a href="<?= BASE_URL ?>/index.php?controller=orders&action=invoice&codigoPedido=<?= $order['CODIGO_PEDIDO'] ?>"
                                                            class="btn btn-purple btn-sm">
                                                            Ver factura <i class="bi bi-receipt"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button class="btn btn-purple btn-sm" disabled
                                                            title="Factura disponible cuando el pago esté confirmado.">
                                                            Ver factura <i class="bi bi-lock"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php if ($totalPages > 1): ?>
                                <nav aria-label="Paginación de pedidos">
                                    <ul class="pagination justify-content-center mt-4">

                                        <!-- Botón ANTERIOR -->
                                        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                            <a class="page-link pagination-link" style="color: #002557" href="#"
                                                data-page="<?= $currentPage > 1 ? $currentPage - 1 : 1 ?>"
                                                tabindex="<?= $currentPage <= 1 ? '-1' : '0' ?>"
                                                aria-disabled="<?= $currentPage <= 1 ? 'true' : 'false' ?>">
                                                « Anterior
                                            </a>
                                        </li>

                                        <!-- Números de página -->
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                                <a class="page-link pagination-link"
                                                    style="color: #002557, background-color: <?= $i === $currentPage ? '#002557; color: #fff' : 'transparent' ?>;"
                                                    href="#" data-page="<?= $i ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Botón SIGUIENTE -->
                                        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                            <a class="page-link pagination-link" style="color: #002557" href="#"
                                                data-page="<?= $currentPage < $totalPages ? $currentPage + 1 : $totalPages ?>"
                                                tabindex="<?= $currentPage >= $totalPages ? '-1' : '0' ?>"
                                                aria-disabled="<?= $currentPage >= $totalPages ? 'true' : 'false' ?>">
                                                Siguiente »
                                            </a>
                                        </li>

                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-center mt-5">Aún no has realizado ningún pedido 🐾</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <?php require_once __DIR__ . "/../partials/fooder.php"; ?>
    <!-- FOOTER -->
</body>

</html>
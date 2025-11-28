<?php
// NO QUITAR //
require_once __DIR__ . '/../../../config/bootstrap.php';
// NO QUITAR //
?>

<?php
$esTransferencia = strtoupper($pedido['METODO_PAGO']) === 'TRANSFERENCIA';
$estadoPedido = strtoupper($pedido['ESTADO_PEDIDO']);
$estadoPago = strtoupper($pedido['ESTADO_PAGO']);
$estadoComprobante = strtoupper($comprobante['ESTADO_VERIFICACION'] ?? '');
$intentos = (int) ($comprobante['INTENTOS'] ?? 0);

$mostrarBotonSubirComprobante = false;

if (
    $esTransferencia &&
    $estadoPedido === 'PENDIENTE' &&
    $estadoPago === 'RECHAZADO' &&
    $estadoComprobante === 'RECHAZADO' &&
    $intentos < 3
) {
    $mostrarBotonSubirComprobante = true;
}
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

    <nav class="breadcrumbs-container-client">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?controller=orders&action=list">Mis
                    pedidos</a></li>
            <li class="breadcrumb-item current-page">Detalle del pedido</li>
        </ol>
    </nav>

    <main>
        <section class="main-content py-4">
            <div class="container">
                <div class="tittles text-center mb-4">
                    <h1><strong>Detalle del pedido 🧾</strong></h1>
                    <p class="text-muted">Código: <?= htmlspecialchars($pedido['CODIGO_PEDIDO']) ?></p>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="bi bi-info-circle"></i> Información del pedido</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['USUARIO_NOMBRE']) ?></p>
                                <p><strong>Correo:</strong> <?= htmlspecialchars($pedido['USUARIO_CORREO']) ?></p>
                                <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['FECHA_PEDIDO'])) ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Estado:</strong>
                                    <?php
                                    $estado = strtoupper($pedido['ESTADO_PEDIDO']);
                                    $badgeClass = match ($estado) {
                                        'PENDIENTE' => 'bg-warning text-dark',
                                        'EN PREPARACIÓN' => 'bg-info text-dark',
                                        'ENVIADO' => 'bg-primary',
                                        'ENTREGADO' => 'bg-success',
                                        'CANCELADO' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($estado) ?></span>
                                </p>
                                <p><strong>Estado de Pago:</strong>
                                    <?php
                                    $estadoPago = strtoupper($pedido['ESTADO_PAGO']);
                                    $badgeClassPago = match ($estadoPago) {
                                        'EN REVISIÓN' => 'bg-warning text-dark',
                                        'PENDIENTE DE PAGO' => 'bg-warning text-dark',
                                        'PAGADO' => 'bg-success text-dark',
                                        'RECHAZADO' => 'bg-danger text-light',
                                        'REEMBOLSADO' => 'bg-secondary',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span
                                        class="badge <?= $badgeClassPago ?>"><?= htmlspecialchars($estadoPago) ?></span>
                                </p>
                                <p><strong>Total:</strong> ₡<?= number_format($pedido['TOTAL'], 2) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="bi bi-box-seam"></i> Productos</h5>
                        <?php if (!empty($productos)): ?>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($productos as $prod): ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= htmlspecialchars($prod['IMAGEN_URL'] ?? 'assets/images/no-img.png') ?>"
                                                        alt="Imagen del producto" width="60" class="rounded">
                                                </td>
                                                <td><?= htmlspecialchars($prod['PRODUCTO_NOMBRE']) ?></td>
                                                <td><?= $prod['CANTIDAD'] ?></td>
                                                <td>₡<?= number_format($prod['PRECIO_UNITARIO'], 2) ?></td>
                                                <td>₡<?= number_format($prod['SUBTOTAL'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center">No hay productos asociados a este pedido.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="bi bi-geo-alt"></i> Dirección de envío</h5>
                        <p><?= htmlspecialchars($pedido['ENVIO_PROVINCIA']) ?>,
                            <?= htmlspecialchars($pedido['ENVIO_CANTON']) ?>,
                            <?= htmlspecialchars($pedido['ENVIO_DISTRITO']) ?>
                        </p>
                        <p><strong>Señas:</strong> <?= htmlspecialchars($pedido['ENVIO_SENNAS']) ?></p>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="text-center mt-4" style="width: 240px;">
                        <a href="<?= BASE_URL ?>/index.php?controller=orders&action=list" class="btn-dark-blue">
                            <i style="padding-right: 0.5rem; padding-left: 0rem;" class="bi bi-arrow-left-circle"></i>
                            Volver a mis pedidos
                        </a>
                    </div>
                    <?php if ($mostrarBotonSubirComprobante): ?>
                        <div class="text-center mt-4">
                            <button class="btn btn-warning text-dark fw-bold btnSubirComprobante"
                                data-codigo="<?= $pedido['CODIGO_PEDIDO'] ?>">
                                <i class="bi bi-upload"></i> Subir nuevo comprobante
                            </button>
                            <p class="text-muted small mt-2">
                                Intentos usados: <?= $intentos ?> / 3
                            </p>
                        </div>
                    <?php endif; ?>
                    <div class="text-center mt-4">
                        <?php if (strtoupper($pedido['ESTADO_PAGO']) === 'PAGADO'): ?>
                            <a href="<?= BASE_URL ?>/index.php?controller=orders&action=downloadInvoice&codigoPedido=<?= $pedido['CODIGO_PEDIDO'] ?>"
                                class="btn btn-purple" target="_blank">
                                <i class="bi bi-file-earmark-pdf"></i> Descargar factura (PDF)
                            </a>
                        <?php else: ?>
                            <button class="btn btn-purple" disabled
                                title="La factura estará disponible cuando el pago sea confirmado.">
                                <i class="bi bi-file-earmark-pdf"></i> Factura no disponible
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="text-center mt-4">
                        <?php if (in_array($pedido['ESTADO_PEDIDO'], ['PENDIENTE', 'EN PREPARACIÓN'])): ?>
                            <button class="btn btn-black btnCancelOrder" data-id="<?= $pedido['ID_PEDIDO_PK'] ?>">
                                <i style="padding-right: 0.5rem; padding-left: 0rem;" class="bi bi-x-circle"></i> Cancelar
                                pedido
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- =========================================================== -->
    <!-- MODAL SUBIR NUEVO COMPROBANTE -->
    <!-- =========================================================== -->
    <div class="modal fade" id="modalSubirComprobante" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="formSubirComprobante" enctype="multipart/form-data">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-upload"></i> Subir nuevo comprobante
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="codigoPedido" id="codigoPedidoComprobanteCliente">

                        <div class="mb-3">
                            <label class="form-label">Seleccione una imagen del comprobante:</label>
                            <input type="file" class="form-control" name="comprobante" id="inputComprobantePago"
                                accept="image/*" required>
                        </div>

                        <div class="text-center">
                            <img id="previewComprobante" src="" class="img-fluid rounded shadow-sm d-none"
                                style="max-height: 250px;">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Subir Comprobante</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    
    <!-- FOOTER -->
    <?php require_once __DIR__ . "/../partials/fooder.php"; ?>
    <!-- FOOTER -->
</body>

</html>
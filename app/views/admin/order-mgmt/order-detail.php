<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar

// Obtener los datos del pedido y productos
$esTransferencia = strtoupper($pedido['METODO_PAGO']) === 'TRANSFERENCIA';
$estadoPago = strtoupper($pedido['ESTADO_PAGO']);
$estadoPedido = strtoupper($pedido['ESTADO_PEDIDO']);
$estadoComprobante = strtoupper($comprobante['ESTADO_VERIFICACION'] ?? '');

// ==============================
// 🔒 REGLAS PARA ESTADO DE PAGO
// ==============================
$bloqueoPago = false;
$razonBloqueoPago = "";
$iconoPago = "bi-cash-coin";

// Regla 1: Pedido cancelado → NO se permite nada
if ($estadoPedido === 'CANCELADO') {
    $bloqueoPago = true;
    $razonBloqueoPago = "El pedido está cancelado, por lo que no se puede modificar el estado de pago.";
}

// Regla 2: Ya está pagado → NO se modifica
elseif ($estadoPago === 'PAGADO') {
    $bloqueoPago = true;
    $razonBloqueoPago = "El pago ya fue confirmado como PAGADO.";
}

// Regla 3: Transferencia → solo permite edición si el comprobante fue RECHAZADO
elseif ($esTransferencia) {

    if ($estadoComprobante === "" || $estadoComprobante === null) {
        $bloqueoPago = true;
        $razonBloqueoPago = "El comprobante aún no ha sido cargado o no existe.";
    } elseif ($estadoComprobante === "SIN REVISAR" || $estadoComprobante === "EN REVISIÓN") {
        $bloqueoPago = true;
        $razonBloqueoPago = "El comprobante aún no ha sido revisado.";
    } elseif ($estadoComprobante === "APROBADO") {
        $bloqueoPago = true;
        $razonBloqueoPago = "El comprobante ya fue aprobado.";
    }
}

// Cambiar icono si está bloqueado
if ($bloqueoPago) {
    $iconoPago = "bi-lock-fill";
}


// ==============================
// 🔒 REGLAS PARA ESTADO DEL PEDIDO
// ==============================
$bloqueadoPedido = false;
$razonBloqueoPedido = "";
$iconoPedido = "bi-clipboard-check";

// 1️⃣ Pedido cancelado
if ($estadoPedido === 'CANCELADO') {
    $bloqueadoPedido = true;
    $razonBloqueoPedido = "El pedido está cancelado y no se puede modificar.";
}

// 2️⃣ Pedido ya entregado
elseif ($estadoPedido === 'ENTREGADO') {
    $bloqueadoPedido = true;
    $razonBloqueoPedido = "Este pedido ya fue entregado.";
}

// 3️⃣ Pedido por transferencia sin pago confirmado
elseif ($pedido['METODO_PAGO'] === 'TRANSFERENCIA' && $estadoPago !== 'PAGADO') {
    $bloqueadoPedido = true;
    $razonBloqueoPedido = "No puedes cambiar el estado del pedido hasta que el pago por transferencia sea aprobado.";
}

// 4️⃣ Pedido con pago contra entrega pero no se ha marcado como entregado
elseif ($pedido['METODO_PAGO'] === 'CONTRA ENTREGA' && $estadoPago !== 'PENDIENTE DE PAGO') {
    $bloqueadoPedido = true;
    $razonBloqueoPedido = "El pedido con pago contra entrega solo puede cambiar estado cuando está pendiente de pago.";
}

// 5️⃣ PayPal: no pagado
elseif ($pedido['METODO_PAGO'] === 'PAYPAL' && $estadoPago !== 'PAGADO') {
    $bloqueadoPedido = true;
    $razonBloqueoPedido = "Este pedido no se puede actualizar porque el pago de PayPal no ha sido confirmado.";
}

if ($bloqueadoPedido) {
    $iconoPedido = "bi-lock-fill";
}
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
                <!--Breadcrumb-->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=admin&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item current-page">Gestión de Pedidos</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-cart-fill"></i><strong> Detalle del pedido</strong></h2>
                    <div class="d-flex gap-3">
                        <?php
                        $bloqueoPago = false;

                        // Regla 1: Pedido cancelado → NO se permite nada
                        if ($estadoPedido === 'CANCELADO') {
                            $bloqueoPago = true;
                            $iconoPago = $bloqueoPago ? 'bi-lock-fill' : 'bi-cash-coin';
                        }

                        // Regla 2: Estado de pago ya es PAGADO → nunca debe cambiarse
                        elseif ($estadoPago === 'PAGADO') {
                            $bloqueoPago = true;
                            $iconoPago = $bloqueoPago ? 'bi-lock-fill' : 'bi-cash-coin';
                        }

                        // Regla 3: Transferencia → solo permite editar si el comprobante fue RECHAZADO
                        elseif ($esTransferencia) {
                            if (!in_array($estadoComprobante, ['RECHAZADO'])) {
                                $bloqueoPago = true;
                                $iconoPago = $bloqueoPago ? 'bi-lock-fill' : 'bi-cash-coin';
                            }
                        }
                        ?>

                        <?php /*
                        <a href="#" class="btn-green btnEditarEstadoPago <?= $bloqueoPago ? 'disabled-link' : '' ?>"
                            data-codigo="<?= $pedido['CODIGO_PEDIDO'] ?>" data-current-status="<?= $estadoPago ?>"
                            data-bloqueo="<?= htmlspecialchars($razonBloqueoPago) ?>">
                            Editar Estado de Pago <i class="bi <?= $iconoPago ?>"></i>
                        </a>
                        */?>
                        <?php
                        $bloqueadoPedido =
                            ($estadoPedido === 'CANCELADO') ||
                            ($estadoPago !== 'PAGADO' && $pedido['METODO_PAGO'] !== 'CONTRA ENTREGA') ||
                            ($estadoPedido === 'ENTREGADO');

                        $iconoPedido = $bloqueadoPedido ? 'bi-lock-fill' : 'bi-clipboard-check';
                        ?>

                        <a href="#" class="btn-purple btnEditStatus <?= $bloqueadoPedido ? 'disabled-link' : '' ?>"
                            data-codigo="<?= $pedido['CODIGO_PEDIDO'] ?>"
                            data-bloqueo="<?= htmlspecialchars($razonBloqueoPedido) ?>"
                            data-current-status="<?= $estadoPedido ?>">
                            Editar Estado de Pedido <i class="bi <?= $iconoPedido ?>"></i>
                        </a>

                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-3"><i class="bi bi-info-circle"></i> Información del pedido</h5>
                                <!-- ================================
                                    BOTÓN: Revisar comprobante
                                    SOLO si método de pago = TRANSFERENCIA
                                ================================= -->
                                <div class="text-center">
                                    <div>
                                        <?php if (strtoupper($pedido['METODO_PAGO']) === 'TRANSFERENCIA'):
                                            $comprobanteEstado = $comprobante['ESTADO_VERIFICACION'] ?? 'Sin Revisar';
                                            if (strtoupper($comprobanteEstado) === 'APROBADO'):
                                                $estadoBadgeClass = 'bg-success text-light';
                                            elseif (strtoupper($comprobanteEstado) === 'RECHAZADO'):
                                                $estadoBadgeClass = 'bg-danger text-light';
                                            else:
                                                $estadoBadgeClass = 'bg-secondary text-light';
                                            endif;
                                            ?>
                                            <p>Estado Comprobante de Pago: <span
                                                    class="badge <?= $estadoBadgeClass ?>"><?= htmlspecialchars($comprobanteEstado) ?></span>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($esTransferencia && $estadoComprobante !== 'APROBADO' && $estadoPedido !== 'CANCELADO'): ?>
                                        <button class="btn btn-warning text-white fw-bold btnRevisarComprobante"
                                            data-codigo="<?= $pedido['CODIGO_PEDIDO'] ?>">
                                            Revisar Comprobante <i class="bi bi-receipt"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['USUARIO_NOMBRE']) ?>
                                    </p>
                                    <p><strong>Correo:</strong> <?= htmlspecialchars($pedido['USUARIO_CORREO']) ?>
                                    </p>
                                    <p><strong>Fecha:</strong>
                                        <?= date('d/m/Y H:i', strtotime($pedido['FECHA_PEDIDO'])) ?>
                                    </p>
                                    <p><strong>Código:</strong> <?= htmlspecialchars($pedido['CODIGO_PEDIDO']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Estado de Pedido:</strong>
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
                                            'PAGADO' => 'bg-success text-light',
                                            'RECHAZADO' => 'bg-danger text-light',
                                            'REEMBOLSADO' => 'bg-secondary',
                                            default => 'bg-secondary'
                                        };
                                        ?>
                                        <span
                                            class="badge <?= $badgeClassPago ?>"><?= htmlspecialchars($estadoPago) ?></span>
                                    </p>
                                    <p><strong>Total:</strong> ₡<?= number_format($pedido['TOTAL'], 2) ?></p>
                                    <p><strong>Metodo de Pago:</strong> <?= htmlspecialchars($pedido['METODO_PAGO']) ?>
                                    </p>
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
                        <div class="text-center mt-4" style="width: 300px;">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminOrder&action=index"
                                class="btn-dark-blue">
                                <i style="padding-right: 0.5rem; padding-left: 0rem;"
                                    class="bi bi-arrow-left-circle"></i>
                                Volver a Gestión de Pedidos
                            </a>
                        </div>
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
                    </div>

                </section>

            </section>
        </section>

        </section>
    </main>
    <!-- ====================================== -->
    <!-- MODAL: Editar Estado del Pedido -->
    <!-- ====================================== -->
    <div class="modal fade" id="modalEditarEstado" tabindex="-1" aria-labelledby="modalEditarEstadoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditarEstado">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarEstadoLabel">
                            <i class="bi bi-pencil-square"></i> Editar Estado del Pedido
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="pedidoCodigo" name="pedidoCodigo">

                        <div class="mb-3">
                            <label for="nuevoEstado" class="form-label">Nuevo Estado</label>
                            <select class="form-select" id="nuevoEstado" name="nuevoEstado" required>
                                <option value="" disabled selected>Seleccionar estado...</option>
                                <?php foreach ($estados as $estadoItem): ?>
                                    <?php
                                    $nombreEstado = strtoupper($estadoItem['ESTADO_DESCRIPCION']);
                                    $idEstado = $estadoItem['ID_ESTADO_PK'];
                                    $disabled = '';

                                    // ============================
                                    // ⚠️ REGLA: Si estado actual = ENVIADO
                                    // ============================
                                    if ($estado === 'ENVIADO') {
                                        if ($nombreEstado === 'CANCELADO' || $nombreEstado === 'EN PREPARACIÓN') {
                                            $disabled = 'disabled';
                                        }
                                    }
                                    ?>
                                    <option value="<?= $idEstado ?>" <?= $disabled ?>>
                                        <?= htmlspecialchars($estadoItem['ESTADO_DESCRIPCION']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="alert alert-info small">
                            <i class="bi bi-info-circle"></i> Cambiar el estado actualizará el seguimiento del pedido.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ====================================== -->
    <!-- MODAL: Editar Estado de Pago -->
    <!-- ====================================== -->
    <div class="modal fade" id="modalEditarEstadoPago" tabindex="-1" aria-labelledby="modalEditarEstadoPagoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="formEditarEstadoPago">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarEstadoPagoLabel">
                            <i class="bi bi-cash-coin"></i> Editar Estado de Pago
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- IMPORTANTE: trabajar con CODIGO del pedido -->
                        <input type="hidden" id="pagoCodigoPedido" name="codigoPedido">

                        <div class="mb-3">
                            <label for="nuevoEstadoPago" class="form-label">Nuevo Estado de Pago</label>
                            <select class="form-select" id="nuevoEstadoPago" name="nuevoEstadoPago" required>
                                <option value="" disabled selected>Seleccionar estado...</option>
                                <?php foreach ($paymentStates as $estadoPagoItem): ?>
                                    <option value="<?= $estadoPagoItem['ID_ESTADO_PK'] ?>">
                                        <?= htmlspecialchars($estadoPagoItem['ESTADO_DESCRIPCION']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="alert alert-info small">
                            <i class="bi bi-info-circle"></i>
                            Cambiar el estado de pago puede afectar la disponibilidad del pedido.
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ============================== -->
    <!-- MODAL: REVISAR COMPROBANTE -->
    <!-- ============================== -->
    <div class="modal fade" id="modalComprobantePago" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form id="formActualizarComprobante">
                    <input type="hidden" name="estado_pago" id="estado_pago">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-receipt"></i> Revisar Comprobante de Pago
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="codigoPedidoComprobante" name="codigoPedido">

                        <!-- Contenedor donde se cargará la información vía AJAX -->
                        <div id="contenedorComprobanteDatos" class="p-2">
                            <div class="text-center my-4">
                                <div class="spinner-border text-primary"></div>
                                <p class="mt-2">Cargando comprobante...</p>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn-blue" type="submit">Guardar Cambios</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


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
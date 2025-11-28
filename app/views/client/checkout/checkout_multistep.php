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
    <script
        src="https://www.paypal.com/sdk/js?client-id=AVsVVKGodAe9UEUGHBos76AS9Sjwcm1zHPHbFUgyaY1Cy9s_v9XpDOGlW8JY45MJsFyz0qgttEFROXVb&currency=USD">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- SweetAlert2 local -->
    <script src="<?= BASE_URL ?>/public/js/libs/sweetalert2.all.min.js"></script>
    <!-- JQuery y script.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>/public/js/script.js"></script>
    <script src="<?= BASE_URL ?>/public/js/paypal.js"></script>
</head>

<body class="page-checkout">
    <!-- HEADER -->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!-- HEADER -->

    <nav class="breadcrumbs-container-client">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?controller=cart&action=index">Carrito</a>
            </li>
            <li class="breadcrumb-item current-page">Checkout</li>
        </ol>
    </nav>

    <main>
        <section class="main-content py-4">
            <div class="container">
                <div class="tittles text-center mb-4">
                    <h1><strong>Proceso de compra 🐾</strong></h1>
                    <p class="text-muted">Completa los pasos para finalizar tu pedido</p>
                </div>

                <form id="checkoutForm" method="POST" action="<?= BASE_URL ?>/index.php"
                    data-total="<?= $totals['TOTAL_FINAL'] ?>">
                    <input type="hidden" name="controller" value="checkout">
                    <input type="hidden" name="action" value="procesar">

                    <!-- PASO 1 -->
                    <div class="checkout-step" id="step1">
                        <h4 class="mb-3">👤 Datos personales y dirección</h4>
                        <div class="row justify-content-between">
                            <div class="col-md-6 gap-3">
                                <div class="form-item">
                                    <label>Nombre completo</label>
                                    <input type="text" class="form-control" name="nombre"
                                        value="<?= htmlspecialchars($user['USUARIO_NOMBRE'] ?? '') ?>" required>
                                </div>

                                <div class="form-item">
                                    <label class="mt-3">Correo electrónico</label>
                                    <input type="email" class="form-control" name="correo"
                                        value="<?= htmlspecialchars($user['USUARIO_CORREO'] ?? '') ?>" required>
                                </div>

                                <div class="form-item">
                                    <label class="mt-3">Teléfono</label>
                                    <input type="text" name="telefono"
                                        value="<?= htmlspecialchars($user['TELEFONO_CONTACTO'] ?? '') ?>" maxlength="8"
                                        pattern="\d{8}" inputmode="numeric" placeholder="Ej: 88888888" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-item">
                                    <label>Provincia</label>
                                    <select id="provincia" name="provincia" class="form-select" required>
                                        <option value="">Seleccione una provincia</option>
                                        <?php foreach ($provincias as $p): ?>
                                            <option value="<?= $p['ID_DIRECCION_PROVINCIA_PK'] ?>"
                                                <?= ($user['ID_DIRECCION_PROVINCIA_FK'] ?? 0) == $p['ID_DIRECCION_PROVINCIA_PK'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($p['NOMBRE_PROVINCIA']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-item">
                                    <label class="mt-3">Cantón</label>
                                    <select id="canton" name="canton" class="form-select" required>
                                        <option value="">Seleccione un cantón</option>
                                        <?php foreach ($cantones as $c): ?>
                                            <option value="<?= $c['ID_DIRECCION_CANTON_PK'] ?>"
                                                <?= ($user['ID_DIRECCION_CANTON_FK'] ?? 0) == $c['ID_DIRECCION_CANTON_PK'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c['NOMBRE_CANTON']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-item">
                                    <label class="mt-3">Distrito</label>
                                    <select id="distrito" name="distrito" class="form-select" required>
                                        <option value="">Seleccione un distrito</option>
                                        <?php foreach ($distritos as $d): ?>
                                            <option value="<?= $d['ID_DIRECCION_DISTRITO_PK'] ?>"
                                                <?= ($user['ID_DIRECCION_DISTRITO_FK'] ?? 0) == $d['ID_DIRECCION_DISTRITO_PK'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($d['NOMBRE_DISTRITO']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-item">
                                    <label class="mt-3">Señas exactas</label>
                                    <textarea id="sennas" name="sennas"
                                        rows="3"><?= htmlspecialchars($user['DIRECCION_SENNAS'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-5">
                            <button type="button" class="btn-green next-step" data-next="2">Continuar <i
                                    class="bi bi-arrow-right-circle"></i></button>
                        </div>
                    </div>

                    <!-- PASO 2 -->
                    <div class="checkout-step d-none" id="step2">
                        <h4 class="mb-3">🛒 Detalles del pedido</h4>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['PRODUCTO_NOMBRE']) ?></td>
                                            <td><?= $item['CANTIDAD'] ?></td>
                                            <td>₡<?= number_format($item['PRECIO_UNITARIO'], 2) ?></td>
                                            <td>₡<?= number_format($item['SUBTOTAL'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p><strong>Subtotal:</strong> ₡<?= number_format($totals['SUBTOTAL'], 2) ?></p>
                            <p><strong>Envío:</strong> ₡<?= number_format($totals['ENVIO'], 2) ?></p>
                            <p><strong>Total:</strong> ₡<?= number_format($totals['TOTAL_FINAL'], 2) ?></p>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn-black prev-step" data-prev="1"><i
                                    class="bi bi-arrow-left-circle"></i> Volver</button>
                            <button type="button" class="btn-green next-step" data-next="3">Continuar al pago <i
                                    class="bi bi-arrow-right-circle"></i></button>
                        </div>
                    </div>

                    <!-- PASO 3 -->
                    <div class="checkout-step d-none" id="step3">
                        <h4 class="mb-3">💳 Selección del método de pago</h4>
                        <select name="metodo_pago" class="form-select" id="metodoPago" required>
                            <option value="">Seleccione un método</option>
                            <option value="PAYPAL">PayPal</option>
                            <option value="TRANSFERENCIA">Transferencia bancaria</option>
                        </select>

                        <div id="tarjetaBox" class="mt-3 d-none">
                            <label>Seleccione una tarjeta guardada</label>
                            <select name="tarjeta_id" class="form-select">
                                <?php foreach ($tarjetas as $t): ?>
                                    <option value="<?= $t['ID_TARJETA_PK'] ?>">
                                        **** <?= $t['ULTIMOS_CUATRO_DIGITOS'] ?> (<?= $t['MARCA_TARJETA'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- PAYPAL -->
                        <div id="paypalBox" class="mt-4 d-none">
                            <h5>Pagar con PayPal</h5>
                            <div id="paypal-button-container"></div>
                        </div>

                        <!-- TRANSFERENCIA -->
                        <div id="transferenciaBox" class="mt-4 d-none">
                            <h5>Transferencia bancaria</h5>
                            <p>Realice la transferencia a la siguiente cuenta:</p>
                            <ul class="list-unstyled">
                                <li><strong>Banco:</strong> Banco Nacional de Costa Rica</li>
                                <li><strong>Número de cuenta:</strong> 100-01-123-456789-0</li>
                                <li><strong>Cuenta IBAN:</strong> CR10010011234567890</li>
                                <li><strong>Nombre:</strong> Huellitas Digital S.A.</li>
                            </ul>
                            <p>Una vez realizada la transferencia, suba el comprobante para confirmar el pago.</p>

                            <!-- 📸 SUBIR COMPROBANTE -->
                            <div class="form-item">
                                <label class="form-label"><strong>Subir comprobante de pago (imagen)*</strong></label>
                                <input type="file" name="comprobante_transferencia"
                                    id="comprobanteTransferencia" accept="image/png, image/jpeg" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn-black prev-step" data-prev="2"><i
                                    class="bi bi-arrow-left-circle"></i> Volver</button>
                            <button type="submit" id="btnConfirmarCompra" class="btn-green">Confirmar compra</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <?php require_once __DIR__ . "/../partials/fooder.php"; ?>
    <!-- FOOTER -->
</body>

</html>
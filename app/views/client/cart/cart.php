<?php
//NO QUITAR//
require_once __DIR__ . '/../../../config/bootstrap.php';
//NO QUITAR//
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
    <!--HEADER-->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--Breadcrumb-->
    <nav class="breadcrumbs-container-client">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a>
            </li>
            <li class="breadcrumb-item current-page">Carrito</li>
        </ol>
    </nav>

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Tu Carrito 🛒</strong></h1>
                </div>
                <div class="cart-container">
                    <!--Titulos de la pagina de carrito carrito-->
                    <div class="cart-header">
                        <div class="cart-header-left">
                            <span>Productos</span>
                        </div>
                        <div class="cart-header-right">
                            <span>Subtotal</span>
                            <span>Cantidad</span>
                        </div>
                    </div>
                    <!--Articulos en el carrito-->
                    <div class="cart-items">
                        <?php if (!empty($cartItems)): ?>
                            <?php foreach ($cartItems as $item): ?>
                                <div class="cart-item" data-id-product="<?= $item['ID_PRODUCTO_PK'] ?>">
                                    <div class="cart-item-info">
                                        <img src="<?= htmlspecialchars($item['IMAGEN_URL'] ?? 'assets/images/no-img.png') ?>"
                                            alt="<?= htmlspecialchars($item['PRODUCTO_NOMBRE']) ?>">
                                        <div>
                                            <h5><?= htmlspecialchars($item['PRODUCTO_NOMBRE']) ?></h5>
                                            <span><strong>₡<?= number_format($item['PRECIO_UNITARIO'], 2) ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="cart-item-details">
                                        <span class="cart-price" data-price="<?= $item['PRECIO_UNITARIO'] ?>">
                                            ₡<?= number_format($item['SUBTOTAL'], 2, ',', '.') ?>
                                        </span>
                                        <div class="cart-sum-item">
                                            <button>-</button>
                                            <input type="number" min="1" value="<?= (int) $item['CANTIDAD'] ?>">
                                            <button>+</button>
                                        </div>
                                        <a href="#" class="btn-cart-remove" data-id="<?= $item['ID_CARRITO_PK'] ?>"><i
                                                class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <!-- RESUMEN DE TOTALES -->
                    <?php if (!empty($cartItems)): ?>
                        <div class="cart-total-container mt-4 text-end">
                            <div class="totals-box p-3 border rounded-4 shadow-sm bg-light d-inline-block text-start"
                                style="min-width: 350px;">
                                <h5>Subtotal: <span
                                        id="cart-subtotal">₡<?= number_format($cartTotals['SUBTOTAL'], 2) ?></span></h5>
                                <h6>IVA (13%): <span id="cart-iva">₡<?= number_format($cartTotals['IVA'], 2) ?></span></h6>
                                <h6>Costo de envío: <span
                                        id="cart-shipping">₡<?= number_format($cartTotals['ENVIO'], 2) ?></span></h6>
                                <hr>
                                <h4>Total: <span id="cart-total">₡<?= number_format($cartTotals['TOTAL_FINAL'], 2) ?></span>
                                </h4>

                                <!-- Botón Finalizar compra -->
                                <div class="d-flex justify-content-center mt-4">
                                    <form action="<?= BASE_URL ?>/index.php" method="GET">
                                        <input type="hidden" name="controller" value="checkout">
                                        <input type="hidden" name="action" value="index">
                                        <button type="submit" class="btn-green">
                                            Finalizar compra <i class="bi bi-credit-card"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-center mt-5">Tu carrito está vacío 🐾</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOODER-->
<?php require_once __DIR__ . "/../partials/fooder.php"; ?>
<!--FOODER-->

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/huellitasdigital/public/css/style.css">
    <link rel="stylesheet" href="/huellitasdigital/public/assets/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/huellitasdigital/public/js/script.js"></script>
</head>

<body>
    <!--HEADER-->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="static-banner">
            <img src="/huellitasdigital/public/assets/images/static-banners/img-banner-products-4.png" alt="Banner">
            <span class="tittle-static-banner">Productos</span>
        </section>
        <!--Breadcrumb-->
        <nav class="breadcrumbs-container-client">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/huellitasdigital/app/controllers/homeController.php?action=index">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/huellitasdigital/app/controllers/client/productController.php?action=index">Productos</a>
                </li>
                <li class="breadcrumb-item current-page">
                    <?= htmlspecialchars($product['PRODUCTO_NOMBRE'] ?? 'Sin nombre') ?>
                </li>
            </ol>
        </nav>
        <section class="main-content">
            <div>
                <div class="product-detail-container">
                    <div class="product-detail-image">
                        <img src="<?= htmlspecialchars($product['IMAGEN_URL']) ?>"
                            style="min-width: 350px; min-height: 350px; max-width: 350px; max-height: 350px; border-radius: 10px;">
                    </div>
                    <div class="product-detail-info">
                        <div class="product-detail-name">
                            <?= htmlspecialchars($product['PRODUCTO_NOMBRE'] ?? 'Sin nombre') ?>
                        </div>
                        <div class="product-detail-description">
                            <span><strong>Descripción</strong></span>
                            <div class="product-detail-description-text">
                                <p><?= htmlspecialchars($product['PRODUCTO_DESCRIPCION'] ?? 'Sin descripción') ?></p>
                            </div>
                        </div>
                        <div class="product-detail-price">
                            <span><strong>Precio:
                                </strong>₡<?= htmlspecialchars($product['PRODUCTO_PRECIO_UNITARIO'] ?? 'Sin precio') ?></span>
                        </div>
                        <div class="product-detail-addCart">
                            <div class="product-detail-card-button">
                                <?php if (isset($_SESSION['user_name'])): ?>
                                    <a class="btn-orange"
                                        href="/huellitasdigital/app/controllers/client/productController.php?action=addToCart&id=<?= htmlspecialchars($product['ID_PRODUCTO'] ?? 0) ?>">Añadir
                                        al Carrito</a>
                                <?php else: ?>
                                    <a class="btn-orange btnLogin" href="#">Añadir al Carrito</a>
                                <?php endif; ?>

                            </div>
                            <div class="cart-sum-item">
                                <button
                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                <input min="1" name="quantity" value="1" type="number">
                                <button
                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="product-comments-container">
                    <h2>Comentarios</h2>

                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="comment-card">
                                <div class="comment-header">
                                    <img src="<?= htmlspecialchars($comment['USUARIO_IMAGEN_URL'] ?? '/huellitasdigital/public/assets/images/default-user-image.png') ?>"
                                        alt="Usuario" class="comment-avatar">
                                    <div class="comment-info">
                                        <strong><?= htmlspecialchars($comment['NOMBRE_USUARIO']) ?></strong><br>
                                        <small><?= htmlspecialchars($comment['FECHA_CREACION']) ?></small>
                                    </div>
                                </div>
                                <div class="comment-body">
                                    <div class="comment-stars">
                                        <?php
                                        $stars = intval($comment['CALIFICACION_TIPO']);
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $stars
                                                ? '<i class="bi bi-star-fill text-warning"></i>'
                                                : '<i class="bi bi-star text-secondary"></i>';
                                        }
                                        ?>
                                    </div>
                                    <p><?= htmlspecialchars($comment['COMENTARIO_TEXTO']) ?></p>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Aún no hay comentarios para este producto.</p>
                    <?php endif; ?>
                    <div class="product-comments-addComment">
                        <div class="form-item">
                            <div>
                                <span>Agrega un comentario del producto</span>
                            </div>
                            <div>
                                <label for="addComment"></label>
                                <textarea></textarea>
                            </div>
                            <div class="give-product-stars">

                            </div>
                        </div>
                        <div>
                            <a class="btn-purple btnLogin" href="#">Agregar un Comentario</a>
                        </div>
                    </div>
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
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

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="static-banner">
            <img src="<?= BASE_URL ?>/public/assets/images/static-banners/img-banner-products-4.png" alt="Banner">
            <span class="tittle-static-banner">Productos</span>
        </section>
        <!--Breadcrumb-->
        <nav class="breadcrumbs-container-client">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>/index.php?controller=product&action=index">Productos</a>
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
                        <?php if (!empty($rating)): ?>
                            <div class="rating-average">
                                <strong><?= round($rating['PROMEDIO_ESTRELLAS'], 1) ?> ⭐</strong>
                                <small>(<?= $rating['TOTAL_COMENTARIOS'] ?> comentarios)</small>
                            </div>
                        <?php endif; ?>
                        <div class="product-detail-description">
                            <span><strong>Descripción</strong></span>
                            <div class="product-detail-description-text">
                                <p><?= htmlspecialchars($product['PRODUCTO_DESCRIPCION'] ?? 'Sin descripción') ?></p>
                            </div>
                        </div>
                        <div class="product-detail-price">
                            <span><strong>Precio:
                                </strong>₡<?= number_format($product['PRODUCTO_PRECIO_UNITARIO'], 2, ',', '.' ?? 'Sin precio') ?></span>
                        </div>
                        <div class="product-detail-addCart">
                            <div class="product-detail-card-button">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <button class="btn-orange btnAddToCart"
                                        data-id="<?= htmlspecialchars($product['ID_PRODUCTO_PK']) ?>"
                                        <?= ($product['PRODUCTO_STOCK'] <= 0 ? 'disabled' : '') ?>>
                                        <?= ($product['PRODUCTO_STOCK'] <= 0 ? 'Sin stock' : 'Añadir al Carrito') ?>
                                    </button>
                                <?php else: ?>
                                    <a class="btn-orange btnLogin" href="#">Añadir al Carrito</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="product-comments-container">
                    <h2>Comentarios</h2>
                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div id="comment-<?= $comment['ID_COMENTARIO_PK'] ?>" class="comment-card">
                                <div class="comment-header">
                                    <img src="<?= htmlspecialchars($comment['USUARIO_IMAGEN_URL'] ?? BASE_URL . '/public/assets/images/default-user-image.png') ?>"
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
                                <div>
                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['ID_USUARIO_FK']): ?>
                                        <div class="comment-actions">
                                            <button class="btn-yellow btnEdit"
                                                data-id="<?= $comment['ID_COMENTARIO_PK'] ?>">Editar</button>
                                            <button class="btn-black btnDelete"
                                                data-id="<?= $comment['ID_COMENTARIO_PK'] ?>">Eliminar</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Aún no hay comentarios para este producto.</p>
                    <?php endif; ?>
                    <div class="product-comments-addComment">
                        <form id="formAddComment" class="form-item" onsubmit="return false;">
                            <div>
                                <span>Agrega un comentario del producto</span>
                            </div>
                            <div class="rating-stars">
                                <i class="bi bi-star" data-value="1"></i>
                                <i class="bi bi-star" data-value="2"></i>
                                <i class="bi bi-star" data-value="3"></i>
                                <i class="bi bi-star" data-value="4"></i>
                                <i class="bi bi-star" data-value="5"></i>
                            </div>
                            <input type="hidden" id="rating" value="5">
                            <textarea id="commentText" placeholder="Escribe tu comentario..."></textarea>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button type="submit" class="btn-purple mt-3" id="btnAddComment">Agregar Comentario</button>
                            <?php else: ?>
                                <button class="btn-purple btnLogin" disabled title="Inicia sesión para comentar">
                                    Inicia sesión para comentar
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!--Modal para editar comentario-->
    <div class="modal fade" id="editCommentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar comentario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea id="editCommentText" class="form-control"></textarea>
                    <div class="rating-stars edit-stars mt-2">
                        <i class="bi bi-star" data-value="1"></i>
                        <i class="bi bi-star" data-value="2"></i>
                        <i class="bi bi-star" data-value="3"></i>
                        <i class="bi bi-star" data-value="4"></i>
                        <i class="bi bi-star" data-value="5"></i>
                    </div>
                    <input type="hidden" id="editRating" value="5">
                    <input type="hidden" id="editCommentId">
                </div>
                <div class="modal-footer">
                    <button class="btn-green" id="updateCommentBtn">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!--CONTENIDO CENTRAL-->
</body>

<!--FOODER-->
<?php require_once __DIR__ . "/../partials/fooder.php"; ?>
<!--FOODER-->

</html>
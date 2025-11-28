<?php
//NO QUITAR//
require_once __DIR__ . '/../../app/config/bootstrap.php';
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
    <?php require_once __DIR__ . "/client/partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section id="sliderBanner" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="slider-banner carousel-inner">
                <?php if (!empty($banners)): ?>
                    <?php foreach ($banners as $index => $banner): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars($banner['IMAGEN_URL']) ?>" class="w-100"
                                alt="<?= htmlspecialchars($banner['DESCRIPCION_SLIDER_BANNER'] ?? 'Banner') ?>">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay banners disponibles.</p>
                <?php endif; ?>
            </div>

            <!-- Controles de navegación -->
            <button class="carousel-control-prev" type="button" data-bs-target="#sliderBanner" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#sliderBanner" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </section>


        <section class="main-content">
            <div class="index-content">
                <div class="index-tittles">
                    <h1><strong>Marcas Favoritas ❤️</strong></h1>
                    <div class="btns-arrows">
                        <a id="brand-left"><i class="bi bi-arrow-left-circle"></i></a>
                        <a id="brand-right"><i class="bi bi-arrow-right-circle"></i></a>
                    </div>
                </div>

                <div class="circle-container-list-wrapper">
                    <div class="circle-container-list" id="brand-carousel">
                        <?php if (!empty($brands)): ?>
                            <?php foreach ($brands as $brand): ?>
                                <div class="circle-item">
                                    <a href="#">
                                        <div class="circle-container">
                                            <img src="<?= htmlspecialchars($brand['MARCA_IMAGEN_URL']) ?>"
                                                alt="<?= htmlspecialchars($brand['NOMBRE_MARCA']) ?>">
                                        </div>
                                        <div>
                                            <span><?= htmlspecialchars($brand['NOMBRE_MARCA']) ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay marcas disponibles.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <hr />
                <?php if (!empty($newproducts) && count($newproducts) > 3): ?>
                    <div class="index-tittles">
                        <h1><strong>Productos Nuevos 🌟</strong></h1>
                        <div class="btns-arrows">
                            <a id="product-left"><i class="bi bi-arrow-left-circle"></i></a>
                            <a id="product-right"><i class="bi bi-arrow-right-circle"></i></a>
                        </div>
                    </div>

                    <!-- Carousel productos (muestra 5 por vista, navegación con flechas) -->
                    <div class="cards-carousel-wrapper">
                        <div class="cards-list-main" id="product-carousel">
                            <?php if (!empty($newproducts)): ?>
                                <?php foreach ($newproducts as $newproduct): ?>
                                    <div class="cards product-item">
                                        <a
                                            href="<?= BASE_URL ?>/index.php?controller=product&action=productsDetails&id=<?= $newproduct['ID_PRODUCTO_PK'] ?>">
                                            <div>
                                                <div class="card-img">
                                                    <img src="<?= htmlspecialchars($newproduct['IMAGEN_URL'] ?? 'assets/images/no-img.png') ?>"
                                                        alt="<?= htmlspecialchars($newproduct['NOMBRE_PRODUCTO'] ?? '') ?>"
                                                        style="width:100%; height:100%; object-fit:cover;">
                                                </div>
                                                <div class="card-name">
                                                    <?= htmlspecialchars($newproduct['PRODUCTO_NOMBRE'] ?? 'Sin nombre') ?>
                                                </div>
                                                <div class="card-description product-description">
                                                    <?= htmlspecialchars($newproduct['PRODUCTO_DESCRIPCION'] ?? '') ?>
                                                </div>
                                            </div>
                                            <div class="card-price">
                                                ₡<?= number_format($newproduct['PRODUCTO_PRECIO_UNITARIO'], 2, ',', '.' ?? 'Sin precio') ?>
                                            </div>
                                        </a>
                                        <div class="card-button">
                                            <?php if (isset($_SESSION['user_id'])): ?>
                                                <button class="btn-orange btnAddToCart"
                                                    data-id="<?= htmlspecialchars($newproduct['ID_PRODUCTO_PK']) ?>"
                                                    <?= ($newproduct['PRODUCTO_STOCK'] <= 0 ? 'disabled' : '') ?>>
                                                    <?= ($newproduct['PRODUCTO_STOCK'] <= 0 ? 'Sin stock' : 'Añadir al Carrito') ?>
                                                </button>
                                            <?php else: ?>
                                                <a class="btn-orange btnLogin" href="#">Añadir al Carrito</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay productos nuevos disponibles.</p>
                            <?php endif; ?>
                        </div>
                    </div>


                    <hr />
                <?php endif; ?>

                <?php if (!empty($food) && count($food) > 3): ?>
                    <div class="index-tittles">
                        <h1><strong>Alimentos 🐶🍽️</strong></h1>
                        <div class="btns-arrows">
                            <a id="food-left"><i class="bi bi-arrow-left-circle"></i></a>
                            <a id="food-right"><i class="bi bi-arrow-right-circle"></i></a>
                        </div>
                    </div>

                    <div class="cards-carousel-wrapper">
                        <div class="cards-list-main" id="food-carousel">
                            <?php if (!empty($food)): ?>
                                <?php foreach ($food as $foodItem): ?>
                                    <div class="cards product-item">
                                        <a
                                            href="<?= BASE_URL ?>/index.php?controller=product&action=productsDetails&id=<?= $foodItem['ID_PRODUCTO_PK'] ?>">
                                            <div>
                                                <div class="card-img">
                                                    <img src="<?= htmlspecialchars($foodItem['IMAGEN_URL'] ?? 'assets/images/no-img.png') ?>"
                                                        alt="<?= htmlspecialchars($foodItem['NOMBRE_PRODUCTO'] ?? '') ?>"
                                                        style="width:100%; height:100%; object-fit:cover;">
                                                </div>
                                                <div class="card-name">
                                                    <?= htmlspecialchars($foodItem['PRODUCTO_NOMBRE'] ?? 'Sin nombre') ?>
                                                </div>
                                                <div class="card-description product-description">
                                                    <?= htmlspecialchars($foodItem['PRODUCTO_DESCRIPCION'] ?? '') ?>
                                                </div>
                                            </div>
                                            <div class="card-price">
                                                ₡<?= number_format($foodItem['PRODUCTO_PRECIO_UNITARIO'], 2, ',', '.' ?? 'Sin precio') ?>
                                            </div>
                                        </a>
                                        <div class="card-button">
                                            <?php if (isset($_SESSION['user_id'])): ?>
                                                <button class="btn-orange btnAddToCart"
                                                    data-id="<?= htmlspecialchars($foodItem['ID_PRODUCTO_PK']) ?>"
                                                    <?= ($foodItem['PRODUCTO_STOCK'] <= 0 ? 'disabled' : '') ?>>
                                                    <?= ($foodItem['PRODUCTO_STOCK'] <= 0 ? 'Sin stock' : 'Añadir al Carrito') ?>
                                                </button>
                                            <?php else: ?>
                                                <a class="btn-orange btnLogin" href="#">Añadir al Carrito</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay alimentos disponibles.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr />

                <?php endif; ?>

                <?php if (!empty($accessories) && count($accessories) > 3): ?>
                    <div class="index-tittles">
                        <h1><strong>Accesorios 🦮</strong></h1>
                        <div class="btns-arrows">
                            <a id="accessory-left"><i class="bi bi-arrow-left-circle"></i></a>
                            <a id="accessory-right"><i class="bi bi-arrow-right-circle"></i></a>
                        </div>
                    </div>

                    <div class="cards-carousel-wrapper">
                        <div class="cards-list-main" id="accessory-carousel">
                            <?php if (!empty($accessories)): ?>
                                <?php foreach ($accessories as $accessory): ?>
                                    <div class="cards product-item">
                                        <a
                                            href="<?= BASE_URL ?>/index.php?controller=product&action=productsDetails&id=<?= $accessory['ID_PRODUCTO_PK'] ?>">
                                            <div>
                                                <div class="card-img">
                                                    <img src="<?= htmlspecialchars($accessory['IMAGEN_URL'] ?? 'assets/images/no-img.png') ?>"
                                                        alt="<?= htmlspecialchars($accessory['NOMBRE_PRODUCTO'] ?? '') ?>"
                                                        style="width:100%; height:100%; object-fit:cover;">
                                                </div>
                                                <div class="card-name">
                                                    <?= htmlspecialchars($accessory['PRODUCTO_NOMBRE'] ?? 'Sin nombre') ?>
                                                </div>
                                                <div class="card-description product-description">
                                                    <?= htmlspecialchars($accessory['PRODUCTO_DESCRIPCION'] ?? '') ?>
                                                </div>
                                            </div>
                                            <div class="card-price">
                                                ₡<?= number_format($accessory['PRODUCTO_PRECIO_UNITARIO'], 2, ',', '.' ?? 'Sin precio') ?>
                                            </div>
                                        </a>
                                        <div class="card-button">
                                            <?php if (isset($_SESSION['user_id'])): ?>
                                                <button class="btn-orange btnAddToCart"
                                                    data-id="<?= htmlspecialchars($accessory['ID_PRODUCTO_PK']) ?>"
                                                    <?= ($accessory['PRODUCTO_STOCK'] <= 0 ? 'disabled' : '') ?>>
                                                    <?= ($accessory['PRODUCTO_STOCK'] <= 0 ? 'Sin stock' : 'Añadir al Carrito') ?>
                                                </button>
                                            <?php else: ?>
                                                <a class="btn-orange btnLogin" href="#">Añadir al Carrito</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay Accesorios disponibles</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr />

                <?php endif; ?>


                <?php if (!empty($medications) && count($medications) > 3): ?>
                    <div class="index-tittles">
                        <h1><strong>Medicamentos 💊</strong></h1>
                        <div class="btns-arrows">
                            <a id="medication-left"><i class="bi bi-arrow-left-circle"></i></a>
                            <a id="medication-right"><i class="bi bi-arrow-right-circle"></i></a>
                        </div>
                    </div>

                    <div class="cards-carousel-wrapper">
                        <div class="cards-list-main" id="medication-carousel">
                            <?php if (!empty($medications)): ?>
                                <?php foreach ($medications as $medication): ?>
                                    <div class="cards product-item">
                                        <a
                                            href="<?= BASE_URL ?>/index.php?controller=product&action=productsDetails&id=<?= $medication['ID_PRODUCTO_PK'] ?>">
                                            <div>
                                                <div class="card-img">
                                                    <img src="<?= htmlspecialchars($medication['IMAGEN_URL'] ?? 'assets/images/no-img.png') ?>"
                                                        alt="<?= htmlspecialchars($medication['NOMBRE_PRODUCTO'] ?? '') ?>"
                                                        style="width:100%; height:100%; object-fit:cover;">
                                                </div>
                                                <div class="card-name">
                                                    <?= htmlspecialchars($medication['PRODUCTO_NOMBRE'] ?? 'Sin nombre') ?>
                                                </div>
                                                <div class="card-description product-description">
                                                    <?= htmlspecialchars($medication['PRODUCTO_DESCRIPCION'] ?? '') ?>
                                                </div>
                                            </div>
                                            <div class="card-price">
                                                ₡<?= number_format($medication['PRODUCTO_PRECIO_UNITARIO'], 2, ',', '.' ?? 'Sin precio') ?>
                                            </div>
                                        </a>
                                        <div class="card-button">
                                            <?php if (isset($_SESSION['user_id'])): ?>
                                                <button class="btn-orange btnAddToCart"
                                                    data-id="<?= htmlspecialchars($medication['ID_PRODUCTO_PK']) ?>"
                                                    <?= ($medication['PRODUCTO_STOCK'] <= 0 ? 'disabled' : '') ?>>
                                                    <?= ($medication['PRODUCTO_STOCK'] <= 0 ? 'Sin stock' : 'Añadir al Carrito') ?>
                                                </button>
                                            <?php else: ?>
                                                <a class="btn-orange btnLogin" href="#">Añadir al Carrito</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay medicamentos disponibles.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="testimonios">
            <div class="header-testimonios">
                <h2><strong>Testimonios de Nuestros Clientes</strong></h2>
            </div>
            <div class="main-testimonios">
                <div class="card-content-testimonios">
                    <div class="header-card-content-testimonios">
                        Juan
                    </div>
                    <div><i class="bi bi-quote"></i></div>
                    <div class="main-card-content-testimonios">
                        <p>
                            Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.
                        </p>
                    </div>
                </div>
                <div class="card-content-testimonios">
                    <div class="header-card-content-testimonios">
                        Maria
                    </div>
                    <div><i class="bi bi-quote"></i></div>
                    <div class="main-card-content-testimonios">
                        <p>
                            Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.
                        </p>
                    </div>
                </div>
                <div class="card-content-testimonios">
                    <div class="header-card-content-testimonios">
                        Pablo
                    </div>
                    <div><i class="bi bi-quote"></i></div>
                    <div class="main-card-content-testimonios">
                        <p>
                            Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOODER-->
<?php require_once __DIR__ . "/client/partials/fooder.php"; ?>
<!--FOODER-->

</html>
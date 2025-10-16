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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/huellitasdigital/public/js/script.js"></script>
</head>

<body>
    <!--HEADER-->
    <?php require_once __DIR__ . "/client/partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section id="sliderBanner" class="carousel slide" data-bs-ride="carousel">
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
                                <div class="brand-item">
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
                                    <a href="/huellitasdigital/app/controllers/client/productController.php?action=productsDetails&id=<?= $newproduct['ID_PRODUCTO_PK'] ?>">
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
                                            ₡<?= htmlspecialchars($newproduct['PRODUCTO_PRECIO_UNITARIO'] ?? '$0') ?>
                                        </div>
                                    </a>
                                    <div class="card-button">
                                        <?php if (isset($_SESSION['user_name'])): ?>
                                            <a class="btn-orange"
                                                href="/huellitasdigital/app/controllers/client/productController.php?action=addToCart&id=<?= htmlspecialchars($newproduct['ID_PRODUCTO'] ?? 0) ?>">Añadir
                                                al Carrito</a>
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

                <div class="index-tittles">
                    <h1><strong>Productos en Descuento 📣</strong></h1>
                    <div class="btns-arrows">
                        <a href="#"><i class="bi bi-arrow-left-circle"></i></a>
                        <a href="#"><i class="bi bi-arrow-right-circle"></i></a>
                    </div>
                </div>

                <!--Lista de productos como ejemplo-->
                <div class="cards-list-main">
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="index-tittles">
                    <h1><strong>Medicamentos 💊</strong></h1>
                    <div class="btns-arrows">
                        <a href="#"><i class="bi bi-arrow-left-circle"></i></a>
                        <a href="#"><i class="bi bi-arrow-right-circle"></i></a>
                    </div>
                </div>

                <!--Lista de productos como ejemplo-->
                <div class="cards-list-main">
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card-img">img</div>
                        <div class="card-name">Nombre:</div>
                        <div class="card-description">Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                            Fusce a
                            euismod
                            est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.</div>
                        <div class="card-price">$1.100</div>
                        <div class="card-button">
                            <a class="btn-orange" href="pages/cart.php">Añadir al Carrito</a>
                        </div>
                    </div>
                </div>
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
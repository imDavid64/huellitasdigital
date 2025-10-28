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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>/public/js/script.js"></script>
</head>

<body>
    <header class="main-header">
        <nav class="header-container">
            <div class="header-container-left">
                <!--Boton del logo-->
                <div>
                    <a href="../index.html" class="header-logo">
                        <img src="../assets/images/Logo-AzulOscuro.png" alt="Logo Veterinaria Dra.Huellitas">
                        <span>Huellitas<br><strong>Digital</strong></span>
                    </a>
                </div>
                <!--Boton de nuestra Ubicación-->
                <div>
                    <a href="#" class="header-vet-location">
                        <i class="bi bi-geo-alt"></i>
                    </a>
                </div>
                <!--Barra de busqueda-->
                <div class="header-search">
                    <input type="text" id="header-search" placeholder="Buscar">
                    <i class="bi bi-search"></i>
                </div>
                <!--Boton de carrito-->
                <div class="header-cart">
                    <div>
                        <a class="btn-orange" href="cart.html">Carrito <i class="bi bi-cart"></i></a>
                    </div>
                </div>
            </div>

            <!--Botones de Login, registro e info del usuario-->
            <div class="header-container-right">
                <div class="header-myPets">
                    <div>
                        <a class="btn-green" href="myPets/home.html">Mis Mascotas <i
                                class="bi bi-clipboard-heart"></i></a>
                    </div>
                </div>
                <div class="header-user">
                    <span>Bienvenido!</span>
                    <h4> <span>User_Name</span></h4>
                </div>
                <div>
                    <button class="header-user-img" id="header-user-img">
                        <i class="bi bi-person-fill"></i>
                    </button>
                    <!---->
                    <div class="header-user-menu" id="header-user-menu">
                        <ul>
                            <li><a href="profile.html"><i class="bi bi-person-fill"></i> Mi Pefil</a></li>
                            <li><a href="myOrders.html"><i class="bi bi-bag-check-fill"></i> Mis Pedidos</a></li>
                            <li><a href="myAppointment"><i class="bi bi-calendar-event-fill"></i> Mis Citas</a></li>
                            <li><a href="../index_unlogin.html"><i class="bi bi-door-open-fill"></i> Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!--Barra de navegación-->
        <nav class="navbar-container">
            <ul>
                <li><a href="../index.html">Inicio</a></li>
                <li>
                    <a href="products.html">Productos <i class="bi bi-caret-down-fill"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="Products/alimentos.html">Alimentos</a></li>
                        <li><a href="Products/accesorios.html">Accesorios</a></li>
                        <li><a href="Products/medicamentos.html">Medicamentos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="services.html">Servicios <i class="bi bi-caret-down-fill"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="services/consultas.html">Consultas</a></li>
                        <li><a href="services/vacunas.html">Vacunas</a></li>
                        <li><a href="services/desparacitacion.html">Desparacitación</a></li>
                        <li><a href="services/examLab.html">Examenes de Laboratorio</a></li>
                        <li><a href="services/ultrasonido.html">Ultrasonido</a></li>
                        <li><a href="services/cirugiasMenores.html">Cirugias Menores</a></li>
                        <li><a href="services/limpiezasDentales.html">Limpiezas Dentales</a></li>
                    </ul>
                </li>
                <li>
                    <a href="aboutUs.html">Sobre Nosotros</a>
                </li>
                <li><a href="index_unlogin.html">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>
    <!--HEADER-->

    <!--Breadcrumb-->
    <nav class="breadcrumbs-container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../index.html">Inicio</a>
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
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <img src="../assets/images/products/img-proplan-Puppy.png" alt="Producto 1">
                                <div>
                                    <h5>Producto 1</h5>
                                    <p>
                                        Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                                        Fusce a
                                        euismod
                                        est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.
                                    </p>
                                    <span class=""><strong>₡6.500</strong></span>
                                </div>
                            </div>
                            <div class="cart-item-details">
                                <span class="cart-price">₡6.500</span>
                                <div class="cart-sum-item">
                                    <a href="#"><i class="bi bi-dash-circle"></i></a>
                                    <input type="number" value="1" min="1" class="quantity-input">
                                    <a href="#"><i class="bi bi-plus-circle"></i></a>
                                </div>
                                <a href="#" class="btn-cart-remove"><i class="bi bi-trash"></i></a>
                            </div>
                        </div>
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <img src="../assets/images/products/img-digyton.png" alt="Producto 1">
                                <div>
                                    <h5>Producto 2</h5>
                                    <p>
                                        Lorem ipsum dolor sit amet vitae, fringilla iaculis ante.
                                        Fusce a
                                        euismod
                                        est. Morbi accumsan imperdiet tortor, vitae faucibus sem molestie at.
                                    </p>
                                    <span class=""><strong>₡6.500</strong></span>
                                </div>
                            </div>
                            <div class="cart-item-details">
                                <span class="cart-price">₡6.500</span>
                                <div class="cart-sum-item">
                                    <a href="#"><i class="bi bi-dash-circle"></i></i></a>
                                    <input type="number" value="1" min="1" class="quantity-input">
                                    <a href="#"><i class="bi bi-plus-circle"></i></a>
                                </div>
                                <a href="#" class="btn-cart-remove"><i class="bi bi-trash"></i></a>
                            </div>
                        </div>
                        <div class="cart-calc-container">
                            <div class="cart-calc-content">
                                <span class="cart-calc-title">Subtotal:</span>
                                <span class="cart-calc-price">₡13.000</span>
                            </div>
                            <div class="cart-calc-content">
                                <span class="cart-calc-title">Envío: </span>
                                <span class="cart-calc-price">₡2.000</span>
                            </div>
                            <div class="cart-calc-content">
                                <span class="cart-calc-title">Total: </span>
                                <span class="cart-calc-price"><strong>₡15.000</strong></span>
                            </div>
                            <div>
                                <a href="#" class="btn-orange">Finalizar mi compra</a>
                            </div>
                        </div>
                
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOOTER-->
<footer>
    <div class="pre-footer">
        <div>
            <span><strong>Contáctenos:</strong></span>
        </div>
        <div class="footer-contact">
            <div><i class="bi bi-whatsapp"></i>+506 7210 9730</div>
            <div><i class="bi bi-telephone"></i>+506 2102 8142</div>
            <div><i class="bi bi-envelope"></i>drahuellitas@gmail.com</div>
        </div>
    </div>
    <div class="footer-content">
        <div class="r">
            <div>
                <a href="../index.html" class="footer-logo">
                    <img src="../assets/images/logo.png" alt="Logo Veterinaria Dra.Huellitas">
                    <span>Veterinaria <br><strong>Dra.Huellitas</strong></span>
                </a>
            </div>
        </div>
        <div>
            <div class="footer-interest-links">
                <span><strong>Links de Interés</strong></span>
                <a href="/pages/advices/#">Sobre Nosotros</a>
                <a href="/pages/advices/#">Preguntas Frecuentes</a>
                <a href="/pages/advices/#">Nuestra Misión y Visión</a>
            </div>
            <div class="social-media">
                <span><strong>Nuestras Redes Sociales</strong></span>
                <div>
                    <a href="https://www.instagram.com/drahuellitascr"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.facebook.com/drahuellitas"><i class="bi bi-facebook"></i></a>
                    <a href="https://wa.me/50672109730"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1168.1526247390802!2d-84.13922709798275!3d10.0018685338411!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0fb25f08bfa0f%3A0xde176276b76b0b2b!2sVeterinaria%20Dra%20Huellitas!5e0!3m2!1ses!2scr!4v1754965379769!5m2!1ses!2scr"
                width="500" height="400" style="border-radius:10px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <div class="post-footer">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>
<!--FOOTER-->

</html>
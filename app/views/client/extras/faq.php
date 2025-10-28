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
                        <img src="../../assets/images/logo.png" alt="Logo Veterinaria Dra.Huellitas">
                        <span>Huellitas <br><strong>Digital</strong></span>
                    </a>
                </div>
                <!--Barra de busqueda-->
                <div class="header-search">
                    <input type="text" id="header-search" placeholder="Buscar">
                    <i class="bi bi-search"></i>
                </div>
                <!--Boton de nuestra Ubicación-->
                <div>
                    <a href="pages/location.php" class="header-vet-location">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <span>Nuestra<br><strong>Ubicación</strong></span>
                        </div>
                    </a>
                </div>
                <!--Boton de carrito-->
                <div class="header-cart">
                    <div>
                        <a class="btn-orange" href="pages/cart.php">Carrito <i class="bi bi-cart"></i></a>
                    </div>
                </div>
            </div>

            <!--Botones de Login, registro e info del usuario-->
            <div class="header-container-right">
                <div class="header-myPets">
                    <div>
                        <a class="btn-green" href="pages/cart.php">Mis Mascotas <i
                                class="bi bi-clipboard-heart"></i></a>
                    </div>
                </div>
                <div class="header-user">
                    <span>Bienvenido!</span>
                    <h3> <span>User_Name</span></h3>
                </div>
                <div class="">
                    <button class="header-user-img" id="header-user-img">
                        <i class="bi bi-person-fill"></i>
                    </button>
                    <!---->
                    <div class="header-user-menu" id="header-user-menu">
                        <ul>
                            <li><a href="pages/profile.html">Mi Pefil</a></li>
                            <li><a href="Procuto.php">Mis pedidos</a></li>
                            <li><a href="index_unlogin.html" style="color: red;">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!--Barra de navegación-->
        <nav class="navbar-container">
            <ul>
                <li><a href="../../index.html">Inicio</a></li>
                <li>
                    <a href="../products.html">Productos <i class="bi bi-caret-down-fill"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="alimentos.html">Alimentos</a></li>
                        <li><a href="accesorios.html">Accesorios</a></li>
                        <li><a href="medicamentos.html">Medicamentos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Servicios <i class="bi bi-caret-down-fill"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Alimentos</a></li>
                        <li><a href="#">Accesorios</a></li>
                        <li><a href="#">Medicamentos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Consejos <i class="bi bi-caret-down-fill"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Alimentos</a></li>
                        <li><a href="#">Accesorios</a></li>
                        <li><a href="#">Medicamentos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Sobre Nosotros <i class="bi bi-caret-down-fill"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Alimentos</a></li>
                        <li><a href="#">Accesorios</a></li>
                        <li><a href="#">Medicamentos</a></li>
                    </ul>
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
            <li class="breadcrumb-item">
                <a href="../products.html">Productos</a>
            </li>
            <li class="breadcrumb-item current-page">Accesorios</li>
        </ol>
    </nav>


    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="main-content">
            <div>
                <div class="tittles">
                    <div>
                        <h2>Accesorios</h2>
                    </div>
                </div>

                <!--Lista de productos "Accesorios" como ejemplo-->
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
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOOTER-->
<footer>
    <div class="footer-left">
        <div>
            <a href="index.php" class="footer-logo">
                <img src="../../assets/images/logo.png" alt="Logo Veterinaria Dra.Huellitas">
                <span>Veterinaria <br><strong>Dra.Huellitas</strong></span>
            </a>
        </div>
        <div class="social-media">
            <a href="https://www.instagram.com/drahuellitascr"><i class="bi bi-instagram"></i></a>
            <a href="https://www.facebook.com/drahuellitas"><i class="bi bi-facebook"></i></a>
            <a href="https://wa.me/50672109730"><i class="bi bi-whatsapp"></i></a>
        </div>
    </div>
    <div class="footer-right">
        <span>Contactenos</span>
        <div><i class="bi bi-geo-alt"></i>Heredia, Mercedes Sur, 40102</div>
        <div><i class="bi bi-envelope"></i>drahuellitas@gmail.com</div>
        <div><i class="bi bi-telephone"></i>+506 2102 8142</div>
    </div>
</footer>
<!--FOOTER-->

</html>
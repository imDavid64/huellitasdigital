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
    <!--HEADER-->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="static-banner">
            <img src="<?= BASE_URL ?>/public/assets/images/static-banners/img-banner-services-4.png" alt="Banner">
            <span class="tittle-static-banner">Sobre Nosotros</span>
        </section>

        <!--Breadcrumb-->
        <nav class="breadcrumbs-container-client">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a>
                </li>
                <li class="breadcrumb-item current-page">Sobre Nosotros</li>
            </ol>
        </nav>
        <section class="main-content">
            <div class="pages-info-content">
                <div class="tittles">
                    <h1><strong>Quienes Somos 🙌</strong></h1>
                </div>
                <div class="aboutUs-container">
                    <div class="whoWeAre-container-left">
                        <img src="<?= BASE_URL ?>/public/assets/images/aboutUs/Dra.Huellitas-Emoji-shadow.png">
                        <span><strong>Dra. Yorsy Isabel Orozco Samudio</strong></span>
                        <span>Lda. Medicina y cirugía Veterinaria</span>
                    </div>
                    <div class="whoWeAre-container-right">
                        <P>
                            Desde temprana edad, mi pasión por los animales me impulsó a perseguir mi sueño de
                            convertirme en veterinaria.
                            Mi amor incondicional y dedicación hacia estos seres especiales me llevó a estudiar
                            medicina y cirugía veterinaria, con el objetivo de brindarles la mejor atención
                            posible y transmitir un mensaje de conciencia y cuidado hacia ellos.
                        </P>
                    </div>
                </div>

                <div class="tittles">
                    <h1><strong>Nuestra Misión y Visión 🚀</strong></h1>
                </div>
                <div class="aboutUs-container">
                    <div class="misionVision-container-left">
                        <div>
                            <h4><strong>Misión</strong></h4>
                            <P>
                                Brindamos servicios de salud y cuidados veterinarios en un ambiente de calidad, que
                                permitan cumplir con las exigencias de nuestros clientes, enfocándonos en educar para
                                promover la salud y bienestar animal.
                            </P>
                        </div>
                        <img src="<?= BASE_URL ?>/public/assets/images/aboutUs/img-cat-aboutUs.png">
                    </div>
                    <div class="misionVision-container-right">
                        <img src="<?= BASE_URL ?>/public/assets/images/aboutUs/img-dog-aboutUs.png">
                        <div>
                            <h4><strong>Visión</strong></h4>
                            <P>
                                Convertirnos en una referencia en cuidado veterinario, reconocidos por nuestra
                                excelencia en servicios y compromiso con el bienestar animal, buscando ser líderes en la
                                promoción de la salud animal a través de la educación continua y la adopción de
                                prácticas
                                innovadoras.
                            </P>
                        </div>
                    </div>
                </div>

                <div class="tittles">
                    <h1><strong>Contáctanos 📞</strong></h1>
                </div>
                <div class="aboutUs-container">
                    <div class="contactUs-container-right">
                        <di>
                            <div class="aboutUs-info-container">
                                <h5><strong>Lugar</strong></h5>
                                <p>Heredia</p>
                            </div>
                            <div class="aboutUs-info-container">
                                <h5><strong>Dirección</strong></h5>
                                <p>100 metros oeste del triangulo de Mercedes Sur</p>
                            </div>
                            <div class="aboutUs-info-container">
                                <span><strong>Teléfono</strong></span>
                                <p>+506 7210-9730</p>
                                <p>+506 2102-8142</p>
                            </div>
                            <div class="aboutUs-info-container">
                                <span><strong>Horario</strong></span>
                                <p>Lunes a Sabado de 9:00a.m a 5:30p.m</p>
                                <p>Domingo: Cerrado</p>
                            </div>
                        </di>
                    </div>
                    <div class="contactUs-container-left">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1168.1526247390802!2d-84.13922709798275!3d10.0018685338411!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0fb25f08bfa0f%3A0xde176276b76b0b2b!2sVeterinaria%20Dra%20Huellitas!5e0!3m2!1ses!2scr!4v1754965379769!5m2!1ses!2scr"
                            width="500" height="400" style="border-radius:10px;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
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
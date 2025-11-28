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
        <!--Breadcrumb-->
        <nav class="breadcrumbs-container-client">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/huellitasdigital/index.php?controller=home&action=index">Inicio</a>
                </li>
                <li class="breadcrumb-item current-page">Contacto para cita</li>
            </ol>
        </nav>
        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Agendar Cita</strong></h1>
                </div>
                <div class="contact-info-container mt-4 p-4 border rounded shadow-sm bg-light">

                    <h3 class="mb-3"><strong>Información para agendar tu cita</strong></h3>

                    <p class="mb-2 fs-5">
                        <i class="bi bi-envelope-fill"></i>
                        <strong>Correo:</strong>
                        <a href="mailto:drahuellitas@gmail.com">drahuellitas@gmail.com</a>
                    </p>

                    <p class="mb-2 fs-5">
                        <i class="bi bi-telephone-fill"></i>
                        <strong>Teléfono fijo:</strong>
                        <a href="tel:+50621028142">+506 2102 8142</a>
                    </p>

                    <p class="mb-2 fs-5">
                        <i class="bi bi-phone-fill"></i>
                        <strong>WhatsApp:</strong>
                        <a href="https://wa.me/50672109730" target="_blank">+506 7210 9730</a>
                    </p>

                    <hr>

                    <p class="text-muted fs-5">
                        Puedes agendar tu cita por cualquiera de estos medios.
                        Con gusto te atenderemos.
                    </p>
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
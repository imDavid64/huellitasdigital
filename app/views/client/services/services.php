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
            <span class="tittle-static-banner">Servicios</span>
        </section>
        <!--Breadcrumb-->
        <nav class="breadcrumbs-container-client">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a>
                </li>
                <li class="breadcrumb-item current-page">Productos</li>
            </ol>
        </nav>
        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Nuestros Servicios</strong></h1>
                </div>
                <div class="circle-container-list-service">
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <a href="<?= BASE_URL ?>/index.php?controller=service&action=serviceDetails&idService=<?= $service['ID_SERVICIO_PK'] ?>">
                                <div class="circle-container">
                                    <img src="<?= htmlspecialchars($service['IMAGEN_URL']) ?>"
                                        alt="<?= htmlspecialchars($service['NOMBRE_SERVICIO']) ?>">
                                </div>
                                <div>
                                    <span><?= htmlspecialchars($service['NOMBRE_SERVICIO']) ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay marcas disponibles.</p>
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
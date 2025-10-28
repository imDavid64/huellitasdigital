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
                    <a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>/index.php?controller=service&action=index">Servicios</a>
                </li>
                <li class="breadcrumb-item current-page">
                    <?= htmlspecialchars($serviceSelected['NOMBRE_SERVICIO'] ?? 'Sin nombre') ?>
                </li>
            </ol>
        </nav>
        <section class="main-content">
            <div class="pages-info-content">
                <div class="subtitles">
                    <div>
                        <h1><strong><?= htmlspecialchars($serviceSelected['NOMBRE_SERVICIO'] ?? 'Sin nombre') ?></strong>
                        </h1>
                    </div>
                </div>
                <div>
                    <div class="main-service-info">
                        <div class="service-img-info">
                            <img src="<?= htmlspecialchars($serviceSelected['IMAGEN_URL']) ?>">
                        </div>
                        <div>
                            <span><strong>Descripción</strong></span>
                            <div class="service-detail-description-text">
                                <p><?= htmlspecialchars($serviceSelected['DESCRIPCION_SERVICIO'] ?? 'Sin descripción') ?>
                                </p>
                            </div>
                            <div class="schedule-appointment-service-btn">
                                <a href="<?= BASE_URL ?>/index.php?controller=appointment&action=index"
                                    class="btn-dark-blue">Agendar Cita<i class="bi bi-calendar4-week"></i></a>
                            </div>
                        </div>
                        <div class="service-list-info">
                            <h2><strong>Servicios</strong></h2>
                            <div class="service-list-scroll">
                                <ul>
                                    <?php if (!empty($services)): ?>
                                        <?php foreach ($services as $listServices): ?>
                                            <?php if (($serviceSelected['ID_SERVICIO_PK'] === $listServices['ID_SERVICIO_PK'])): ?>
                                                <li>
                                                    <strong>
                                                        <a
                                                            href="<?= BASE_URL ?>/index.php?controller=service&action=serviceDetails&idService=<?= $listServices['ID_SERVICIO_PK'] ?>">
                                                            <?= htmlspecialchars($listServices['NOMBRE_SERVICIO']) ?>
                                                        </a>
                                                    </strong>
                                                </li>
                                            <?php else: ?>
                                                <li>
                                                    <a
                                                        href="<?= BASE_URL ?>/index.php?controller=service&action=serviceDetails&idService=<?= $listServices['ID_SERVICIO_PK'] ?>">
                                                        <?= htmlspecialchars($listServices['NOMBRE_SERVICIO']) ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>No hay servicios disponibles.</p>
                                    <?php endif; ?>
                                </ul>
                            </div>
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
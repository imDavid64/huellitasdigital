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
                    <a href="<?= BASE_URL ?>/index.php?controller=pets&action=index">Mis Mascotas</a>
                </li>
                <li class="breadcrumb-item current-page">
                    Mis Mascotas
                </li>
            </ol>
        </nav>
        <main>
            <section class="main-content">
                <div>
                    <div class="tittles">
                        <h1><strong>Información de <?= htmlspecialchars($mascota['NOMBRE_MASCOTA']) ?></strong></h1>
                    </div>
                    <div class="my-pets-info-container">
                        <div class="my-pets-info-header">
                            <div class="my-pets-info-header-left">
                                <h5><strong>Nombre:</strong> <?= htmlspecialchars($mascota['NOMBRE_MASCOTA']) ?></h5>
                                <h5><strong>Especie:</strong> <?= htmlspecialchars($mascota['ESPECIE']) ?></h5>
                                <h5><strong>Raza:</strong> <?= htmlspecialchars($mascota['RAZA']) ?></h5>
                                <h5><strong>Fecha de Nacimiento:</strong>
                                    <?= htmlspecialchars($mascota['FECHA_NACIMIENTO']) ?></h5>
                            </div>
                            <div class="my-pets-info-header-right">
                                <a href="#">
                                    <img src="<?= htmlspecialchars($mascota['MASCOTA_IMAGEN_URL']) ?>" height="200px"
                                        width="200px"
                                        alt="Imagen de <?= htmlspecialchars($mascota['NOMBRE_MASCOTA']) ?>">
                                    <div class="overlay">
                                        <i class="bi bi-pencil">Editar</i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="my-pets-info-main-content">
                            <div class="my-pets-info-medical-history">
                                <h4><strong style="color: white;">Historial Medico</strong></h4>
                                <div class="my-pets-info-medical-history-list">
                                    <?php
                                    if (empty($historiales)) {
                                        echo "
                                        <div class=\"my-pets-info-medical-history-item\">
                                        <span>No hay historiales médicos registrados.</span>
                                        </div>
                                        ";
                                    } else {
                                        foreach ($historiales as $historial) {
                                            ?>
                                            <div class="my-pets-info-medical-history-item">
                                                <div>
                                                    <span><strong>Fecha:</strong>
                                                        <?= htmlspecialchars($historial['HISTORIAL_FECHA']) ?></span>
                                                    <span><strong>Hora:</strong>
                                                        <?= htmlspecialchars(date('h:ia', strtotime($historial['HISTORIAL_HORA']))) ?>
                                                    </span>
                                                </div>
                                                <button class="btn-green ver-historial-btn"
                                                    data-code="<?= htmlspecialchars($historial['CODIGO_HISTORIAL']) ?>">
                                                    Ver
                                                </button>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="my-pets-info-medical-history-info">
                                <div class="my-pets-info-medical-history-info-header">
                                    <h4><strong>Información Médica</strong></h4>
                                </div>

                                <div id="historial-detalle" class="my-pets-info-medical-history-info-content">
                                    <p style="opacity: .8;">Seleccione un historial médico para ver sus detalles.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!--CONTENIDO CENTRAL-->
        <!--FOODER-->
        <?php require_once __DIR__ . "/../partials/fooder.php"; ?>
        <!--FOODER-->
</body>

</html>
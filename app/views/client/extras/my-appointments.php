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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                <li class="breadcrumb-item current-page">Mis Citas</li>
            </ol>
        </nav>

        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Mis próximas citas 📅</strong></h1>
                </div>
                <div class="pages-info-content">
                    <div class="mt-4">

                        <?php if (empty($proximascitas)): ?>

                            <div class="alert alert-info text-center p-4">
                                <div class="fs-1">📭</div>
                                <h4 class="mt-2">No tienes citas agendadas</h4>
                                <p>Puedes agendar una nueva cita cuando lo necesites.</p>

                                <a href="<?= BASE_URL ?>/index.php?controller=appointment&action=index"
                                    class="btn-dark-blue mt-3" style="width: 180px;">Agendar cita
                                    <i class="bi bi-calendar-plus"></i>
                                </a>
                            </div>

                        <?php else: ?>

                            <div class="row g-4">
                                <?php foreach ($proximascitas as $proxc): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card border-0 rounded-4 h-100 position-relative">

                                            <!-- ENCABEZADO -->
                                            <div class="card-header text-white rounded-0 rounded-top-4"
                                                style="background-color: <?= $proxc["ESTADO"] === "CANCELADO" ? '#6c757d' : '#003780' ?>;">
                                                <strong>
                                                    📅 <?= htmlspecialchars($proxc["NOMBRE_SERVICIO"]) ?>
                                                </strong>
                                            </div>

                                            <div class="card-body">

                                                <!-- Si está cancelada, mostrar aviso -->
                                                <?php if ($proxc["ESTADO"] === "CANCELADO"): ?>
                                                    <p class="text-danger fw-bold">⚠ Cita cancelada.</p>
                                                <?php elseif ($proxc["ESTADO"] === "ACTIVO"): ?>
                                                    <p class="text-success fw-bold">✔ Cita activa. </p>
                                                <?php endif; ?>

                                                <!-- Fecha -->
                                                <p>⏰
                                                    <strong><?= date("d/m/Y h:i A", strtotime($proxc["FECHA_INICIO"])) ?></strong>
                                                </p>

                                                <!-- Servicio -->
                                                <p>🧑‍⚕️ Servicio:
                                                    <strong><?= htmlspecialchars($proxc["NOMBRE_SERVICIO"]) ?></strong>
                                                </p>

                                                <!-- Mascotas -->
                                                <p>🐾 Mascotas:</p>
                                                <ul>
                                                    <?php if (!empty($proxc["NOMBRE_MASCOTA"])): ?>
                                                        <li><?= htmlspecialchars($proxc["NOMBRE_MASCOTA"]) ?></li>
                                                    <?php endif; ?>

                                                    <?php if (!empty($proxc["MASCOTA_NOMBRE_MANUAL"])): ?>
                                                        <li><?= htmlspecialchars($proxc["MASCOTA_NOMBRE_MANUAL"]) ?></li>
                                                    <?php endif; ?>
                                                </ul>

                                                <!-- Motivo -->
                                                <?php if (!empty($proxc["MOTIVO"])): ?>
                                                    <p><strong>Motivo:</strong> <?= htmlspecialchars($proxc["MOTIVO"]) ?></p>
                                                <?php endif; ?>

                                            </div>

                                            <!-- FOOTER -->
                                            <div class="card-footer text-end bg-light rounded-4 rounded-top-0">

                                                <?php if ($proxc["ESTADO"] === "CANCELADO"): ?>

                                                    <!-- Botón deshabilitado para citas canceladas -->
                                                    <button class="btn btn-secondary w-100" disabled>
                                                        Cita Cancelada
                                                    </button>

                                                <?php else: ?>

                                                    <!-- Botón ver detalle -->
                                                    <a href="#" class="btn-blue btn-detalle-cita" style="width: 150px;"
                                                        data-id="<?= $proxc['ID_CITA_PK'] ?>"
                                                        data-fecha="<?= date("d/m/Y h:i A", strtotime($proxc['FECHA_INICIO'])) ?>"
                                                        data-servicio="<?= htmlspecialchars($proxc['NOMBRE_SERVICIO']) ?>"
                                                        data-veterinario="<?= htmlspecialchars($proxc['VETERINARIO_NOMBRE']) ?>"
                                                        data-motivo="<?= htmlspecialchars($proxc['MOTIVO'] ?? 'Sin motivo') ?>"
                                                        data-cliente="<?= htmlspecialchars($proxc['CLIENTE_NOMBRE'] ?? 'Cliente manual') ?>"
                                                        data-correo-cliente="<?= htmlspecialchars($proxc['CLIENTE_CORREO'] ?? '---') ?>"
                                                        data-telefono="<?= htmlspecialchars($proxc['CLIENTE_TELEFONO'] ?? '---') ?>"
                                                        data-identificacion="<?= htmlspecialchars($proxc['CLIENTE_IDENTIFICACION'] ?? '---') ?>"
                                                        data-mascota="<?= htmlspecialchars($proxc['NOMBRE_MASCOTA'] ?? $proxc['MASCOTA_NOMBRE_MANUAL'] ?? '---') ?>">
                                                        Ver detalle <i class="bi bi-eye"></i>
                                                    </a>

                                                <?php endif; ?>

                                            </div>

                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            </div>

                        <?php endif; ?>

                    </div>
                </div>

                <!-- =======================
                     CITAS PASADAS
                ======================= -->
                <?php if (!empty($citasPasadas)): ?>
                    <div class="tittles mt-5">
                        <h1><strong>Citas pasadas ⏳</strong></h1>
                    </div>

                    <div class="row g-4">
                        <?php foreach ($citasPasadas as $pasc): ?>
                            <div class="col-md-6 col-lg-4" style="max-width: 438px;">
                                <div class="card border-0 rounded-4 h-100 position-relative">

                                    <div class="card-header text-white rounded-0 rounded-top-4"
                                        style="background-color: <?= $pasc["ESTADO"] === "CANCELADO" ? '#6c757d' : '#6c757d' ?>;">
                                        <strong>📅 <?= htmlspecialchars($pasc["NOMBRE_SERVICIO"]) ?></strong>
                                    </div>

                                    <div class="card-body">

                                        <!-- Si está cancelada, mostrar aviso -->
                                        <?php if ($pasc["ESTADO"] === "CANCELADO"): ?>
                                            <p class="text-danger fw-bold">⚠ Cita cancelada</p>
                                        <?php elseif ($pasc["ESTADO"] === "ACTIVO"): ?>
                                            <p class="text-secondary fw-bold">⌚ Cita pasada</p>
                                        <?php endif; ?>

                                        <p>⏰ <strong><?= date("d/m/Y h:i A", strtotime($pasc["FECHA_INICIO"])) ?></strong></p>

                                        <p>🧑‍⚕️ Servicio:
                                            <strong><?= htmlspecialchars($pasc["NOMBRE_SERVICIO"]) ?></strong>
                                        </p>

                                        <p>🐾 Mascota:
                                            <strong><?= htmlspecialchars($pasc["NOMBRE_MASCOTA"] ?? $pasc["MASCOTA_NOMBRE_MANUAL"]) ?></strong>
                                        </p>

                                        <?php if (!empty($pasc["MOTIVO"])): ?>
                                            <p><strong>Motivo:</strong> <?= htmlspecialchars($pasc["MOTIVO"]) ?></p>
                                        <?php endif; ?>

                                    </div>

                                    <div class="card-footer text-end bg-light rounded-4 rounded-top-0">

                                        <?php if ($pasc["ESTADO"] === "CANCELADO"): ?>
                                            <button class="btn btn-secondary w-100" disabled>
                                                Cita cancelada
                                            </button>
                                        <?php else: ?>
                                            <a href="#" class="btn btn-sm btn-blue btn-detalle-cita" style="width: 150px;"
                                                data-id="<?= $pasc['ID_CITA_PK'] ?>"
                                                data-fecha="<?= date("d/m/Y h:i A", strtotime($pasc['FECHA_INICIO'])) ?>"
                                                data-servicio="<?= htmlspecialchars($pasc['NOMBRE_SERVICIO']) ?>"
                                                data-veterinario="<?= htmlspecialchars($pasc['VETERINARIO_NOMBRE']) ?>"
                                                data-motivo="<?= htmlspecialchars($pasc['MOTIVO'] ?? 'Sin motivo') ?>"
                                                data-cliente="<?= htmlspecialchars($pasc['CLIENTE_NOMBRE'] ?? 'Cliente manual') ?>"
                                                data-correo-cliente="<?= htmlspecialchars($pasc['CLIENTE_CORREO'] ?? '---') ?>"
                                                data-telefono="<?= htmlspecialchars($pasc['CLIENTE_TELEFONO'] ?? '---') ?>"
                                                data-identificacion="<?= htmlspecialchars($pasc['CLIENTE_IDENTIFICACION'] ?? '---') ?>"
                                                data-mascota="<?= htmlspecialchars($pasc['NOMBRE_MASCOTA'] ?? $pasc['MASCOTA_NOMBRE_MANUAL'] ?? '---') ?>">
                                                Ver detalle <i class="bi bi-eye"></i>
                                            </a>
                                        <?php endif; ?>

                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>
    <!--CONTENIDO CENTRAL-->

    <!--FOOTER-->
    <?php require_once __DIR__ . "/../partials/fooder.php"; ?>
    <!--FOOTER-->

    <!-- ============================
         MODAL DETALLE DE CITA
    ============================ -->
    <div class="modal fade" id="modalDetalleCita" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header" style="background:#003780; color:white;">
                    <h5 class="modal-title">
                        <i class="bi bi-calendar-event"></i> Detalle de la Cita
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <p><strong>📅 Fecha:</strong><br>
                                <span id="det-fecha"></span>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>🧑‍⚕️ Veterinario:</strong><br>
                                <span id="det-veterinario"></span><br>
                                <small id="det-vet-correo" class="text-muted"></small>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>🐶 Mascota:</strong><br>
                                <span id="det-mascota"></span>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>🧍 Cliente:</strong><br>
                                <span id="det-cliente"></span><br>
                                <small id="det-correo" class="text-muted"></small><br>
                                <small id="det-telefono" class="text-muted"></small><br>
                                <small id="det-identificacion" class="text-muted"></small>
                            </p>
                        </div>

                        <div class="col-12">
                            <p><strong>📝 Motivo:</strong><br>
                                <span id="det-motivo"></span>
                            </p>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
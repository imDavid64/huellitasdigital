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
                <li class="breadcrumb-item current-page">Productos</li>
            </ol>
        </nav>
        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Agendar Cita</strong></h1>
                </div>
                <div class="schedule-appointment-container">
                    <div>
                        <form action="user-mgmt.html" method="POST">
                            <div class="form-container">
                                <div class="form-item">
                                    <label for="appointment">Motivo de la Cita</label>
                                    <select id="appointment" name="appointment" required>
                                        <option value="" disabled selected>Seleccione el motivo</option>
                                        <option>Consulta</option>
                                        <option>Vacunación</option>
                                        <option>Desparacitación</option>
                                    </select>
                                </div>
                                <div class="form-item">
                                    <label for="clientname">Nombre del Cliente</label>
                                    <input type="text" id="clientname" name="clientname" required>
                                </div>
                                <div class="form-item">
                                    <label for="petname">Nombre de la Mascota</label>
                                    <input type="text" id="petname" name="petname" required>
                                </div>
                                <div class="form-item">
                                    <label for="appointmentdate">Fecha</label>
                                    <input type="date" id="appointmentdate" name="appointmentdate" required>
                                </div>
                                <div class="form-item">
                                    <label for="appointmenttime">Hora</label>
                                    <input type="time" id="appointmenttime" name="appointmenttime" required>
                                </div>
                                <button type="submit" class="btn-blue"><strong>Agendar Cita</strong><i class="bi bi-calendar-plus"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="appointment-note">
                        <p><strong>💡 NOTA IMPORTANTE: </strong> Si el motivo de su cita corresponde a alguno de los
                            siguientes procedimientos o servicios especializados, le solicitamos que se comunique 
                            con nosotros para una mejor coordinación:
                        </p>

                        <ul>
                            <li>🧪 Exámenes de Laboratorio.</li>
                            <li>🩻 Ultrasonido.</li>
                            <li>🩺 Cirugía Menor.</li>
                            <li>🦷 Limpieza Dental.</li>
                        </ul>

                        <p>De esta manera podremos garantizarle una atención adecuada y ajustada a sus necesidades.
                            Por favor, contáctenos directamente al <strong>+506 7210-9730</strong>, donde nuestro personal
                            con gusto le brindará la asistencia necesaria.</p>

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
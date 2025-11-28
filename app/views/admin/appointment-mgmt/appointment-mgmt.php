<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>
<!--HEAD-->

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->


    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>
            <section class="admin-main-content">
                <div>
                    <!--Breadcrumb-->
                    <nav class="breadcrumbs-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">Inicio</a>
                            </li>
                            <li class="breadcrumb-item current-page">Gestión de Citas</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-calendar-week-fill"></i><strong> Gestión de Citas</strong></h2>
                        <div>
                            <a href="add-appointment.html" class="btn-blue"><strong>Agendar Cita</strong>
                                <i class="bi bi-calendar-plus-fill"></i></a>
                        </div>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">

                    <div class="calendar" id="calendar" class="mt-3"></div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var calendarEl = document.getElementById('calendar');
                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'dayGridMonth',
                                locale: 'es',
                                headerToolbar: {
                                    left: 'prev,next today',
                                    center: 'title',
                                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                                },
                                events: [
                                    {
                                        title: 'Consulta - Juan Pérez / Firulais',
                                        start: '2025-08-20T10:00:00',
                                        end: '2025-08-20T11:00:00',
                                        color: '#198754'
                                    },
                                    {
                                        title: 'Vacunación - María López / Pelusa',
                                        start: '2025-08-21T14:00:00',
                                        end: '2025-08-21T14:30:00',
                                        color: '#ffc107'
                                    }
                                ],
                                eventClick: function (info) {
                                    alert('Cita: ' + info.event.title + '\nHora: ' + info.event.start.toLocaleString());
                                }
                            });
                            calendar.render();
                        });
                    </script>
                </section>
            </section>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOOTER-->
<footer>
    <div class="post-footer" style="background-color: #002557; color: white;">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>
<!--FOOTER-->


</html>
<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>
<script>
    window.APPOINTMENT_CONTROLLER = "adminAppointment";
</script>

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
                            <a href="<?= BASE_URL ?>/index.php?controller=adminAppointment&action=create"
                                class="btn-green"><strong>Agendar Cita</strong>
                                <i class="bi bi-calendar-plus-fill"></i></a>
                        </div>
                    </div>
                    <section class="admin-main-content-mgmt">

                        <div id="calendar" class="calendar mt-3"></div>
                        <?php include __DIR__ . "/partials/cita-detalle.php"; ?>

                    </section>
            </section>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->

    <!--FOOTER-->
    <footer>
        <div class="post-footer" style="background-color: #002557; color: white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>
    <!--FOOTER-->
</body>

</html>
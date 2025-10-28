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
            <section class="admin-main-content-add-user">
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-calendar-plus-fill"></i><strong> Agendar Cita</strong></h2>
                        <div></div>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="user-mgmt.html" method="POST">
                        <div class="form-container">
                            <div class="form-item">
                                <label for="appointment">Motivo de la Cita</label>
                                <select id="appointment" name="appointment" required>
                                    <option value="" disabled selected>Seleccione el motivo</option>
                                    <option>Consulta</option>
                                    <option>Vacunación</option>
                                    <option>Desparacitación</option>
                                    <option>Examenes de Laboratorio</option>
                                    <option>Ultrasonido</option>
                                    <option>Cirugia Menor</option>
                                    <option>Limpieza Dental</option>
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
                            <button type="submit" class="btn-blue"><strong>Agendar Cita</strong><i class="bi bi-calendar-plus-fill"></i></button>
                        </div>
                    </form>
                </div>
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
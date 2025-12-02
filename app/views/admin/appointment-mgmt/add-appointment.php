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
                            <li class="breadcrumb-item">
                                <a href="<?= BASE_URL ?>/index.php?controller=adminAppointment&action=index">Gestión de Citas</a>
                            </li>
                            <li class="breadcrumb-item current-page">Agendar Cita</li>
                        </ol>
                    </nav>
                    <div class="tittles">
                        <h2><i class="bi bi-calendar-plus-fill"></i><strong> Agendar Cita</strong></h2>
                        <div></div>
                    </div>
                    <div class="admin-form-container">
                        <form id="formAgendarCita" class="p-3">

                            <!-- ======================================================= -->
                            <!-- BUSCADOR GENERAL -->
                            <!-- ======================================================= -->
                            <div class="mb-3 position-relative">
                                <label class="form-label fw-bold">Buscar Cliente / Usuario</label>
                                <input type="text" class="form-control" id="buscadorGeneral"
                                    placeholder="Nombre, correo, cédula, código...">

                                <div id="listaResultados" class="list-group position-absolute shadow-sm"
                                    style="z-index: 10; width: 100%; display:none;"></div>
                            </div>

                            <!-- ======================================================= -->
                            <!-- CLIENTE SELECCIONADO AUTOMÁTICAMENTE -->
                            <!-- ======================================================= -->
                            <input type="hidden" id="codigoClienteSeleccionado">
                            <input type="hidden" id="codigoUsuarioSeleccionado">

                            <div id="datosClienteSeleccionado" class="border rounded p-3 mb-3" style="display:none;">
                                <h5 class="fw-bold mb-3"><i class="bi bi-person-check-fill"></i> Cliente Seleccionado
                                </h5>

                                <div class="row">
                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="clienteNombreInput" disabled
                                            readonly>
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Correo</label>
                                        <input type="text" class="form-control" id="clienteCorreoInput" disabled
                                            readonly>
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Identificación</label>
                                        <input type="text" class="form-control" id="clienteIdentificacionInput" disabled
                                            readonly>
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="clienteTelefonoInput" disabled
                                            readonly>
                                    </div>

                                    <div class="form-item col-12 mb-2">
                                        <label class="form-label">Dirección</label>
                                        <textarea class="form-control" id="clienteDireccionInput" rows="2" disabled
                                            readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ======================================================= -->
                            <!-- MASCOTAS DEL CLIENTE -->
                            <!-- ======================================================= -->
                            <div id="contenedorMascotas" class="mb-3" style="display:none;">
                                <h5 class="fw-bold"><i class="bi bi-file-earmark-medical-fill"></i> Seleccione las
                                    mascotas
                                </h5>
                                <p>Puede seleccionar las mascotas que el cliente traerá a la cita.</p>
                                <div id="listaMascotas" class="mt-2"></div>
                                <hr />
                            </div>

                            <!-- ======================================================= -->
                            <!-- MODO MANUAL -->
                            <!-- ======================================================= -->
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="chkClienteManual">
                                <label class="form-check-label fw-bold">Ingresar cliente manualmente</label>
                            </div>

                            <div id="clienteManualContainer" class="border rounded p-3 mb-3" style="display:none;">
                                <h5 class="fw-bold mb-3"><i class="bi bi-person-fill-add"></i> Datos del Cliente</h5>

                                <div class="row">
                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Nombre*</label>
                                        <input type="text" id="clienteManualNombre" class="form-control">
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Correo</label>
                                        <input type="email" id="clienteManualCorreo" class="form-control">
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Teléfono*</label>
                                        <input type="text" id="clienteManualTelefono" class="form-control">
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Identificación</label>
                                        <input type="text" id="clienteManualIdentificacion" class="form-control">
                                    </div>

                                    <div class="form-item col-md-12 mb-2">
                                        <label class="form-label">Nombre de la mascota*</label>
                                        <input type="text" id="clienteManualMascota" class="form-control"
                                            placeholder="Nombre de la mascota">
                                    </div>
                                </div>
                            </div>

                            <!-- ======================================================= -->
                            <!-- SERVICIO, VETERINARIO, FECHAS -->
                            <!-- ======================================================= -->
                            <div class="border rounded p-3 mb-3">
                                <h5 class="fw-bold mb-3"><i class="bi bi-clipboard2-fill"></i> Detalles de la Cita</h5>

                                <div class="row">
                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Servicio</label>
                                        <select id="idServicio" class="form-select" required>
                                            <option value="">Seleccione</option>
                                            <?php foreach ($servicios as $srv): ?>
                                                <option value="<?= $srv['ID_SERVICIO_PK'] ?>">
                                                    <?= $srv['NOMBRE_SERVICIO'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Veterinario</label>
                                        <select id="idVeterinario" class="form-select" required>
                                            <option value="">Seleccione</option>
                                            <?php foreach ($empleados as $vet): ?>
                                                <option value="<?= $vet['ID_USUARIO_PK'] ?>">
                                                    <?= $vet['USUARIO_NOMBRE'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Fecha Inicio</label>
                                        <input type="datetime-local" id="fechaInicio" class="form-control">
                                    </div>

                                    <div class="form-item col-md-6 mb-2">
                                        <label class="form-label">Fecha Fin</label>
                                        <input type="datetime-local" id="fechaFin" class="form-control">
                                    </div>

                                    <div class="form-item col-12 mb-2">
                                        <label class="form-label">Motivo de la cita</label>
                                        <textarea id="motivo" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="btnEnviarCita" class="btn-dark-blue">
                                Agendar Cita <i class="bi bi-check-circle-fill"></i>
                            </button>

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
<?php
include_once __DIR__ . '/../includes/auth.php';
checkRole(['EMPLEADO', 'ADMINISTRADOR']);
?>

<?php
function fieldOrNoData($value)
{
    if (!isset($value) || $value === null || $value === "") {
        return '<span class="no-data">No registrado</span>';
    }
    return htmlspecialchars($value);
}
?>


<!DOCTYPE html>
<html lang="es">

<!-- HEAD -->
<?php include_once __DIR__ . "/../partials/employeeHead.php"; ?>

<body>

    <!-- HEADER -->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>

    <main>
        <section class="admin-main">
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>

            <section class="vet-main-content">

                <!-- Breadcrumb -->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a
                                href="<?= BASE_URL ?>/index.php?controller=employeePet&action=details&codigo=<?= $mascota['CODIGO_MASCOTA'] ?>">
                                Detalles de la Mascota
                            </a>
                        </li>
                        <li class="breadcrumb-item current-page">Agregar Historial Médico</li>
                    </ol>
                </nav>

                <div class="tittles align-items-center">
                    <h2><i class="bi bi-journal-medical"></i>
                        <strong> Historial de <?= htmlspecialchars($mascota['NOMBRE_MASCOTA']) ?></strong>
                    </h2>
                    <h5>
                        <strong>Fecha: <?= htmlspecialchars($historial['HISTORIAL_FECHA']) ?></strong>
                    </h5>
                    <div>
                        <a href="<?= BASE_URL ?>/index.php?controller=employeeMedicalHistory&action=edit&codigo=<?= urlencode($historial['CODIGO_HISTORIAL']) ?>&codigo_mascota=<?= urlencode($mascota['CODIGO_MASCOTA']) ?>"
                            class="btn-blue"><strong>Editar Historial Médico</strong>
                            <i class="bi bi-pencil"></i></a>
                    </div>
                </div>

                <div class="medical-history-details">

                    <!-- ============= SECCIÓN: INFORMACIÓN GENERAL ============= -->
                    <div class="hist-section">
                        <h4><i class="bi bi-info-circle-fill"></i> Información General</h4>
                        <hr>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="fw-bold">Historia Clínica:</label>
                                <p><?= nl2br(fieldOrNoData($historial['HISTORIA_CLINICA'])) ?></p>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="fw-bold">Anamnesis:</label>
                                <p><?= nl2br(fieldOrNoData($historial['ANAMNESIS'])) ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Peso:</label>
                                <p>
                                    <?= fieldOrNoData($historial['PESO']) ?>
                                    <?= isset($historial['PESO']) && $historial['PESO'] !== null && $historial['PESO'] !== '' ? 'kg' : '' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- ============= SECCIÓN: EXPLORACIÓN FÍSICA ============= -->
                    <div class="hist-section mt-4">
                        <h4><i class="bi bi-heart-pulse-fill"></i> Exploración Física</h4>
                        <hr>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Temperatura:</label>
                                <p>
                                    <?= fieldOrNoData($historial['TEMPERATURA']) ?>
                                    <?= isset($historial['TEMPERATURA']) && $historial['TEMPERATURA'] !== '' ? '°C' : '' ?>
                                </p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Frecuencia Cardíaca:</label>
                                <p>
                                    <?= fieldOrNoData($historial['FRECUENCIA_CARDIACA']) ?>
                                    <?= isset($historial['FRECUENCIA_CARDIACA']) && $historial['FRECUENCIA_CARDIACA'] !== '' ? 'bpm' : '' ?>
                                </p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Frecuencia Respiratoria:</label>
                                <p>
                                    <?= fieldOrNoData($historial['FRECUENCIA_RESPIRATORIA']) ?>
                                    <?= isset($historial['FRECUENCIA_RESPIRATORIA']) && $historial['FRECUENCIA_RESPIRATORIA'] !== '' ? 'rpm' : '' ?>
                                </p>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Sonidos Pulmonares:</label>
                                <p><?= fieldOrNoData($historial['SONIDOS_PULMONARES']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Condición Corporal:</label>
                                <p><?= fieldOrNoData($historial['CONDICION_CORPORAL']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Reflejo Deglutorio:</label>
                                <p><?= fieldOrNoData($historial['REFLEJO_DEGLUTORIO']) ?></p>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Reflejo Tusígeno:</label>
                                <p><?= fieldOrNoData($historial['REFLEJO_TUSIGENO']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Linfonodos:</label>
                                <p><?= fieldOrNoData($historial['LINFONODOS']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Palpación Abdominal:</label>
                                <p><?= fieldOrNoData($historial['PALPACION_ABDOMINAL']) ?></p>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Piel:</label>
                                <p><?= fieldOrNoData($historial['PIEL']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Mucosa:</label>
                                <p><?= fieldOrNoData($historial['MUCOSA']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Pulso:</label>
                                <p><?= fieldOrNoData($historial['PULSO']) ?></p>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Estado Mental:</label>
                                <p><?= fieldOrNoData($historial['ESTADO_MENTAL']) ?></p>
                            </div>

                        </div>
                    </div>

                    <!-- ============= SECCIÓN: DIAGNÓSTICO ============= -->
                    <div class="hist-section mt-4">
                        <h4><i class="bi bi-clipboard2-pulse-fill"></i> Diagnóstico</h4>
                        <hr>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Diagnóstico Presuntivo:</label>
                                <p><?= nl2br(fieldOrNoData($historial['LISTA_DIAGNOSTICO_PRESUNTIVO'])) ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Lista Depurada:</label>
                                <p><?= nl2br(fieldOrNoData($historial['LISTA_DEPURADA'])) ?></p>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Exámenes:</label>
                                <p><?= nl2br(fieldOrNoData($historial['EXAMENES'])) ?></p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Diagnóstico Final:</label>
                                <p><?= nl2br(fieldOrNoData($historial['DIAGNOSTICO_FINAL'])) ?></p>
                            </div>

                        </div>
                    </div>

                    <!-- ============= SECCIÓN: ESTADO DEL HISTORIAL ============= -->
                    <div class="hist-section mt-4">
                        <h4><i class="bi bi-flag-fill"></i> Información del Registro</h4>
                        <hr>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Estado:</label>
                                <p><?= fieldOrNoData($historial['ESTADO']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Código del Historial:</label>
                                <p><?= fieldOrNoData($historial['CODIGO_HISTORIAL']) ?></p>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Fecha de Registro:</label>
                                <p><?= fieldOrNoData($historial['HISTORIAL_FECHA_REGISTRO']) ?></p>
                            </div>

                        </div>
                    </div>
                </div>


            </section>
        </section>
    </main>

    <footer>
        <div class="post-footer" style="background-color:#002557;color:white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>

</body>

</html>
<?php
include_once __DIR__ . '/../includes/auth.php';
checkRole(['EMPLEADO', 'ADMINISTRADOR']);
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
                        <li class="breadcrumb-item current-page">Editar Historial Médico</li>
                    </ol>
                </nav>

                <div class="tittles">
                    <h2><i class="bi bi-journal-medical"></i>
                        <strong> Editar Historial Médico</strong>
                    </h2>
                </div>

                <div class="employee-form-container">

                    <!-- FORMULARIO -->
                    <form action="<?= BASE_URL ?>/index.php?controller=employeeMedicalHistory&action=update"
                        id="editMedicalHistoryForm" method="POST">

                        <!-- Datos ocultos -->
                        <input type="hidden" name="codigo_historial" value="<?= $historial['CODIGO_HISTORIAL'] ?>">
                        <input type="hidden" name="codigo_mascota" value="<?= $mascota['CODIGO_MASCOTA'] ?>">


                        <!-- ========== INFORMACIÓN GENERAL ========== -->
                        <div class="form-container-medicalHistory">
                            <h4>Información General</h4>
                            <hr />

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Historia Clínica</label>
                                    <textarea name="historia_clinica" class="form-control" rows="4"
                                        required><?= htmlspecialchars($historial['HISTORIA_CLINICA']) ?></textarea>
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Anamnesis</label>
                                    <textarea name="anamnesis" class="form-control"
                                        rows="3"><?= htmlspecialchars($historial['ANAMNESIS']) ?></textarea>
                                </div>
                            </div>

                            <div class="form-item" style="width: 500px;">
                                <label class="form-label">Peso (kg)</label>
                                <input type="number" step="0.01" name="peso" class="form-control"
                                    value="<?= $historial['PESO'] ?>">
                            </div>
                        </div>

                        <!-- ========== EXPLORACIÓN FÍSICA ========== -->
                        <div class="form-container-medicalHistory">
                            <h4>Exploración Física</h4>
                            <hr />

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Temperatura (°C)</label>
                                    <input type="number" step="0.1" name="temperatura" class="form-control"
                                        value="<?= $historial['TEMPERATURA'] ?>">
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Frecuencia Cardíaca (bpm)</label>
                                    <input type="number" name="frecuencia_cardiaca" class="form-control"
                                        value="<?= $historial['FRECUENCIA_CARDIACA'] ?>">
                                </div>
                            </div>

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Frecuencia Respiratoria (rpm)</label>
                                    <input type="number" name="frecuencia_respiratoria" class="form-control"
                                        value="<?= $historial['FRECUENCIA_RESPIRATORIA'] ?>">
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Sonidos Pulmonares</label>
                                    <input type="text" name="sonidos_pulmonares" class="form-control"
                                        value="<?= htmlspecialchars($historial['SONIDOS_PULMONARES']) ?>">
                                </div>
                            </div>

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Condición Corporal</label>
                                    <input type="text" name="condicion_corporal" class="form-control"
                                        value="<?= htmlspecialchars($historial['CONDICION_CORPORAL']) ?>">
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Reflejo Deglutorio</label>
                                    <input type="text" name="reflejo_deglutorio" class="form-control"
                                        value="<?= htmlspecialchars($historial['REFLEJO_DEGLUTORIO']) ?>">
                                </div>
                            </div>

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Reflejo Tusígeno</label>
                                    <input type="text" name="reflejo_tusigeno" class="form-control"
                                        value="<?= htmlspecialchars($historial['REFLEJO_TUSIGENO']) ?>">
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Linfonodos</label>
                                    <input type="text" name="linfonodos" class="form-control"
                                        value="<?= htmlspecialchars($historial['LINFONODOS']) ?>">
                                </div>
                            </div>

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Palpación Abdominal</label>
                                    <input type="text" name="palpacion_abdominal" class="form-control"
                                        value="<?= htmlspecialchars($historial['PALPACION_ABDOMINAL']) ?>">
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Piel</label>
                                    <input type="text" name="piel" class="form-control"
                                        value="<?= htmlspecialchars($historial['PIEL']) ?>">
                                </div>
                            </div>

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Mucosa</label>
                                    <input type="text" name="mucosa" class="form-control"
                                        value="<?= htmlspecialchars($historial['MUCOSA']) ?>">
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Pulso</label>
                                    <input type="text" name="pulso" class="form-control"
                                        value="<?= htmlspecialchars($historial['PULSO']) ?>">
                                </div>
                            </div>

                            <div class="form-item" style="width: 500px;">
                                <label class="form-label">Estado Mental</label>
                                <input type="text" name="estado_mental" class="form-control"
                                    value="<?= htmlspecialchars($historial['ESTADO_MENTAL']) ?>">
                            </div>
                        </div>

                        <!-- ========== DIAGNÓSTICOS ========== -->
                        <div class="form-container-medicalHistory">
                            <h4>Diagnosis</h4>
                            <hr />

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Diagnóstico Presuntivo</label>
                                    <textarea name="diagnostico_presuntivo" class="form-control"
                                        rows="3"><?= htmlspecialchars($historial['LISTA_DIAGNOSTICO_PRESUNTIVO']) ?></textarea>
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Lista Depurada</label>
                                    <textarea name="lista_depurada" class="form-control"
                                        rows="3"><?= htmlspecialchars($historial['LISTA_DEPURADA']) ?></textarea>
                                </div>
                            </div>

                            <div class="container-medicalHistory">
                                <div class="form-item">
                                    <label class="form-label">Exámenes</label>
                                    <textarea name="examenes" class="form-control"
                                        rows="3"><?= htmlspecialchars($historial['EXAMENES']) ?></textarea>
                                </div>

                                <div class="form-item">
                                    <label class="form-label">Diagnóstico Final</label>
                                    <textarea name="diagnostico_final" class="form-control"
                                        rows="3"><?= htmlspecialchars($historial['DIAGNOSTICO_FINAL']) ?></textarea>
                                </div>
                            </div>

                            <div class="form-item" style="width: 500px;">
                                <label class="form-label">Estado del Historial</label>
                                <select name="id_estado" class="form-select" required>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= $estado['ID_ESTADO_PK'] == $historial['ID_ESTADO_FK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- BOTÓN GUARDAR -->
                        <button type="submit" class="btn-blue mt-3">
                            <strong>Actualizar Historial Médico</strong>
                            <i class="bi bi-check-circle-fill"></i>
                        </button>

                    </form>

                </div>

            </section>
        </section>
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'edit_ok'): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Historial Actualizado',
                    text: 'Los cambios fueron guardados correctamente.',
                    confirmButtonColor: '#004AAD'
                });
            </script>
        <?php endif; ?>

    </main>

    <footer>
        <div class="post-footer" style="background-color:#002557;color:white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>

</body>

</html>
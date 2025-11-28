<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/includes/auth.php';
checkRole(['EMPLEADO', 'ADMINISTRADOR']);
?>

<?php
// =============== AGRUPAR CITAS POR ID_CITA_PK ===============
$agrupado = [];

foreach ($citas as $c) {
    $id = $c["ID_CITA_PK"];

    if (!isset($agrupado[$id])) {
        $agrupado[$id] = [
            "info" => $c,
            "mascotas" => []
        ];
    }

    // Mascota registrada
    if (!empty($c["NOMBRE_MASCOTA"])) {
        $agrupado[$id]["mascotas"][] = $c["NOMBRE_MASCOTA"];
    }

    // Mascota manual
    if (!empty($c["MASCOTA_NOMBRE_MANUAL"])) {
        $agrupado[$id]["mascotas"][] = $c["MASCOTA_NOMBRE_MANUAL"];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<!--HEAD-->
<?php include_once __DIR__ . "/partials/employeeHead.php"; ?>
<!--HEAD-->

<body>

    <!--HEADER-->
    <?php include_once __DIR__ . "/partials/header.php"; ?>
    <!--HEADER-->

    <main>
        <section class="admin-main">
            <?php include_once __DIR__ . "/partials/asideMenu.php"; ?>
            <section class="vet-main-content">

                <div class="tittles">
                    <h2><strong>Bienvenido <?= htmlspecialchars($_SESSION['user_name']) ?></strong></h2>
                </div>

                <?php include __DIR__ . "/appointment-mgmt/partials/cita-detalle.php"; ?>
                <div class="vet-content-home">

                    <div class="dashboard-kpis">
                        <div class="subtitles align-items-center">
                            <h3><i class="bi bi-speedometer2"></i> Dashboard</h3>
                        </div>
                        <hr />
                        <div class="dashboard-kpis-list">
                            <div class="kpi-card kpi-blue">
                                <i class="bi bi-calendar-event"></i>
                                <h3 id="kpiCitasHoy">0</h3>
                                <p>Citas Hoy</p>
                            </div>

                            <div class="kpi-card kpi-yellow">
                                <i class="bi bi-sunrise"></i>
                                <h3 id="kpiCitasMannana">0</h3>
                                <p>Citas Mañana</p>
                            </div>

                            <div class="kpi-card kpi-green">
                                <i class="bi bi-calendar2-day"></i>
                                <h3 id="kpiMascotas">0</h3>
                                <p>Citas de Pasado Mañana</p>
                            </div>

                            <div class="kpi-card kpi-purple">
                                <i class="bi bi-journal-medical"></i>
                                <h3 id="kpiConsultasMes">0</h3>
                                <p>Consultas del Mes</p>
                            </div>

                            <div class="kpi-card kpi-cyan">
                                <i class="bi bi-person-plus"></i>
                                <h3 id="kpiClientes">0</h3>
                                <p>Nuevos Clientes</p>
                            </div>

                            <div class="kpi-card kpi-orange">
                                <i class="bi bi-bell-fill"></i>
                                <h3 id="kpiNotificaciones">0</h3>
                                <p>Notificaciones</p>
                            </div>
                        </div>

                    </div>

                    <div class="vet-calendar-container">

                        <div class="subtitles mb-3 d-flex justify-content-between align-items-center">
                            <h3><i class="bi bi-calendar2-week"></i> Próximas Citas</h3>
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeAppointment&action=index"
                                class="btn-blue">
                                Gestionar Citas
                                <i class="bi bi-calendar-plus-fill"></i>
                            </a>
                        </div>
                        <hr />

                        <div class="vet-home-citas-list">

                            <?php if (empty($agrupado)): ?>
                                <div class="alert alert-info text-center">
                                    <i class="bi bi-calendar-x"></i> No hay citas próximas.
                                </div>
                            <?php else: ?>
                                <?php foreach ($agrupado as $citaData):
                                    $cita = $citaData["info"];
                                    $mascotas = !empty($citaData["mascotas"])
                                        ? implode(", ", $citaData["mascotas"])
                                        : "Ninguna";

                                    // Determinar nombre del cliente
                                    $nombreCliente =
                                        $cita["CLIENTE_NOMBRE"] ??
                                        $cita["USUARIO_NOMBRE"] ??
                                        $cita["CLIENTE_MANUAL_NOMBRE"] ??
                                        "Cliente sin nombre";

                                    // ===== Lógica para colores e iconos =====
                                    date_default_timezone_set('America/Costa_Rica');

                                    // Fecha de inicio de la cita (solo Y-m-d)
                                    $fechaCita = (new DateTime($cita['FECHA_INICIO']))->format('Y-m-d');
                                    // Fecha de hoy (solo Y-m-d)
                                    $fechaHoy = (new DateTime('today'))->format('Y-m-d');

                                    // Diferencia en días usando timestamps
                                    $diffDias = (int) floor(
                                        (strtotime($fechaCita) - strtotime($fechaHoy)) / 86400
                                    );

                                    if ($diffDias < 0) {
                                        $icon = "⚪";  // Pasada
                                    } elseif ($diffDias === 0) {
                                        $icon = "🔴";  // Hoy
                                    } elseif ($diffDias === 1) {
                                        $icon = "🟡";  // Mañana
                                    } elseif ($diffDias <= 10) {
                                        $icon = "🔵";  // Próximos 10 días
                                    } else {
                                        $icon = "🟢";  // Lejanas
                                    }
                                    ?>

                                    <div class="cita-card mb-3">
                                        <div class="d-flex justify-content-between">

                                            <div>
                                                <div class="cita-header">
                                                    <span><?= $icon ?></span>
                                                    <span><?= htmlspecialchars($cita['NOMBRE_SERVICIO']) ?></span>
                                                </div>

                                                <div class="cita-body">
                                                    <p><strong>Cliente:</strong> <?= htmlspecialchars($nombreCliente) ?></p>
                                                    <p><strong>Mascotas:</strong> <?= htmlspecialchars($mascotas) ?></p>
                                                    <p><strong>Motivo:</strong>
                                                        <?= htmlspecialchars($cita["MOTIVO"] ?? "No especificado") ?></p>
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <div class="cita-fechas">
                                                    <div><?= date("d/m/Y H:i", strtotime($cita['FECHA_INICIO'])) ?></div>
                                                    <small>Fin: <?= date("d/m/Y H:i", strtotime($cita['FECHA_FIN'])) ?></small>
                                                </div>

                                                <div class="mt-2 vet-badge">
                                                    <?= htmlspecialchars($cita["VETERINARIO_NOMBRE"]) ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </section>
        </section>
    </main>

    <footer>
        <div class="post-footer" style="background-color: #002557; color: white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>

</body>

</html>
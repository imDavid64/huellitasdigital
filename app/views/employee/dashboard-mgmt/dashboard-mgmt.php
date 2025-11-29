<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['EMPLEADO', 'ADMINISTRADOR']);
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/employeeHead.php"; ?>
<!--HEAD-->

<body>

    <!--Include para el header-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>
            <section class="vet-main-content">
                <!--Breadcrumb-->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item current-page">Dashboard Empleado</li>
                    </ol>
                </nav>
                
                <div class="tittles">
                    <h2><i class="fas fa-tachometer-alt me-2"></i><strong> Dashboard Empleado</strong></h2>
                    <div>
                        <span class="text-muted badge bg-light text-dark fs-6"><?php echo date('d/m/Y'); ?></span>
                    </div>
                </div>

                <section class="admin-main-content-mgmt">
                    <!-- Estadísticas Rápidas - Diseño Mejorado -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title text-muted mb-2">Citas Pendientes</h5>
                                            <h2 class="fw-bold text-primary mb-0" id="citas-pendientes">
                                                <?php echo $data['citas_pendientes']; ?>
                                            </h2>
                                            <small class="text-success">
                                                <i class="fas fa-calendar-check me-1"></i>Hoy
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="icon-circle bg-primary text-white">
                                                <i class="fas fa-calendar-day fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title text-muted mb-2">Total Citas</h5>
                                            <h2 class="fw-bold text-success mb-0" id="total-citas-hoy">
                                                <?php echo count($data['citas_hoy']); ?>
                                            </h2>
                                            <small class="text-success">
                                                <i class="fas fa-clock me-1"></i>Programadas hoy
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="icon-circle bg-success text-white">
                                                <i class="fas fa-stethoscope fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title text-muted mb-2">Pedidos Pendientes</h5>
                                            <h2 class="fw-bold text-info mb-0" id="total-pedidos">
                                                <?php echo count($data['pedidos_pendientes']); ?>
                                            </h2>
                                            <small class="text-info">
                                                <i class="fas fa-sync-alt me-1"></i>Por procesar
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="icon-circle bg-info text-white">
                                                <i class="fas fa-shopping-cart fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title text-muted mb-2">Cirugías Hoy</h5>
                                            <h2 class="fw-bold text-warning mb-0" id="total-cirugias">
                                                <?php echo count($data['cirugias_hoy']); ?>
                                            </h2>
                                            <small class="text-warning">
                                                <i class="fas fa-procedures me-1"></i>Programadas
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="icon-circle bg-warning text-white">
                                                <i class="fas fa-procedures fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Primera Fila: Citas Hoy y Servicios del Mes -->
                    <div class="row mb-4">
                        <!-- Citas de Hoy -->
                        <div class="col-lg-8 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="card-title mb-0 text-primary">
                                        <i class="fas fa-calendar-day me-2"></i>Citas Programadas para Hoy
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">Hora</th>
                                                    <th>Servicio</th>
                                                    <th>Mascota</th>
                                                    <th>Cliente</th>
                                                    <th class="text-center">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['citas_hoy'] as $cita): ?>
                                                <tr class="cursor-pointer hover-shadow">
                                                    <td class="ps-4 fw-bold text-primary">
                                                        <?php echo date('H:i', strtotime($cita['FECHA_INICIO'])); ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            <?php echo htmlspecialchars($cita['NOMBRE_SERVICIO']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-paw text-muted me-2"></i>
                                                            <span><?php echo htmlspecialchars($cita['mascota_nombre']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-user text-muted me-2"></i>
                                                            <span><?php echo htmlspecialchars($cita['CLIENTE_NOMBRE']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success rounded-pill">
                                                            <i class="fas fa-clock me-1"></i>Programada
                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php if (empty($data['citas_hoy'])): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-calendar-times fa-2x mb-3"></i>
                                                            <p class="mb-0">No hay citas programadas para hoy</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Servicios del Mes -->
                        <div class="col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="card-title mb-0 text-success">
                                        <i class="fas fa-chart-pie me-2"></i>Servicios del Mes
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($data['servicios_mes'])): ?>
                                        <?php foreach ($data['servicios_mes'] as $servicio): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-bg">
                                            <div class="d-flex align-items-center">
                                                <div class="service-icon bg-light-success rounded-circle p-2 me-3">
                                                    <i class="fas fa-stethoscope text-success"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($servicio['NOMBRE_SERVICIO']); ?></h6>
                                                    <small class="text-muted">Servicios realizados</small>
                                                </div>
                                            </div>
                                            <span class="badge bg-success fs-6"><?php echo $servicio['total_servicios']; ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-chart-bar fa-2x text-muted mb-3"></i>
                                            <p class="text-muted mb-0">No hay servicios este mes</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda Fila: Pedidos Pendientes y Movimientos de Inventario -->
                    <div class="row mb-4">
                        <!-- Pedidos Pendientes -->
                        <div class="col-lg-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="card-title mb-0 text-info">
                                        <i class="fas fa-shopping-bag me-2"></i>Pedidos Pendientes
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">Código</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha</th>
                                                    <th class="text-end">Total</th>
                                                    <th class="text-center">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['pedidos_pendientes'] as $pedido): ?>
                                                <tr class="cursor-pointer hover-shadow">
                                                    <td class="ps-4 fw-bold text-info">
                                                        #<?php echo htmlspecialchars($pedido['CODIGO_PEDIDO']); ?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-user-circle text-muted me-2"></i>
                                                            <span><?php echo htmlspecialchars($pedido['USUARIO_NOMBRE']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="text-muted">
                                                        <?php echo date('d/m/Y', strtotime($pedido['FECHA_PEDIDO'])); ?>
                                                    </td>
                                                    <td class="text-end fw-bold text-success">
                                                        ₡<?php echo number_format($pedido['TOTAL'], 2); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-warning rounded-pill">
                                                            <i class="fas fa-clock me-1"></i><?php echo htmlspecialchars($pedido['ESTADO_DESCRIPCION']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php if (empty($data['pedidos_pendientes'])): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-shopping-cart fa-2x mb-3"></i>
                                                            <p class="mb-0">No hay pedidos pendientes</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Movimientos de Inventario -->
                        <div class="col-lg-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="card-title mb-0 text-secondary">
                                        <i class="fas fa-warehouse me-2"></i>Movimientos de Inventario
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">Producto</th>
                                                    <th class="text-center">Tipo</th>
                                                    <th class="text-center">Cantidad</th>
                                                    <th class="text-center">Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['movimientos_inventario'] as $movimiento): ?>
                                                <tr class="cursor-pointer hover-shadow">
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-box text-muted me-2"></i>
                                                            <span><?php echo htmlspecialchars($movimiento['PRODUCTO_NOMBRE']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge <?php echo $movimiento['TIPO_MOVIMIENTO'] == 'ENTRADA' ? 'bg-success' : 'bg-danger'; ?> rounded-pill">
                                                            <i class="fas <?php echo $movimiento['TIPO_MOVIMIENTO'] == 'ENTRADA' ? 'fa-arrow-down' : 'fa-arrow-up'; ?> me-1"></i>
                                                            <?php echo $movimiento['TIPO_MOVIMIENTO']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-center fw-bold">
                                                        <?php echo $movimiento['CANTIDAD']; ?>
                                                    </td>
                                                    <td class="text-center text-muted">
                                                        <small><?php echo date('d/m H:i', strtotime($movimiento['FECHA_MOVIMIENTO'])); ?></small>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php if (empty($data['movimientos_inventario'])): ?>
                                                <tr>
                                                    <td colspan="4" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-boxes fa-2x mb-3"></i>
                                                            <p class="mb-0">No hay movimientos recientes</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comparación de Citas -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="card-title mb-0 text-dark">
                                        <i class="fas fa-chart-line me-2"></i>Comparación de Citas Mensuales
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <?php foreach ($data['citas_comparacion'] as $comparacion): ?>
                                        <div class="col-md-6">
                                            <div class="comparison-card p-4 rounded-3 <?php echo $comparacion['periodo'] == 'Mes Actual' ? 'bg-primary text-white' : 'bg-light'; ?>">
                                                <h3 class="fw-bold mb-2"><?php echo $comparacion['total_citas']; ?></h3>
                                                <p class="mb-0 <?php echo $comparacion['periodo'] == 'Mes Actual' ? 'text-white-50' : 'text-muted'; ?>">
                                                    <?php echo htmlspecialchars($comparacion['periodo']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

    <style>
        .dashboard-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-left: 4px solid transparent;
        }
        
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }
        
        .dashboard-card:nth-child(1) { border-left-color: #007bff; }
        .dashboard-card:nth-child(2) { border-left-color: #28a745; }
        .dashboard-card:nth-child(3) { border-left-color: #17a2b8; }
        .dashboard-card:nth-child(4) { border-left-color: #ffc107; }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .service-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hover-bg:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }
        
        .hover-shadow:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: box-shadow 0.2s ease;
        }
        
        .cursor-pointer {
            cursor: pointer;
        }
        
        .bg-light-success {
            background-color: #d1f7e4 !important;
        }
        
        .comparison-card {
            transition: transform 0.2s ease;
        }
        
        .comparison-card:hover {
            transform: scale(1.02);
        }
        
        .table > :not(caption) > * > * {
            padding: 1rem 0.75rem;
        }
        
        .card-header {
            border-bottom: 1px solid #e9ecef;
        }
    </style>

    <script>
        // Función para actualizar estadísticas en tiempo real
        function actualizarEstadisticas() {
            fetch('<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=apiEstadisticas')
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        document.getElementById('citas-pendientes').textContent = data.citas_pendientes;
                        document.getElementById('total-citas-hoy').textContent = data.total_citas_hoy;
                        document.getElementById('total-pedidos').textContent = data.total_pedidos_pendientes;
                        document.getElementById('total-cirugias').textContent = data.total_cirugias_hoy;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Actualizar cada 2 minutos
        setInterval(actualizarEstadisticas, 120000);

        // Efectos hover para las tarjetas
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card, .comparison-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = this.classList.contains('dashboard-card') ? 'translateY(-2px)' : 'scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'none';
                });
            });
        });
    </script>
</body>
</html>
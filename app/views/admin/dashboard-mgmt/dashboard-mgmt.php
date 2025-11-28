<?php
// Usa el mismo include que funciona en tus otras vistas
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

    <!--Include para el header-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>
            
            <section class="admin-main-content">
                <!--Breadcrumb-->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item current-page">Dashboard</li>
                    </ol>
                </nav>
                
                <div class="tittles">
                    <h2><i class="bi bi-speedometer2"></i><strong> Dashboard</strong></h2>
                    <p class="text-muted">Resumen general del sistema - <?php echo date('d/m/Y'); ?></p>
                </div>

                <section class="admin-main-content-mgmt">
                    <!-- ================================
                         TARJETAS DE MÉTRICAS PRINCIPALES
                    ================================= -->
                    <div class="row g-4 mb-4">
                        <!-- Citas Hoy -->
                        <div class="col-xl-2 col-lg-4 col-md-6">
                            <div class="card stat-card h-100">
                                <div class="card-body text-center">
                                    <div class="stat-icon text-primary">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <h3 class="stat-number"><?= $datos['citas_hoy'] ?></h3>
                                    <p class="stat-label">Citas para hoy</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pedidos Pendientes -->
                        <div class="col-xl-2 col-lg-4 col-md-6">
                            <div class="card stat-card h-100">
                                <div class="card-body text-center">
                                    <div class="stat-icon text-warning">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <h3 class="stat-number"><?= $datos['pedidos_pendientes'] ?></h3>
                                    <p class="stat-label">Pedidos pendientes</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Clientes -->
                        <div class="col-xl-2 col-lg-4 col-md-6">
                            <div class="card stat-card h-100">
                                <div class="card-body text-center">
                                    <div class="stat-icon text-success">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <h3 class="stat-number"><?= $datos['total_clientes'] ?></h3>
                                    <p class="stat-label">Clientes registrados</p>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Bajo -->
                        <div class="col-xl-2 col-lg-4 col-md-6">
                            <div class="card stat-card h-100">
                                <div class="card-body text-center">
                                    <div class="stat-icon text-danger">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </div>
                                    <h3 class="stat-number"><?= $datos['stock_bajo'] ?></h3>
                                    <p class="stat-label">Productos stock bajo</p>
                                </div>
                            </div>
                        </div>

                        <!-- Clientes Activos -->
                        <div class="col-xl-2 col-lg-4 col-md-6">
                            <div class="card stat-card h-100">
                                <div class="card-body text-center">
                                    <div class="stat-icon text-info">
                                        <i class="bi bi-person-check"></i>
                                    </div>
                                    <h3 class="stat-number"><?= $datos['clientes_activos'] ?></h3>
                                    <p class="stat-label">Clientes activos</p>
                                </div>
                            </div>
                        </div>

                        <!-- Proveedores Activos -->
                        <div class="col-xl-2 col-lg-4 col-md-6">
                            <div class="card stat-card h-100">
                                <div class="card-body text-center">
                                    <div class="stat-icon text-secondary">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <h3 class="stat-number"><?= $datos['proveedores_activos'] ?></h3>
                                    <p class="stat-label">Proveedores activos</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================================
                         GRÁFICO Y TABLAS
                    ================================= -->
                    <div class="row g-4">
                        <!-- Gráfico Estadísticas Mensuales -->
                        <div class="col-lg-8">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-bar-chart"></i> Estadísticas Mensuales
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="monthlyChart" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Últimos Pedidos -->
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-clock-history"></i> Últimos Pedidos
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($datos['ultimos_pedidos'])): ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach ($datos['ultimos_pedidos'] as $pedido): ?>
                                                <div class="list-group-item px-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1"><?= htmlspecialchars($pedido['CODIGO_PEDIDO']) ?></h6>
                                                            <small class="text-muted"><?= htmlspecialchars($pedido['CLIENTE']) ?></small>
                                                        </div>
                                                        <span class="badge bg-<?= 
                                                            strtoupper($pedido['ESTADO_PEDIDO']) === 'ENTREGADO' ? 'success' : 
                                                            (strtoupper($pedido['ESTADO_PEDIDO']) === 'PENDIENTE' ? 'warning' : 'primary')
                                                        ?>">
                                                            <?= htmlspecialchars($pedido['ESTADO_PEDIDO']) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted text-center">No hay pedidos recientes</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Productos Más Vendidos -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-trophy"></i> Productos Más Vendidos
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($datos['productos_mas_vendidos'])): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Categoría</th>
                                                        <th class="text-center">Ventas</th>
                                                        <th class="text-center">Stock</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($datos['productos_mas_vendidos'] as $producto): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="<?= htmlspecialchars($producto['IMAGEN_URL']) ?>" 
                                                                         class="rounded me-3" 
                                                                         width="40" 
                                                                         height="40" 
                                                                         alt="<?= htmlspecialchars($producto['PRODUCTO_NOMBRE']) ?>">
                                                                    <div>
                                                                        <h6 class="mb-0"><?= htmlspecialchars($producto['PRODUCTO_NOMBRE']) ?></h6>
                                                                        <small class="text-muted">₡<?= number_format($producto['PRECIO'], 2) ?></small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><?= htmlspecialchars($producto['CATEGORIA']) ?></td>
                                                            <td class="text-center">
                                                                <span class="badge bg-primary"><?= $producto['TOTAL_VENDIDO'] ?></span>
                                                            </td>
                                                            <td class="text-center"><?= $producto['STOCK'] ?></td>
                                                            <td>
                                                                <span class="badge bg-<?= $producto['ESTADO'] === 'ACTIVO' ? 'success' : 'secondary' ?>">
                                                                    <?= htmlspecialchars($producto['ESTADO']) ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted text-center">No hay datos de productos vendidos</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
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

<!-- Scripts para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos para el gráfico
    const monthlyData = <?php echo json_encode($datos['estadisticas_mensuales']); ?>;
    
    const labels = monthlyData.map(item => item.mes);
    const data = monthlyData.map(item => item.total);

    // Crear gráfico
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pedidos Mensuales',
                data: data,
                backgroundColor: '#4CAF50',
                borderColor: '#45a049',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

</html>
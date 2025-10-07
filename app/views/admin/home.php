<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/partials/adminHead.php"; ?>
<!--HEAD-->

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/partials/header.php"; ?>
    <!--HEADER-->


    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/partials/asideMenu.php"; ?>
            <section class="admin-main-content">
                <div>
                    <div class="tittles">
                        <h2><strong>Bienvenido User_Name</strong></h2>
                    </div>
                </div>
                <div class="admin-content-dashboard row">

                    <!-- Tarjeta de Usuarios -->
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm border-0">
                            <div class="card-body total-users">
                                <i class="bi bi-people-fill"></i>
                                <h5 class="card-title mt-2">Clientes</h5>
                                <p class="card-text">Total registrados: <strong>120</strong></p>
                                <a href="#" class="btn-green">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Proveedores -->
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm border-0">
                            <div class="card-body active-suppliers">
                                <i class="bi bi-buildings-fill"></i>
                                <h5 class="card-title mt-2">Proveedores</h5>
                                <p class="card-text">Activos: <strong>15</strong></p>
                                <a href="#" class="btn-yellow">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Productos -->
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm border-0">
                            <div class="card-body total-products">
                                <i class="bi bi-box2-fill"></i>
                                <h5 class="card-title mt-2">Productos</h5>
                                <p class="card-text">En inventario: <strong>320</strong></p>
                                <a href="#" class="btn-orange">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Pedidos -->
                    <div class="col-md-3">
                        <div class="card text-center shadow-sm border-0">
                            <div class="card-body pending-order">
                                <i class="bi bi-cart-fill"></i>
                                <h5 class="card-title mt-2">Pedidos</h5>
                                <p class="card-text">Pendientes: <strong>8</strong></p>
                                <a href="#" class="btn-purple">Ver más</a>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos o estadísticas -->
                    <div class="col-12 mt-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">Estadísticas Mensuales</h5>
                                <canvas id="adminChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart.js para el gráfico -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('adminChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Clientes', 'Proveedores', 'Productos', 'Pedidos'],
                            datasets: [{
                                label: 'Cantidad',
                                data: [120, 15, 320, 8],
                                backgroundColor: ['#91CD00', '#FFD600', '#FF9100', '#7E0689']
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                </script>

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
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
            <aside class="admin-aside">
                <div class="aside-container">
                    <div class="aside-main">
                        <ul>
                            <li><a href="home.html"><i class="bi bi-opencollective"></i>Dashboard</a></li>
                            <li><a href="user-mgmt.html"><i class="bi bi-people-fill"></i>Gestión de Usuarios</a></li>
                            <li><a href="role-mgmt.html"><i class="bi bi-diagram-2-fill"></i>Gestión de Roles</a></li>
                            <li><a href="supplier-mgmt.html"><i class="bi bi-building-fill"></i>Gestión de
                                    Proveedores</a></li>
                            <li><a href="product-mgmt.html"><i class="bi bi-box2-fill"></i>Gestión de productos</a></li>
                            <li><a href="inventory-mgmt.html"><i class="bi bi-clipboard2-check-fill"></i>Gestión de
                                    Inventario</a></li>
                            <li><a href="accounting-record.html"><i class="bi bi-calculator-fill"></i>Registro
                                    Contable</a></li>
                            <li><a href="order-mgmt.html"><i class="bi bi-cart-fill"></i>Gestión de pedidos</a></li>
                            <li><a href="appointment-mgmt.html"><i class="bi bi-calendar-week-fill"></i>Gestión de
                                    citas</a></li>
                            <li><a href="general-settings.html"><i class="bi bi-gear-fill"></i>Configuración general</a></li>
                        </ul>
                    </div>
                    <hr />
                    <div class="aside-footer">
                        <a class="btn-dark-blue" href="../../index_unlogin.html"><strong>
                                Cerrar Sesión</strong></a>
                    </div>
                </div>
            </aside>
            <section class="admin-main-content">
                <div>
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
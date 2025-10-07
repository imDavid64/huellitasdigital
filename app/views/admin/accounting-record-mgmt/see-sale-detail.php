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
                            <li><a href="role-mgmt.html"><i class="bi bi-diagram-2-fill"></i>Gestión de Roles</a>
                            </li>
                            <li><a href="supplier-mgmt.html"><i class="bi bi-building-fill"></i>Gestión de
                                    Proveedores</a></li>
                            <li><a href="product-mgmt.html"><i class="bi bi-box2-fill"></i>Gestión de productos</a></li>
                            <li><a href="inventory-mgmt.html"><i class="bi bi-clipboard2-check-fill"></i>Gestión de
                                    Inventario</a></li>
                            <li><a href="accounting-record.html"><i class="bi bi-calculator-fill"></i>Registro
                                    Contable</a></li>
                            <li><a href="order-mgmt.html"><i class="bi bi-cart-fill"></i>Gestión de pedidos</a></li>
                            <li><a href="appointment-mgmt.html"><i class="bi bi-calendar-week-fill"></i>Gestión de citas</a>
                            </li>
                            <li><a href="general-settings.html"><i class="bi bi-gear-fill"></i>Configuración general</a>
                            </li>
                        </ul>
                    </div>
                    <hr />
                    <div class="aside-footer">
                        <a class="btn-dark-blue" href="../../index_unlogin.html"><strong>
                                Cerrar Sesión</strong></a>
                    </div>
                </div>
            </aside>
            <section class="admin-main-content-add-user">
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-receipt"></i><strong> Detalle de Compra #5001</strong></h2>
                    </div>
                </div>
                <div class="admin-see-sale-datail">
                    <div class="detail-container">
                        <div class="detail-header">
                            <span class="mb-2"><strong>Cliente: </strong>Juan Pérez</span>
                            <span class="mb-2"><strong>Fecha: </strong>12-08-2025</span>
                            <span class="mb-2"><strong>Nº Factura: </strong>5001</span>
                            <span class="mb-2"><strong>Dirección: </strong>500mts del palo del antiguo mango, calle
                                falsa</span>
                        </div>
                        <div class="detail-main">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">ID</th>
                                        <th class="text-center" scope="col">Nombre</th>
                                        <th class="text-center" scope="col">Categoría</th>
                                        <th class="text-center" scope="col">Cantidad</th>
                                        <th class="text-center" scope="col">Precio Unitario</th>
                                        <th class="text-center" scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">Alimento Premium Perro 10kg</td>
                                        <td class="text-center">Alimento</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">₡2500</td>
                                        <td class="text-center">₡5000</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td class="text-center">Collar Antipulgas</td>
                                        <td class="text-center">Accesorio</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">₡7,500</td>
                                        <td class="text-center">₡7,500</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td class="text-center">Digyton</td>
                                        <td class="text-center">Medicamento</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">₡4,200</td>
                                        <td class="text-center">₡4,200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sum-total-fact">
                            <span><strong>Subtotal: </strong>₡16,700</span>
                            <span><strong>IVA 13%: </strong>₡2,171</span>
                            <span class="sum-total"><strong>Total: </strong>₡18,871</h2>
                        </div>
                    </div>
                    <div class="detail-btns">
                        <div>
                            <a class="btn-blue">Imprimir<i class="bi bi-printer-fill"></i></a>
                        </div>
                        <div>
                            <a class="btn-black">Anular<i class="bi bi-x-square"></i></a>
                        </div>
                    </div>
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
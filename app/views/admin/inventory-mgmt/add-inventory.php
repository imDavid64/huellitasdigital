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
                        <h2><i class="bi bi-plus-circle-fill"></i><strong> Registrar Inventario</strong></h2>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="product-mgmt.html" method="POST">
                        <div class="form-container">
                            <div class="form-item">
                                <label for="addinventorymovementproducto">Producto</label>
                                <select id="addinventorymovementproducto" name="addinventorymovementproducto" required>
                                    <option value="" disabled selected>Seleccione el Producto</option>
                                    <option value="alimento">Alimento Premium Perro 10kg</option>
                                    <option value="accesorio">Collar Antipulgas</option>
                                    <option value="medicamento">Antibiótico Amoxicilina 500mg</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="addinventorymovementtype">Tipo de Movimiento</label>
                                <select id="addinventorymovementtype" name="addinventorymovementtype" required>
                                    <option value="" disabled selected>Seleccione el Producto</option>
                                    <option value="entrada">Entrada</option>
                                    <option value="salida">Salida</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="addinventorymovementcant">Cantidad</label>
                                <input type="number" id="addinventorymovementcant" name="addinventorymovementcant" required>
                            </div>
                            <div class="form-item">
                                <label for="addinventorymovementdate">Fecha</label>
                                <input type="date" id="addinventorymovementdate" name="addinventorymovementdate" required>
                            </div>
                            <div class="form-item">
                                <label for="addinventorymovementnotes">Fecha</label>
                                <input type="date" id="addinventorymovementnotes" name="addinventorymovementnotes" required>
                            </div>
                            <button type="submit" class="btn-blue"><strong>Registrar Inventario</strong><i class="bi bi-plus-circle-fill"></i></button>
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
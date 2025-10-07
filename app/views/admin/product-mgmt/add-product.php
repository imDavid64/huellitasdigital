<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>

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
                            <li><a href="appointment-mgmt.html"><i class="bi bi-calendar-week-fill"></i>Gestión de
                                    citas</a>
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
                        <h2><i class="bi bi-bag-plus-fill"></i><strong>Agregar Producto</strong></h2>
                        <div></div>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="/huellitasdigital/app/controllers/admin/productController.php?action=store" method="POST"
                        enctype="multipart/form-data">
                        <div class="form-container">

                            <div class="form-item">
                                <label for="nombre">Nombre del Producto</label>
                                <input type="text" id="nombre" name="nombre" required>
                            </div>

                            <div class="form-item">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" name="descripcion" required></textarea>
                            </div>

                            <div class="form-item">
                                <label for="precio">Precio (₡)</label>
                                <input type="number" step="0.01" id="precio" name="precio" required>
                            </div>

                            <div class="form-item">
                                <label for="stock">Cantidad en Stock</label>
                                <input type="number" id="stock" name="stock" required>
                            </div>

                            <div class="form-item">
                                <label for="proveedor">Proveedor</label>
                                <select id="proveedor" name="proveedor" required>
                                    <option value="" disabled selected>Seleccione un proveedor</option>
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?= $proveedor['ID_PROVEEDOR_PK'] ?>">
                                            <?= htmlspecialchars($proveedor['PROVEEDOR_NOMBRE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label for="estado">Estado</label>
                                <select id="estado" name="estado" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>">
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label for="imagen">Imagen del Producto</label>
                                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                            </div>

                            <button type="submit" class="btn-blue"><strong>Agregar Producto</strong><i
                                    class="bi bi-bag-plus-fill"></i></button>
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
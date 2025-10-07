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
                        <h2><i class="bi bi-pencil-square"></i><strong> Editar Producto</strong></h2>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="/huellitasdigital/app/controllers/admin/productController.php?action=update" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id_product" value="<?= $product['ID_PRODUCTO_PK'] ?>">
                        <input type="hidden" name="current_image_url"
                            value="<?= htmlspecialchars($product['IMAGEN_URL']) ?>">
                        <div class="form-container">
                            <div class="form-item">
                                <img id="imagePreview" src="<?= htmlspecialchars($product['IMAGEN_URL']) ?>"
                                    alt="Imagen del Producto"
                                    style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                            </div>
                            <div class="form-item">
                                <label for="productname">Nombre del Producto</label>
                                <input type="text" id="productname" name="productname"
                                    value="<?= htmlspecialchars($product['PRODUCTO_NOMBRE']) ?>" required>
                            </div>
                            <div class="form-item">
                                <label for="productimg">Cambiar Foto del Producto (Opcional)</label>
                                <input type="file" id="productimg" name="productimg" accept="image/*">
                            </div>
                            <div class="form-item">
                                <label for="productcategory">Categoria</label>
                                <input type="text" id="productcategory" name="productcategory"
                                    value="<?= htmlspecialchars($product['CATEGORIA']) ?>" required>
                            </div>
                            <div class="form-item">
                                <label for="productprice">Precio</label>
                                <input type="text" id="productprice" name="productprice"
                                    value="<?= htmlspecialchars($product['PRODUCTO_PRECIO_UNITARIO']) ?>" required>
                            </div>
                            <div class="form-item">
                                <label for="productstock">Stock</label>
                                <input type="number" id="productstock" name="productstock"
                                    value="<?= htmlspecialchars($product['PRODUCTO_STOCK']) ?>" required>
                            </div>
                            <div class="form-item">
                                <label for="productdescription">Descripción</label>
                                <textarea id="productdescription" name="productdescription" required>
                                    <?= $product['PRODUCTO_DESCRIPCION'] ?>
                                </textarea>
                            </div>
                            <div class="form-item">
                                <label for="productsupplier">Proveedor</label>
                                <select id="productsupplier" name="productsupplier" required>
                                    <option value="" disabled>Seleccione un Proveedor</option>
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?= $proveedor['ID_PROVEEDOR_PK'] ?>"
                                            <?= $product['ID_PROVEEDOR_FK'] == $proveedor['ID_PROVEEDOR_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($proveedor['PROVEEDOR_NOMBRE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= $product['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn-dark-blue"><strong>Guardar Cambios</strong><i
                                    class="bi bi-floppy2"></i></button>
                        </div>
                    </form>

                    <!-- Script para previsualizar la imagen seleccionada -->
                    <script>
                        document.getElementById('productimg').addEventListener('change', function (event) {
                            const [file] = event.target.files;
                            if (file) {
                                const preview = document.getElementById('imagePreview');
                                preview.src = URL.createObjectURL(file);
                                preview.onload = () => {
                                    URL.revokeObjectURL(preview.src); //Libera memoria
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
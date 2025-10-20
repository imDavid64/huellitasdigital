<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

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
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>
            <section class="admin-main-content-add-user">
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-bag-plus-fill"></i><strong>Agregar Producto</strong></h2>
                        <div></div>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="/huellitasdigital/app/controllers/admin/productController.php?action=store"
                        method="POST" enctype="multipart/form-data">
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
                                <label for="marca">Marca del Producto</label>
                                <select id="marca" name="marca" required>
                                    <option value="" disabled selected>Selecciona una Marca</option>
                                    <?php foreach ($marcas as $marca): ?>
                                        <option value="<?= $marca['ID_MARCA_PK'] ?>">
                                            <?= htmlspecialchars($marca['NOMBRE_MARCA']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label for="categoria">Categoría del Producto</label>
                                <select id="categoria" name="categoria" required>
                                    <option value="" disabled selected>Selecciona una Categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['ID_CATEGORIA_PK'] ?>">
                                            <?= htmlspecialchars($categoria['DESCRIPCION_CATEGORIA']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label for="proveedor">Proveedor</label>
                                <select id="proveedor" name="proveedor" required>
                                    <option value="" disabled selected>Seleccione un Proveedor</option>
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?= $proveedor['ID_PROVEEDOR_PK'] ?>">
                                            <?= htmlspecialchars($proveedor['PROVEEDOR_NOMBRE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label for="nuevo">¿Es Nuevo?</label>
                                <select id="nuevo" name="nuevo" required>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <?php foreach ($esNuevo as $nuevo): ?>
                                        <option value="<?= $nuevo['ID_NUEVO_PK'] ?>">
                                            <?= htmlspecialchars($nuevo['NUEVO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label for="estado">Estado</label>
                                <select id="estado" name="estado" required>
                                    <option value="" disabled selected>Seleccione un Estado</option>
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
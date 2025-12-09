<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>

<body data-error="<?= $_SESSION['error'] ?? '' ?>" data-success="<?= $_SESSION['success'] ?? '' ?>">
    <?php unset($_SESSION['error'], $_SESSION['success']); ?>

    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

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
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=index">Gestión de
                                Productos</a>
                        </li>
                        <li class="breadcrumb-item current-page">Editar Producto</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-pencil-square"></i><strong> Editar Producto</strong></h2>
                </div>
                <div class="admin-form-container">
                    <form id="editProductForm" action="<?= BASE_URL ?>/index.php?controller=adminProduct&action=update"
                        method="POST" enctype="multipart/form-data" novalidate>

                        <input type="hidden" name="id_product" value="<?= $product['ID_PRODUCTO_PK'] ?>">
                        <input type="hidden" name="current_image_url"
                            value="<?= htmlspecialchars($product['IMAGEN_URL']) ?>">

                        <div class="form-container">

                            <div class="form-item">
                                <img id="previewProducto" class="image-preview"
                                    src="<?= htmlspecialchars($product['IMAGEN_URL']) ?>" alt="Imagen del Producto"
                                    style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                            </div>

                            <div class="form-item">
                                <label for="productname">Nombre del Producto</label>
                                <input type="text" id="productname" name="productname"
                                    value="<?= htmlspecialchars($product['PRODUCTO_NOMBRE']) ?>" required>
                                <small class="error" id="error-productname"></small>
                            </div>

                            <div class="form-item">
                                <label for="productdescription">Descripción</label>
                                <textarea id="productdescription" name="productdescription"
                                    required><?= htmlspecialchars($product['PRODUCTO_DESCRIPCION']) ?></textarea>
                                <small class="error" id="error-productdescription"></small>
                            </div>

                            <div class="form-item">
                                <label for="productimg">Cambiar Foto del Producto (Opcional)</label>
                                <input type="file" class="image-input" data-preview="#previewProducto" id="productimg"
                                    name="productimg" accept="image/*">
                                <small class="error" id="error-productimg"></small>
                            </div>

                            <div class="form-item">
                                <label for="productprice">Precio (₡)</label>
                                <input type="text" id="productprice" name="productprice"
                                    value="<?= htmlspecialchars($product['PRODUCTO_PRECIO_UNITARIO']) ?>" required>
                                <small class="error" id="error-productprice"></small>
                            </div>

                            <div class="form-item">
                                <label for="productstock">Cantidad en Stock</label>
                                <input type="number" id="productstock" name="productstock"
                                    value="<?= htmlspecialchars($product['PRODUCTO_STOCK']) ?>" required>
                                <small class="error" id="error-productstock"></small>
                            </div>

                            <div class="form-item">
                                <label for="productbrand">Marca del Producto</label>
                                <select id="productbrand" name="productbrand" required>
                                    <option value="" disabled>Seleccione una Marca</option>
                                    <?php foreach ($marcas as $marca): ?>
                                        <option value="<?= $marca['ID_MARCA_PK'] ?>"
                                            <?= $product['ID_MARCA_FK'] == $marca['ID_MARCA_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($marca['NOMBRE_MARCA']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="error" id="error-productbrand"></small>
                            </div>

                            <div class="form-item">
                                <label for="productcategory">Categoría del Producto</label>
                                <select id="productcategory" name="productcategory" required>
                                    <option value="" disabled>Seleccione una Categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['ID_CATEGORIA_PK'] ?>"
                                            <?= $product['ID_CATEGORIA_FK'] == $categoria['ID_CATEGORIA_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($categoria['DESCRIPCION_CATEGORIA']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="error" id="error-productcategory"></small>
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
                                <small class="error" id="error-productsupplier"></small>
                            </div>

                            <div class="form-item">
                                <label for="productisnew">¿Es Nuevo?</label>
                                <select id="productisnew" name="productisnew" required>
                                    <option value="" disabled>Seleccione una opción</option>
                                    <?php foreach ($esNuevo as $nuevo): ?>
                                        <option value="<?= $nuevo['ID_NUEVO_PK'] ?>"
                                            <?= $product['ID_NUEVO_FK'] == $nuevo['ID_NUEVO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($nuevo['NUEVO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="error" id="error-productisnew"></small>
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
                                <small class="error" id="error-state"></small>
                            </div>

                            <button type="submit" class="btn-dark-blue">
                                <strong>Guardar Cambios</strong>
                                <i class="bi bi-floppy2"></i>
                            </button>

                        </div>
                    </form>

                    <script>
                        // VALIDACIONES
                        document.getElementById('editProductForm').addEventListener('submit', function (e) {
                            let valid = true;

                            document.querySelectorAll('.error').forEach(err => err.textContent = '');

                            const fields = [
                                'productname', 'productdescription', 'productprice', 'productstock',
                                'productbrand', 'productcategory', 'productsupplier', 'productisnew',
                                'state'
                            ];

                            fields.forEach(id => {
                                const el = document.getElementById(id);
                                if (!el.value || el.value.trim() === '') {
                                    document.getElementById('error-' + id).textContent = 'Este campo es obligatorio.';
                                    valid = false;
                                }
                            });

                            // Validación precio y stock
                            const price = parseFloat(document.getElementById('productprice').value);
                            if (isNaN(price) || price <= 0) {
                                document.getElementById('error-productprice').textContent = 'Ingrese un precio válido.';
                                valid = false;
                            }

                            const stock = parseInt(document.getElementById('productstock').value);
                            if (isNaN(stock) || stock < 0) {
                                document.getElementById('error-productstock').textContent = 'Ingrese una cantidad válida.';
                                valid = false;
                            }

                            if (!valid) e.preventDefault();
                        });
                    </script>

                </div>
            </section>
        </section>
    </main>
</body>

<footer>
    <div class="post-footer" style="background-color: #002557; color: white;">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>

<style>
    .error {
        color: red;
        font-size: 0.9em;
    }
</style>

</html>
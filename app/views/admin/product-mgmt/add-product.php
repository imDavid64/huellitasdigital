<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--HEAD-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>
<!--HEAD-->

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
                        <li class="breadcrumb-item current-page">Agregar Producto</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-bag-plus-fill"></i><strong>Agregar Producto</strong></h2>
                </div>

                <div class="admin-form-container">
                    <form id="productForm" action="<?= BASE_URL ?>/index.php?controller=adminProduct&action=store"
                        method="POST" enctype="multipart/form-data" novalidate>

                        <div class="form-container">

                            <div class="form-item">
                                <label for="nombre">Nombre del Producto</label>
                                <input type="text" id="nombre" name="nombre" required>
                                <small class="error" id="error-nombre"></small>
                            </div>

                            <div class="form-item">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" name="descripcion" required></textarea>
                                <small class="error" id="error-descripcion"></small>
                            </div>

                            <div class="form-item">
                                <label for="precio">Precio (₡)</label>
                                <input type="number" step="0.01" id="precio" name="precio" required>
                                <small class="error" id="error-precio"></small>
                            </div>

                            <div class="form-item">
                                <label for="stock">Cantidad en Stock</label>
                                <input type="number" id="stock" name="stock" required>
                                <small class="error" id="error-stock"></small>
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
                                <small class="error" id="error-marca"></small>
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
                                <small class="error" id="error-categoria"></small>
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
                                <small class="error" id="error-proveedor"></small>
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
                                <small class="error" id="error-nuevo"></small>
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
                                <small class="error" id="error-estado"></small>
                            </div>

                            <div class="form-item">
                                <label for="imagen">Imagen del Producto</label>
                                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                                <small class="error" id="error-imagen"></small>
                            </div>

                            <button type="submit" class="btn-blue">
                                <strong>Agregar Producto</strong>
                                <i class="bi bi-bag-plus-fill"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>

    <footer>
        <div class="post-footer" style="background-color: #002557; color: white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>

    <!--VALIDACIONES-->
    <script>
        document.getElementById('productForm').addEventListener('submit', function (e) {
            let valid = true;

            // Limpiar mensajes previos
            document.querySelectorAll('.error').forEach(err => err.textContent = '');

            const fields = [
                'nombre', 'descripcion', 'precio', 'stock',
                'marca', 'categoria', 'proveedor', 'nuevo',
                'estado', 'imagen'
            ];

            fields.forEach(id => {
                const el = document.getElementById(id);
                if (!el.value || el.value.trim() === '') {
                    document.getElementById('error-' + id).textContent = 'Este campo es obligatorio.';
                    valid = false;
                }
            });

            // Validación de precio y stock numéricos positivos
            const precio = document.getElementById('precio');
            if (precio.value <= 0) {
                document.getElementById('error-precio').textContent = 'Ingrese un precio válido.';
                valid = false;
            }

            const stock = document.getElementById('stock');
            if (stock.value < 0) {
                document.getElementById('error-stock').textContent = 'Ingrese una cantidad válida.';
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    </script>

    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</body>

</html>
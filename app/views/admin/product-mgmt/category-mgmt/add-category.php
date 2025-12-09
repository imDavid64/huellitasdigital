<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<?php include_once __DIR__ . "/../../partials/adminHead.php"; ?>

<body data-error="<?= $_SESSION['error'] ?? '' ?>" data-success="<?= $_SESSION['success'] ?? '' ?>">
    <?php unset($_SESSION['error'], $_SESSION['success']); ?>

    <!--HEADER-->
    <?php include_once __DIR__ . "/../../partials/header.php"; ?>
    <!--HEADER-->

    <main>
        <section class="admin-main">
            <?php include_once __DIR__ . "/../../partials/asideMenu.php"; ?>
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
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=categoryMgmt">Gestión
                                de
                                Categorías</a>
                        </li>
                        <li class="breadcrumb-item current-page">Agregar Categoría</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2>
                        <i class="bi bi-collection-fill"></i><strong>+</strong><strong>Agregar Categoría</strong>
                    </h2>
                </div>
                <div class="admin-form-container">
                    <form id="categoryForm"
                        action="<?= BASE_URL ?>/index.php?controller=adminProduct&action=storeCategory" method="POST"
                        enctype="multipart/form-data" novalidate>

                        <div class="form-container">

                            <div class="form-item">
                                <label for="nombreCategoria">Nombre de la Categoría</label>
                                <input type="text" id="nombreCategoria" name="nombreCategoria" required>
                                <small class="error" id="error-nombreCategoria"></small>
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
                                <small class="error" id="error-estado"></small>
                            </div>

                            <button type="submit" class="btn-blue">
                                <strong>Agregar Categoría</strong>
                                <i class="bi bi-collection-fill"></i><strong>+</strong>
                            </button>

                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>

    <!--FOOTER-->
    <footer>
        <div class="post-footer" style="background-color: #002557; color: white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>

    <!--VALIDACIONES-->
    <script>
        document.getElementById('categoryForm').addEventListener('submit', function (e) {
            let valid = true;

            // Limpiar mensajes previos
            document.querySelectorAll('.error').forEach(err => err.textContent = '');

            const nombre = document.getElementById('nombreCategoria');
            const estado = document.getElementById('estado');

            if (nombre.value.trim() === '') {
                document.getElementById('error-nombreCategoria').textContent = 'El nombre de la categoría es obligatorio.';
                valid = false;
            }

            if (!estado.value || estado.value === '') {
                document.getElementById('error-estado').textContent = 'Debe seleccionar un estado.';
                valid = false;
            }

            if (!valid) e.preventDefault();
        });

        // VALIDACIÓN ONBLUR (opcional, aparece al salir del campo)
        document.getElementById('nombreCategoria').addEventListener('blur', function () {
            const el = document.getElementById('nombreCategoria');
            document.getElementById('error-nombreCategoria').textContent = el.value.trim() === '' ? 'El nombre de la categoría es obligatorio.' : '';
        });

        document.getElementById('estado').addEventListener('blur', function () {
            const el = document.getElementById('estado');
            document.getElementById('error-estado').textContent = (!el.value || el.value === '') ? 'Debe seleccionar un estado.' : '';
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
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
            <!--Aside Menu-->
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
                            <a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=brandMgmt">Gestión de
                                Marcas</a>
                        </li>
                        <li class="breadcrumb-item current-page">Editar Marca</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-pencil-square"></i><strong> Editar Marca</strong></h2>
                </div>

                <div class="admin-form-container">
                    <form id="editBrandForm"
                        action="<?= BASE_URL ?>/index.php?controller=adminProduct&action=updateBrand" method="POST"
                        enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="id_brand" value="<?= $marca['ID_MARCA_PK'] ?>">
                        <input type="hidden" name="current_image_url"
                            value="<?= htmlspecialchars($marca['MARCA_IMAGEN_URL']) ?>">

                        <div class="form-container">
                            <div class="form-item">
                                <img class="image-preview" id="imagePreview"
                                    src="<?= htmlspecialchars($marca['MARCA_IMAGEN_URL']) ?>" alt="Imagen de la marca"
                                    style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                            </div>
                            <div class="form-item">
                                <label for="brandname">Nombre de la Marca</label>
                                <input type="text" id="brandname" name="brandname"
                                    value="<?= htmlspecialchars($marca['NOMBRE_MARCA']) ?>" required>
                                <small class="error" id="error-brandname"></small>
                            </div>

                            <div class="form-item">
                                <label for="brandimg">Cambiar Logo de la Marca (Opcional)</label>
                                <input type="file" id="brandimg" class="image-input" name="brandimg" accept="image/*">
                                <small class="error" id="error-brandimg"></small>
                            </div>

                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= $marca['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="error" id="error-state"></small>
                            </div>

                            <button type="submit" class="btn-dark-blue">
                                <strong>Guardar Cambios</strong><i class="bi bi-floppy2"></i>
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
        const form = document.getElementById('editBrandForm');

        form.addEventListener('submit', function (e) {
            let valid = true;

            // Limpiar errores previos
            document.querySelectorAll('.error').forEach(err => err.textContent = '');

            const brandname = document.getElementById('brandname');
            const state = document.getElementById('state');

            if (brandname.value.trim() === '') {
                document.getElementById('error-brandname').textContent = 'El nombre de la marca es obligatorio.';
                valid = false;
            }

            if (!state.value || state.value === '') {
                document.getElementById('error-state').textContent = 'Debe seleccionar un estado.';
                valid = false;
            }

            if (!valid) e.preventDefault();
        });

        // Validaciones onblur
        document.getElementById('brandname').addEventListener('blur', function () {
            const el = document.getElementById('brandname');
            document.getElementById('error-brandname').textContent = el.value.trim() === '' ? 'El nombre de la marca es obligatorio.' : '';
        });

        document.getElementById('state').addEventListener('blur', function () {
            const el = document.getElementById('state');
            document.getElementById('error-state').textContent = (!el.value || el.value === '') ? 'Debe seleccionar un estado.' : '';
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
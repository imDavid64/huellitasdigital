<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<?php include_once __DIR__ . "/../../partials/adminHead.php"; ?>

<body>

    <!--HEADER-->
    <?php include_once __DIR__ . "/../../partials/header.php"; ?>
    <!--HEADER-->

    <main>
        <section class="admin-main">
            <!--Aside Menu-->
            <?php include_once __DIR__ . "/../../partials/asideMenu.php"; ?>
            
            <section class="admin-main-content-add-user">
                <div class="tittles">
                    <h2><i class="bi bi-pencil-square"></i><strong> Editar Categoría</strong></h2>
                </div>

                <div class="admin-form-container">
                    <form id="editCategoryForm" action="/huellitasdigital/app/controllers/admin/productController.php?action=updateCategory" 
                          method="POST" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="id_categoria" value="<?= $categoria['ID_CATEGORIA_PK'] ?>">

                        <div class="form-container">

                            <div class="form-item">
                                <label for="categoryname">Nombre de la Categoría</label>
                                <input type="text" id="categoryname" name="categoryname"
                                    value="<?= htmlspecialchars($categoria['DESCRIPCION_CATEGORIA']) ?>" required>
                                <small class="error" id="error-categoryname"></small>
                            </div>

                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= $categoria['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
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
        const form = document.getElementById('editCategoryForm');

        form.addEventListener('submit', function(e) {
            let valid = true;

            // Limpiar errores previos
            document.querySelectorAll('.error').forEach(err => err.textContent = '');

            const categoryName = document.getElementById('categoryname');
            const state = document.getElementById('state');

            if (categoryName.value.trim() === '') {
                document.getElementById('error-categoryname').textContent = 'El nombre de la categoría es obligatorio.';
                valid = false;
            }

            if (!state.value || state.value === '') {
                document.getElementById('error-state').textContent = 'Debe seleccionar un estado.';
                valid = false;
            }

            if (!valid) e.preventDefault();
        });

        // Validación onblur
        document.getElementById('categoryname').addEventListener('blur', function() {
            const el = document.getElementById('categoryname');
            document.getElementById('error-categoryname').textContent = el.value.trim() === '' ? 'El nombre de la categoría es obligatorio.' : '';
        });

        document.getElementById('state').addEventListener('blur', function() {
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

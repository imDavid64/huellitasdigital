<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>
<!--HEAD-->

<body data-error="<?= $_SESSION['error'] ?? '' ?>" data-success="<?= $_SESSION['success'] ?? '' ?>">
    <?php unset($_SESSION['error'], $_SESSION['success']); ?>

    <!--Include para el header-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menú aside-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>

            <section class="admin-main-content-add-user">
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-pencil-square"></i><strong> Editar Rol</strong></h2>
                    </div>
                </div>

                <div class="admin-form-container">
                    <form id="editRoleForm"
                        action="<?= BASE_URL ?>/index.php?controller=adminRole&action=update" method="POST"
                        enctype="multipart/form-data" novalidate>

                        <input type="hidden" name="id_rol" value="<?= htmlspecialchars($rol['ID_ROL_USUARIO_PK']) ?>">

                        <div class="form-container">
                            <!-- Campo: Nombre del Rol -->
                            <div class="form-item">
                                <label for="rolename">Nombre del rol</label>
                                <input type="text" id="rolename" name="rolename"
                                    value="<?= htmlspecialchars($rol['DESCRIPCION_ROL_USUARIO']) ?>" required
                                    minlength="3" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                                    title="Solo se permiten letras y espacios.">
                                <small id="rolenameError" style="color:red; display:none;">
                                    El nombre del rol debe tener entre 3 y 50 caracteres y solo puede contener letras y
                                    espacios.
                                </small>
                            </div>

                            <!-- Campo: Estado -->
                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= htmlspecialchars($estado['ID_ESTADO_PK']) ?>"
                                            <?= $rol['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small id="stateError" style="color:red; display:none;">
                                    Debe seleccionar un estado válido.
                                </small>
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
    <!--CONTENIDO CENTRAL-->

    <!--VALIDACIONES CLIENTE-->
    <script>
        document.getElementById("editRoleForm").addEventListener("submit", function (event) {
            let valid = true;

            // Validación del nombre del rol
            const roleInput = document.getElementById("rolename");
            const roleError = document.getElementById("rolenameError");
            const regexRol = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/;
            const roleValue = roleInput.value.trim();

            if (roleValue.length < 3 || roleValue.length > 50 || !regexRol.test(roleValue)) {
                roleError.style.display = "block";
                valid = false;
            } else {
                roleError.style.display = "none";
            }

            // Validación del estado
            const stateSelect = document.getElementById("state");
            const stateError = document.getElementById("stateError");

            if (!stateSelect.value) {
                stateError.style.display = "block";
                valid = false;
            } else {
                stateError.style.display = "none";
            }

            // Evita el envío si hay errores
            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
    <!--FIN VALIDACIONES CLIENTE-->

</body>

<!--FOOTER-->
<footer>
    <div class="post-footer" style="background-color: #002557; color: white;">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>
<!--FOOTER-->

</html>
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

    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--ASIDE MENU-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>

            <section class="admin-main-content-add-user">
                <div class="tittles">
                    <h2><i class="bi bi-pencil-square"></i><strong> Editar Usuario</strong></h2>
                </div>

                <div class="admin-form-container">
                    <form id="editUserForm"
                          action="/huellitasdigital/app/controllers/admin/userController.php?action=update"
                          method="POST" enctype="multipart/form-data" novalidate>
                          
                        <!-- Hidden ID -->
                        <input type="hidden" name="id_usuario" value="<?= $usuario['ID_USUARIO_PK'] ?>">

                        <div class="form-container">
                            <!-- Nombre de usuario -->
                            <div class="form-item">
                                <label for="username">Nombre de usuario</label>
                                <input type="text" id="username" name="username"
                                       value="<?= htmlspecialchars($usuario['USUARIO_NOMBRE']) ?>"
                                       required minlength="3" maxlength="50"
                                       pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                                       title="Solo se permiten letras y espacios.">
                                <small id="usernameError" style="color:red; display:none;">
                                    El nombre debe tener entre 3 y 50 caracteres y solo puede contener letras y espacios.
                                </small>
                            </div>

                            <!-- Correo electrónico -->
                            <div class="form-item">
                                <label for="email">Correo electrónico</label>
                                <input type="email" id="email" name="email"
                                       value="<?= htmlspecialchars($usuario['USUARIO_CORREO']) ?>" required>
                                <small id="emailError" style="color:red; display:none;">
                                    Ingrese un correo electrónico válido.
                                </small>
                            </div>

                            <!-- Contraseña -->
                            <div class="form-item">
                                <label for="password">Contraseña</label>
                                <input type="password" id="password" name="password"
                                       placeholder="Dejar vacío si no cambia"
                                       minlength="8"
                                       title="Debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.">
                                <small id="passwordError" style="color:red; display:none;">
                                    Si cambia la contraseña, debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un símbolo.
                                </small>
                            </div>

                            <!-- Foto de perfil -->
                            <div class="form-item">
                                <label for="profile-pic">Foto de perfil</label>
                                <input type="file" id="profile-pic" name="profile-pic" accept="image/*">
                            </div>

                            <!-- Estado -->
                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= htmlspecialchars($estado['ID_ESTADO_PK']) ?>"
                                            <?= $usuario['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small id="stateError" style="color:red; display:none;">
                                    Debe seleccionar un estado.
                                </small>
                            </div>

                            <!-- Rol -->
                            <div class="form-item">
                                <label for="role">Rol</label>
                                <select id="role" name="role" required>
                                    <option value="" disabled>Seleccione un rol</option>
                                    <?php foreach ($roles as $rol): ?>
                                        <option value="<?= htmlspecialchars($rol['ID_ROL_USUARIO_PK']) ?>"
                                            <?= $usuario['ID_ROL_USUARIO_FK'] == $rol['ID_ROL_USUARIO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($rol['DESCRIPCION_ROL_USUARIO']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small id="roleError" style="color:red; display:none;">
                                    Debe seleccionar un rol.
                                </small>
                            </div>

                            <!-- Botón -->
                            <button type="submit" class="btn-dark-blue">
                                <strong>Guardar Cambios</strong> <i class="bi bi-floppy2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>

    <!--VALIDACIONES CLIENTE-->
    <script>
        document.getElementById("editUserForm").addEventListener("submit", function (event) {
            let valid = true;

            // Nombre de usuario
            const username = document.getElementById("username");
            const usernameError = document.getElementById("usernameError");
            const regexName = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/;
            const nameValue = username.value.trim();

            if (nameValue.length < 3 || nameValue.length > 50 || !regexName.test(nameValue)) {
                usernameError.style.display = "block";
                valid = false;
            } else {
                usernameError.style.display = "none";
            }

            // Correo electrónico
            const email = document.getElementById("email");
            const emailError = document.getElementById("emailError");
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regexEmail.test(email.value.trim())) {
                emailError.style.display = "block";
                valid = false;
            } else {
                emailError.style.display = "none";
            }

            // Contraseña (solo si se escribe)
            const password = document.getElementById("password");
            const passwordError = document.getElementById("passwordError");
            const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (password.value.trim() !== "" && !regexPassword.test(password.value.trim())) {
                passwordError.style.display = "block";
                valid = false;
            } else {
                passwordError.style.display = "none";
            }

            // Estado
            const state = document.getElementById("state");
            const stateError = document.getElementById("stateError");
            if (!state.value) {
                stateError.style.display = "block";
                valid = false;
            } else {
                stateError.style.display = "none";
            }

            // Rol
            const role = document.getElementById("role");
            const roleError = document.getElementById("roleError");
            if (!role.value) {
                roleError.style.display = "block";
                valid = false;
            } else {
                roleError.style.display = "none";
            }

            if (!valid) event.preventDefault();
        });
    </script>
    <!--FIN VALIDACIONES-->

</body>

<!--FOOTER-->
<footer>
    <div class="post-footer" style="background-color: #002557; color: white;">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>
</html>

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

<body>

    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--ASIDE MENU-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>

            <section class="admin-main-content-add-user">
                <div class="tittles">
                    <h2><i class="bi bi-person-fill-add"></i><strong> Agregar Usuario</strong></h2>
                </div>

                <div class="admin-form-container">
                    <form id="addUserForm"
                          action="/huellitasdigital/app/controllers/admin/userController.php?action=store"
                          method="POST" enctype="multipart/form-data" novalidate>

                        <div class="form-container">
                            <!-- Nombre de usuario -->
                            <div class="form-item">
                                <label for="username">Nombre de usuario</label>
                                <input type="text" id="username" name="username"
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
                                <input type="email" id="email" name="email" required>
                                <small id="emailError" style="color:red; display:none;">
                                    Ingrese un correo electrónico válido.
                                </small>
                            </div>

                            <!-- Contraseña -->
                            <div class="form-item">
                                <label for="password">Contraseña</label>
                                <input type="password" id="password" name="password" required minlength="8"
                                       title="Debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.">
                                <small id="passwordError" style="color:red; display:none;">
                                    La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un símbolo.
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
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= htmlspecialchars($estado['ID_ESTADO_PK']) ?>">
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
                                    <option value="" disabled selected>Seleccione un rol</option>
                                    <?php foreach ($roles as $rol): ?>
                                        <option value="<?= htmlspecialchars($rol['ID_ROL_USUARIO_PK']) ?>">
                                            <?= htmlspecialchars($rol['DESCRIPCION_ROL_USUARIO']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small id="roleError" style="color:red; display:none;">
                                    Debe seleccionar un rol.
                                </small>
                            </div>

                            <!-- Botón -->
                            <button type="submit" class="btn-blue">
                                <strong>Agregar Usuario</strong> <i class="bi bi-person-fill-add"></i>
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
        document.getElementById("addUserForm").addEventListener("submit", function (event) {
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

            // Contraseña
            const password = document.getElementById("password");
            const passwordError = document.getElementById("passwordError");
            const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (!regexPassword.test(password.value.trim())) {
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

            if (!valid) {
                event.preventDefault(); // Evita enviar el formulario si hay errores
            }
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
<!--FOOTER-->

</html>

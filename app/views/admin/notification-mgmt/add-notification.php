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
                        <h2><i class="bi bi-bell-fill">+</i><strong> Agregar Notificación</strong></h2>
                    </div>
                </div>

                <div class="admin-form-container">
                    <form id="notificationForm"
                        action="<?= BASE_URL ?>/index.php?controller=adminNotification&action=store" method="POST"
                        novalidate>
                        <div class="form-container">

                            <!--Seleccionar si la notificación es para un usuario o es global-->
                            <div class="form-item">
                                <label><strong>Destino de la Notificación</strong></label>

                                <div class="notification-target-selector">
                                    <label class="selector-option">
                                        <input type="radio" name="notificationTarget" value="GLOBAL" checked>
                                        <span>Notificación Global 🌍</span>
                                    </label>

                                    <label class="selector-option">
                                        <input type="radio" name="notificationTarget" value="PERSONA">
                                        <span>Para un Usuario Específico 👤</span>
                                    </label>
                                </div>
                            </div>

                            <!-- ======================================================= -->
                            <!-- BUSCADOR DE USUARIO PARA NOTIFICACIONES -->
                            <!-- ======================================================= -->
                            <div class="mb-3 position-relative" id="buscadorNotificacionWrapper" style="display:none;">
                                <label class="form-label fw-bold">Buscar Usuario / Cliente</label>
                                <input type="text" class="form-control" id="buscadorNotificacion"
                                    placeholder="Nombre, correo, cédula, código...">

                                <div id="listaResultadosNotificacion" class="list-group position-absolute shadow-sm"
                                    style="z-index: 20; width: 100%; display:none;"></div>
                            </div>

                            <!-- ======================================================= -->
                            <!-- INFORMACIÓN DEL USUARIO SELECCIONADO -->
                            <!-- ======================================================= -->
                            <input type="hidden" id="selectedUserId" name="selectedUserId">

                            <div id="datosUsuarioSeleccionado" class="border rounded p-3 mb-3" style="display:none;">
                                <h5 class="fw-bold mb-3"><i class="bi bi-person-check-fill"></i> Usuario Seleccionado
                                </h5>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="usuarioNombreInput" disabled
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Correo</label>
                                        <input type="text" class="form-control" id="usuarioCorreoInput" disabled
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Identificación</label>
                                        <input type="text" class="form-control" id="usuarioIdentificacionInput" disabled
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="usuarioTelefonoInput" disabled
                                            readonly>
                                    </div>

                                    <div class="col-12 mb-2">
                                        <label class="form-label">Dirección</label>
                                        <textarea id="usuarioDireccionInput" class="form-control" rows="2" disabled
                                            readonly></textarea>
                                    </div>
                                </div>
                            </div>


                            <!-- Guardará el ID del usuario seleccionado -->
                            <input type="hidden" name="selectedUserId" id="selectedUserId">
                            <hr />
                        </div>

                        <!-- Campo: Titulo de la notificación -->
                        <div class="form-item">
                            <label for="addNotificationTitle">Título de la Notificación</label>
                            <input type="text" id="addNotificationTitle" placeholder="Maximo 50 caracteres"
                                name="addNotificationTitle" required minlength="3" maxlength="50"
                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo se permiten letras y espacios.">
                            <small id="addNotificationTitleError" style="color:red; display:none;">El título de la
                                notificación debe
                                tener entre 3 y 50 caracteres y solo puede contener letras y espacios.</small>
                        </div>

                        <!-- Campo: Mensaje de la notificación -->
                        <div class="form-item">
                            <label for="addNotificationMessage">Mensaje de la Notificación</label>
                            <textarea id="addNotificationMessage" placeholder="Maximo 200 caracteres"
                                name="addNotificationMessage" required minlength="3" maxlength="200"
                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+" title="Solo se permiten letras y espacios."></textarea>
                            <small id="addNotificationMessageError" style="color:red; display:none;">El mensaje de
                                la
                                notificación debe
                                tener entre 3 y 200 caracteres y solo puede contener letras y espacios.</small>
                        </div>

                        <!-- Campo: Tipo de notificación -->
                        <div class="form-item">
                            <label for="notificationType">Tipo de Notificación</label>
                            <select id="notificationType" name="notificationType" required>
                                <option value="" disabled selected>Seleccione un tipo de notificación</option>
                                <option value="INFORMACION">Información</option>
                                <option value="PROMOCION">Promoción</option>
                                <option value="SISTEMA">Sistema</option>
                                <option value="PEDIDO">Pedido</option>
                                <option value="CITA">Cita</option>
                            </select>
                            <small id="notificationTypeError" style="color:red; display:none;">Debe seleccionar un
                                tipo
                                de notificación
                                válido.</small>
                        </div>

                        <!-- Campo: Prioridad -->
                        <div class="form-item">
                            <label for="priority">Prioridad</label>
                            <select id="priority" name="priority" required>
                                <option value="" disabled selected>Seleccione una prioridad</option>
                                <option value="BAJA">Baja</option>
                                <option value="MEDIA">Media</option>
                                <option value="ALTA">Alta</option>
                            </select>
                            <small id="priorityError" style="color:red; display:none;">Debe seleccionar una
                                prioridad
                                válida.</small>
                        </div>

                        <!-- Campo: Dirección URL -->
                        <div class="form-item">
                            <label for="url">Dirección URL (opcional)</label>
                            <input type="url" id="url" name="url">
                        </div>

                        <button type="submit" class="btn-blue"><strong>Enviar Notificación</strong><i
                                class="bi bi-send"></i></button>
                </div>
                </form>
                </div>
            </section>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
    <!--VALIDACIONES CLIENTE-->
    <script>
        document.getElementById("notificationForm").addEventListener("submit", function (event) {
            let valid = true;

            // Nombre del Rol
            const roleInput = document.getElementById("addrolename");
            const roleError = document.getElementById("addrolenameError");
            const regexRol = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/;
            const roleValue = roleInput.value.trim();

            if (roleValue.length < 3 || roleValue.length > 50 || !regexRol.test(roleValue)) {
                roleError.style.display = "block";
                valid = false;
            } else {
                roleError.style.display = "none";
            }

            // Estado
            const stateSelect = document.getElementById("state");
            const stateError = document.getElementById("stateError");

            if (!stateSelect.value) {
                stateError.style.display = "block";
                valid = false;
            } else {
                stateError.style.display = "none";
            }

            // Evita envío si hay errores
            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
    <!--FIN VALIDACIONES CLIENTE-->

    <!--FOOTER-->
    <footer>
        <div class="post-footer" style="background-color: #002557; color: white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>
    <!--FOOTER-->
</body>

</html>
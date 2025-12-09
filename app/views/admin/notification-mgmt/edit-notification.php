<?php
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']);

// Detectar si estamos editando
$isEdit = isset($notification);
?>

<?php if (isset($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: "success",
            title: "Operación exitosa",
            text: "<?= $_SESSION['success'] ?>",
            confirmButtonColor: "#3085d6"
        });
    </script>
    <?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Ocurrió un problema",
            text: "<?= $_SESSION['error'] ?>",
            confirmButtonColor: "#d33"
        });
    </script>
    <?php unset($_SESSION['error']); endif; ?>


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

            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>

            <section class="admin-main-content-add-user">

                <!--Breadcrumb-->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminNotification&action=index">Gestión de
                                Notificaciones</a>
                        </li>
                        <li class="breadcrumb-item current-page">Editar Notificación</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2>
                        <i class="bi bi-bell-fill"></i>
                        <strong><?= $isEdit ? "Editar Notificación" : "Agregar Notificación" ?></strong>
                    </h2>
                </div>

                <div class="admin-form-container">

                    <form id="notificationEditForm"
                        action="<?= BASE_URL ?>/index.php?controller=adminNotification&action=<?= $isEdit ? 'update' : 'store' ?>"
                        method="POST">

                        <div class="form-container">
                            <?php if ($isEdit): ?>
                                <input type="hidden" name="id" value="<?= $notification['ID_NOTIFICACION_PK'] ?>">
                            <?php endif; ?>

                            <!-- Campo: Título -->
                            <div class="form-item">
                                <label for="addNotificationTitle">Título de la Notificación</label>
                                <input type="text" id="addNotificationTitle" name="addNotificationTitle"
                                    placeholder="Máximo 50 caracteres" required minlength="3" maxlength="50"
                                    value="<?= $isEdit ? htmlspecialchars($notification['TITULO_NOTIFICACION']) : '' ?>">
                                <small id="addNotificationTitleError" style="color:red; display:none;">
                                    El título debe tener entre 3 y 50 caracteres y solo letras.
                                </small>
                            </div>

                            <!-- Campo: Mensaje -->
                            <div class="form-item">
                                <label for="addNotificationMessage">Mensaje de la Notificación</label>
                                <textarea id="addNotificationMessage" name="addNotificationMessage"
                                    placeholder="Máximo 200 caracteres" required minlength="3"
                                    maxlength="200"><?= $isEdit ? htmlspecialchars($notification['MENSAJE_NOTIFICACION']) : '' ?></textarea>

                                <small id="addNotificationMessageError" style="color:red; display:none;">
                                    El mensaje debe tener entre 3 y 200 caracteres y solo letras.
                                </small>
                            </div>

                            <!-- Tipo -->
                            <div class="form-item">
                                <label for="notificationType">Tipo de Notificación</label>
                                <select id="notificationType" name="notificationType" required>
                                    <option value="" disabled <?= !$isEdit ? "selected" : "" ?>>Seleccione un tipo
                                    </option>

                                    <?php
                                    $tipos = ["INFORMACION", "PROMOCION", "SISTEMA", "PEDIDO", "CITA"];
                                    foreach ($tipos as $t): ?>
                                        <option value="<?= $t ?>" <?= $isEdit && $notification['TIPO_NOTIFICACION'] === $t ? "selected" : "" ?>>
                                            <?= $t ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <small id="notificationTypeError" style="color:red; display:none;">
                                    Debe seleccionar un tipo válido.
                                </small>
                            </div>

                            <!-- Prioridad -->
                            <div class="form-item">
                                <label for="priority">Prioridad</label>
                                <select id="priority" name="priority" required>
                                    <option value="" disabled <?= !$isEdit ? "selected" : "" ?>>Seleccione una prioridad
                                    </option>

                                    <?php
                                    $prioridades = ["BAJA", "MEDIA", "ALTA"];
                                    foreach ($prioridades as $p): ?>
                                        <option value="<?= $p ?>" <?= $isEdit && $notification['PRIORIDAD'] === $p ? "selected" : "" ?>>
                                            <?= $p ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <small id="priorityError" style="color:red; display:none;">
                                    Debe seleccionar una prioridad válida.
                                </small>
                            </div>

                            <!-- Estado y Leída (solo en editar) -->
                            <?php if ($isEdit): ?>
                                <div class="form-item">
                                    <label>Estado</label>
                                    <select name="state" required>
                                        <option value="1" <?= $notification['ID_ESTADO_FK'] == 1 ? "selected" : "" ?>>Activa
                                        </option>
                                        <option value="2" <?= $notification['ID_ESTADO_FK'] == 2 ? "selected" : "" ?>>Inactiva
                                        </option>
                                    </select>
                                </div>

                                <div class="form-item">
                                    <label>¿Marcar como leída?</label>
                                    <select name="read" required>
                                        <option value="0" <?= $notification['ES_LEIDA'] == 0 ? "selected" : "" ?>>No</option>
                                        <option value="1" <?= $notification['ES_LEIDA'] == 1 ? "selected" : "" ?>>Sí</option>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <!--
                            <?php if ($isEdit): ?>
                                <div class="form-item">
                                    <label for="url">URL de Redirección (opcional)</label>
                                    <input type="url" id="url" name="url"
                                        value="<?= htmlspecialchars($notification['URL_REDIRECCION'] ?? '') ?>"
                                        placeholder="https://ejemplo.com">
                                </div>
                            <?php endif; ?>
                            -->


                            <button type="submit" class="btn-blue mb-4">
                                <strong><?= $isEdit ? "Actualizar Notificación" : "Enviar Notificación" ?></strong>
                                <i class="bi bi-send"></i>
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

</body>

</html>
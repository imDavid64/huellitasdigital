<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>
<!--HEAD-->

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->


    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>
            <section class="admin-main-content-add-user">
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-pencil-square"></i><strong> Editar Usuario</strong></h2>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="/huellitasdigital/app/controllers/admin/userController.php?action=update" method="POST" enctype="multipart/form-data">
                        <!-- Hidden para enviar el ID del usuario -->
                        <input type="hidden" name="id_usuario" value="<?= $usuario['ID_USUARIO_PK'] ?>">

                        <div class="form-container">
                            <div class="form-item">
                                <label for="username">Nombre de usuario</label>
                                <input type="text" id="username" name="username"
                                    value="<?= htmlspecialchars($usuario['USUARIO_NOMBRE']) ?>" required>
                            </div>
                            <div class="form-item">
                                <label for="email">Correo electrónico</label>
                                <input type="email" id="email" name="email"
                                    value="<?= htmlspecialchars($usuario['USUARIO_CORREO']) ?>" required>
                            </div>
                            <div class="form-item">
                                <label for="password">Contraseña</label>
                                <input type="password" id="password" name="password"
                                    placeholder="Dejar vacío si no cambia">
                            </div>
                            <div class="form-item">
                                <label for="profile-pic">Foto de perfil</label>
                                <input type="file" id="profile-pic" name="profile-pic" accept="image/*">
                            </div>
                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= $usuario['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="role">Rol</label>
                                <select id="role" name="role" required>
                                    <option value="" disabled>Seleccione un rol</option>
                                    <?php foreach ($roles as $rol): ?>
                                        <option value="<?= $rol['ID_ROL_USUARIO_PK'] ?>"
                                            <?= $usuario['ID_ROL_USUARIO_FK'] == $rol['ID_ROL_USUARIO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($rol['DESCRIPCION_ROL_USUARIO']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn-dark-blue"><strong>Guardar Cambios</strong><i
                                    class="bi bi-floppy2"></i></button>
                        </div>
                    </form>

                </div>
            </section>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOOTER-->
<footer>
    <div class="post-footer" style="background-color: #002557; color: white;">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>
<!--FOOTER-->


</html>
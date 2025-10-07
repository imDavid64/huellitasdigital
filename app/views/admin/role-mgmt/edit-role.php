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
                        <h2><i class="bi bi-pencil-square"></i><strong> Editar Rol</strong></h2>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="/huellitasdigital/app/controllers/admin/roleController.php?action=update" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id_rol" value="<?= $rol['ID_ROL_USUARIO_PK'] ?>">
                        <div class="form-container">
                            <div class="form-item">
                                <label for="rolename">Nombre del rol</label>
                                <input type="text" id="rolename" name="rolename"
                                    value="<?= htmlspecialchars($rol['DESCRIPCION_ROL_USUARIO']) ?>" required>
                            </div>

                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= $rol['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn-dark-blue"><strong>Guardar Cambios</strong></button>
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
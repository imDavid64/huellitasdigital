<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['EMPLEADO', 'ADMINISTRADOR']);
?>


<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/employeeHead.php"; ?>
<!--HEAD-->

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>
            <section class="vet-main-content">
                <!--Breadcrumb-->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeProfile&action=index">Perfil de Usuario</a>
                        </li>
                        <li class="breadcrumb-item current-page">Editar Perfil</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h1><strong>Editar Perfil</strong></h1>
                </div>
                <div class="contentProfile">
                    <form action="<?= BASE_URL ?>/index.php?controller=employeeProfile&action=updateProfile" method="POST"
                        enctype="multipart/form-data">

                        <!-- Imagen actual -->
                        <input type="hidden" name="current_user_image_url"
                            value="<?= htmlspecialchars($usuario['USUARIO_IMAGEN_URL'] ?? '') ?>">

                        <div class="editProfile">
                            <h3>Información Personal</h3>

                            <!-- Imagen de perfil -->
                            <div class="profileImg">
                                <img class="image-preview" src="<?= !empty($usuario['USUARIO_IMAGEN_URL'])
                                    ? htmlspecialchars($usuario['USUARIO_IMAGEN_URL'])
                                    : BASE_URL . '/public/assets/images/default-user-image.png' ?>"
                                    alt="Foto de perfil">
                            </div>

                            <div class="form-item">
                                <input type="file" class="image-input" name="userImage" accept="image/*">
                            </div>

                            <div class="form-item">
                                <label>Nombre completo</label>
                                <input type="text" name="usuario_nombre"
                                    value="<?= htmlspecialchars($usuario['USUARIO_NOMBRE'] ?? '') ?>" required>
                            </div>

                            <div class="form-item">
                                <label>Identificación</label>
                                <input type="text" name="usuario_identificacion"
                                    value="<?= htmlspecialchars($usuario['USUARIO_IDENTIFICACION'] ?? '') ?>"
                                    maxlength="9" pattern="\d{9}" inputmode="numeric" placeholder="Ej: 301020456"
                                    required>
                            </div>

                            <div hidden class="form-item">
                                <label>Cuenta Bancaria</label>
                                <input type="number" name="usuario_cuenta_bancaria">
                            </div>

                            <div class="form-item">
                                <label>Teléfono</label>
                                <input type="text" name="usuario_telefono"
                                    value="<?= htmlspecialchars($usuario['TELEFONO_CONTACTO'] ?? '') ?>" maxlength="8"
                                    pattern="\d{8}" inputmode="numeric" placeholder="Ej: 88888888" required>
                            </div>

                            <hr>

                            <h3>Dirección</h3>

                            <!-- PROVINCIA -->
                            <div class="form-item">
                                <label for="provincia">Provincia</label>
                                <select id="provincia" name="provincia">
                                    <option value="" disabled <?= empty($usuario['ID_DIRECCION_PROVINCIA_FK']) ? 'selected' : '' ?>>
                                        Selecciona una Provincia
                                    </option>
                                    <?php foreach ($provincias as $provincia): ?>
                                        <option value="<?= htmlspecialchars($provincia['ID_DIRECCION_PROVINCIA_PK']) ?>"
                                            <?= (isset($usuario['ID_DIRECCION_PROVINCIA_FK']) && $usuario['ID_DIRECCION_PROVINCIA_FK'] == $provincia['ID_DIRECCION_PROVINCIA_PK']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($provincia['NOMBRE_PROVINCIA']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- CANTÓN -->
                            <div class="form-item">
                                <label for="canton">Cantón</label>
                                <select id="canton" name="canton">
                                    <option value="" disabled <?= empty($usuario['ID_DIRECCION_CANTON_FK']) ? 'selected' : '' ?>>
                                        Selecciona un Cantón
                                    </option>
                                    <?php foreach ($cantones as $canton): ?>
                                        <option value="<?= htmlspecialchars($canton['ID_DIRECCION_CANTON_PK']) ?>"
                                            <?= (isset($usuario['ID_DIRECCION_CANTON_FK']) && $usuario['ID_DIRECCION_CANTON_FK'] == $canton['ID_DIRECCION_CANTON_PK']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($canton['NOMBRE_CANTON']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- DISTRITO -->
                            <div class="form-item">
                                <label for="distrito">Distrito</label>
                                <select id="distrito" name="distrito">
                                    <option value="" disabled <?= empty($usuario['ID_DIRECCION_DISTRITO_FK']) ? 'selected' : '' ?>>
                                        Selecciona un Distrito
                                    </option>
                                    <?php foreach ($distritos as $distrito): ?>
                                        <option value="<?= htmlspecialchars($distrito['ID_DIRECCION_DISTRITO_PK']) ?>"
                                            <?= (isset($usuario['ID_DIRECCION_DISTRITO_FK']) && $usuario['ID_DIRECCION_DISTRITO_FK'] == $distrito['ID_DIRECCION_DISTRITO_PK']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($distrito['NOMBRE_DISTRITO']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- SEÑAS -->
                            <div class="form-item">
                                <label for="senas">Señas Exactas</label>
                                <textarea id="senas" name="senas"
                                    rows="3"><?= htmlspecialchars($usuario['DIRECCION_SENNAS'] ?? '') ?></textarea>
                            </div>

                            <!-- Botones -->
                            <div class="editProfile-footer">
                                <button class="btn-blue" type="submit">Guardar cambios</button>
                                <a href="<?= BASE_URL ?>/index.php?controller=employeeProfile&action=index"
                                    class="btn-black">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </section>
    </main>
    <!--FOOTER-->
    <footer>
        <div class="post-footer" style="background-color: #002557; color: white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>
    <!--FOOTER-->
</body>

</html>
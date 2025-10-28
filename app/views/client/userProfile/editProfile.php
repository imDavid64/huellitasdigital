<?php
//NO QUITAR//
require_once __DIR__ . '/../../../config/bootstrap.php';
//NO QUITAR//
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>/public/js/script.js"></script>
</head>

<body>
    <!--HEADER-->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--Breadcrumb-->
    <nav class="breadcrumbs-container-client">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/huellitasdigital/index.php?controller=home&action=index">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a href="profile.html">Perfil de Usuario</a>
            </li>
            <li class="breadcrumb-item current-page">Editar Usuario</li>
        </ol>
    </nav>

    <main>
        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Editar Perfil</strong></h1>
                </div>
                <div class="contentProfile">
                    <form action="<?= BASE_URL ?>/index.php?controller=user&action=updateProfile" method="POST"
                        enctype="multipart/form-data">

                        <!-- Imagen actual -->
                        <input type="hidden" name="current_user_image_url"
                            value="<?= htmlspecialchars($usuario['USUARIO_IMAGEN_URL'] ?? '') ?>">

                        <div class="editProfile">
                            <h3>Información Personal</h3>

                            <!-- Imagen de perfil -->
                            <div class="profileImg">
                                <img class="image-preview"
                                    src="<?= htmlspecialchars($usuario['USUARIO_IMAGEN_URL'] ?? BASE_URL . '/public/assets/images/default-user-image.png') ?>"
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
                                <a href="<?= BASE_URL ?>/index.php?controller=user&action=index"
                                    class="btn-black">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>

<!--FOODER-->
<?php require_once __DIR__ . "/../partials/fooder.php"; ?>
<!--FOODER-->

</html>
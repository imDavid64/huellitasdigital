<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/huellitasdigital/public/css/style.css">
    <link rel="stylesheet" href="/huellitasdigital/public/assets/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/huellitasdigital/public/js/script.js"></script>
</head>

<body>
    <!--HEADER-->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--Breadcrumb-->
    <nav class="breadcrumbs-container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/huellitasdigital/app/controllers/homeController.php?action=index">Inicio</a>
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
                    <div class="editProfile">
                        <form action="/huellitasdigital/app/controllers/client/userController.php?action=updateProfile"
                            method="POST" enctype="multipart/form-data">

                            <img src="<?= htmlspecialchars($usuario['USUARIO_IMAGEN_URL'] ?? 'ruta/a/imagen/default.png') ?>"
                                alt="Foto de perfil">
                            <input type="file" name="imagenFile" accept="image/*">

                            <label>Nombre completo</label>
                            <input type="text" name="usuario_nombre"
                                value="<?= htmlspecialchars($usuario['USUARIO_NOMBRE'] ?? '') ?>">

                            <label>Identificación</label>
                            <input type="number" name="usuario_identificacion"
                                value="<?= htmlspecialchars($usuario['USUARIO_IDENTIFICACION'] ?? '') ?>">

                            <div hidden>
                                <label>Cuenta Bancaria (IBAN)</label>
                                <input type="text" name="usuario_cuenta_bancaria"
                                    value="<?= htmlspecialchars($usuario['USUARIO_CUENTA_BANCARIA'] ?? '') ?>">
                            </div>

                            <label>Teléfono</label>
                            <input type="number" name="usuario_telefono"
                                value="<?= htmlspecialchars($usuario['TELEFONO_CONTACTO'] ?? '') ?>">

                            <hr>
                            <h3>Dirección</h3>
                            <div hidden>
                                <label>Provincia (ID)</label>
                                <input type="number" name="id_provincia"
                                    value="<?= htmlspecialchars($usuario['ID_PROVINCIA_FK'] ?? '1') ?>">

                                <label>Cantón (ID)</label>
                                <input type="number" name="id_canton"
                                    value="<?= htmlspecialchars($usuario['ID_CANTON_FK'] ?? '1') ?>">

                                <label>Distrito (ID)</label>
                                <input type="number" name="id_distrito"
                                    value="<?= htmlspecialchars($usuario['ID_DISTRITO_FK'] ?? '1') ?>">
                            </div>
                            <label>Señas exactas</label>
                            <textarea
                                name="direccion_senas"><?= htmlspecialchars($usuario['DIRECCION_SENNAS'] ?? '') ?></textarea>


                            <button type="submit">Guardar cambios</button>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

<!--FOODER-->
<?php require_once __DIR__ . "/../partials/fooder.php"; ?>
<!--FOODER-->

</html>
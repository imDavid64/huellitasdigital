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
            <li class="breadcrumb-item current-page">Perfil de Usuario</li>
        </ol>
    </nav>

    <main>

        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Perfil de Usuario</strong></h1>
                </div>
                <div class="contentProfile">
                    <?php if ($usuario): ?>
                        <div class="infoProfile">
                            <div class="profileImgContainer">
                                <?php if (!empty($usuario['USUARIO_IMAGEN_URL'])): ?>
                                    <img src="<?= htmlspecialchars($usuario['USUARIO_IMAGEN_URL']) ?>" alt="Foto de perfil"
                                        class="profileImg">
                                <?php else: ?>
                                    <div class="profileImg"><i class="bi bi-person-fill"></i></div>
                                <?php endif; ?>
                            </div>

                            <div class="profileInfo">
                                <div class="btnEditUser">
                                    <a class="btn-blue"
                                        href="../../../app/controllers/client/userController.php?action=edit&id=<?= $usuario['ID_USUARIO_PK'] ?>">
                                        <i class="bi bi-pencil-fill"></i> Editar
                                    </a>
                                </div>

                                <div>
                                    <h3>Nombre</h3>
                                    <span class="profileInfoBox"><?= htmlspecialchars($usuario['USUARIO_NOMBRE']) ?></span>
                                </div>

                                <div>
                                    <h3>Correo Electrónico</h3>
                                    <span class="profileInfoBox"><?= htmlspecialchars($usuario['USUARIO_CORREO']) ?></span>
                                </div>

                                <div>
                                    <h3>Teléfono</h3>
                                    <span
                                        class="profileInfoBox"><?= htmlspecialchars($usuario['TELEFONO_CONTACTO'] ?? 'No registrado') ?></span>
                                </div>

                                <div>
                                    <h3>Dirección</h3>
                                    <span class="profileInfoBox">
                                        <?= htmlspecialchars(($usuario['DIRECCION_SENNAS'] ?? '') .
                                            ', ' . ($usuario['NOMBRE_DISTRITO'] ?? '') .
                                            ', ' . ($usuario['NOMBRE_CANTON'] ?? '') .
                                            ', ' . ($usuario['NOMBRE_PROVINCIA'] ?? '')) ?>
                                    </span>
                                </div>

                                <hr>
                                <div>
                                    <div class="btnEditUser">
                                        <a class="btn-blue"
                                            href="../../../app/controllers/client/userController.php?action=edit&id=<?= $usuario['ID_USUARIO_PK'] ?>">
                                            <i class="bi bi-pencil-fill"></i> Agregar Método de Pago
                                        </a>
                                    </div>
                                    <div>
                                        <h3>Métodos de Pago</h3>
                                        <span class="profileInfoBox">No disponible</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    </main>
</body>

<!--FOODER-->
<?php require_once __DIR__ . "/../partials/fooder.php"; ?>
<!--FOODER-->

</html>
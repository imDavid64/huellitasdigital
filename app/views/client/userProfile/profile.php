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
                                <div class="profileImg">
                                    <img src="<?= htmlspecialchars($usuario['USUARIO_IMAGEN_URL'] ?? '/huellitasdigital/public/assets/images/default-user-image.png') ?>"
                                        alt="Foto de perfil">
                                </div>
                            </div>
                            <div class="profileInfo">
                                <div class="btnEditUser">
                                    <div>
                                        <h2>Información Personal</h2>
                                    </div>
                                    <div>
                                        <a class="btn-blue"
                                            href="../../../app/controllers/client/userController.php?action=edit&id=<?= $usuario['ID_USUARIO_PK'] ?>">
                                            Editar Perfil<i class="bi bi-pencil-fill"></i></a>
                                    </div>
                                </div>
                                <div class="profileInfoBox">
                                    <strong>Nombre</strong>
                                    <span><?= htmlspecialchars($usuario['USUARIO_NOMBRE']) ?></span>
                                </div>

                                <div class="profileInfoBox">
                                    <strong>Correo Electrónico</strong>
                                    <span><?= htmlspecialchars($usuario['USUARIO_CORREO']) ?></span>
                                </div>

                                <div class="profileInfoBox">
                                    <strong>Teléfono</strong>
                                    <span><?= htmlspecialchars($usuario['TELEFONO_CONTACTO'] ?? 'No registrado') ?></span>
                                </div>

                                <div class="profileInfoBox">
                                    <strong>Dirección</strong>
                                    <span>
                                        <?php
                                        if (
                                            empty($usuario['DIRECCION_SENNAS']) &&
                                            empty($usuario['NOMBRE_DISTRITO']) &&
                                            empty($usuario['NOMBRE_CANTON']) &&
                                            empty($usuario['NOMBRE_PROVINCIA'])
                                        ) {
                                            echo "No registrado";
                                        } else {
                                            echo htmlspecialchars(
                                                ($usuario['DIRECCION_SENNAS'] ?? '') . ', ' .
                                                ($usuario['NOMBRE_DISTRITO'] ?? '') . ', ' .
                                                ($usuario['NOMBRE_CANTON'] ?? '') . ', ' .
                                                ($usuario['NOMBRE_PROVINCIA'] ?? '')
                                            );
                                        }
                                        ?>
                                    </span>
                                </div>
                                <hr>
                                <div>
                                    <div class="btnEditUser">
                                        <div>
                                            <h2>Metodos de Pago</h2>
                                        </div>
                                        <div>
                                            <a class="btn-blue"
                                                href="../../../app/controllers/client/paymentMethodControler.php?action=addpaymentMethod&id=<?= $usuario['ID_USUARIO_PK'] ?>">
                                                Agregar Metodo de Pago</a>
                                        </div>
                                    </div>
                                    <div class="methodPay-item">
                                        <span>No disponible</span>
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
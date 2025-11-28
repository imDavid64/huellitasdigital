<?php
//NO QUITAR//
require_once __DIR__ . '/../../../config/bootstrap.php';
//NO QUITAR//
?>

<script>
    window.Huellitas = {
        correoUsuario: "<?= $correoUsuario ?>",
        usuarioId: <?= $idUsuario ?>,
        codigoUsuario: "<?= $_SESSION['user_code'] ?>",
        mostrarVinculacion:
            <?= ($estadoActivo && $clienteVetExiste && !$yaVinculado) ? 'true' : 'false' ?>,
        baseUrl: "<?= BASE_URL ?>"
    };
</script>
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
    <!-- SweetAlert2 local -->
    <script src="<?= BASE_URL ?>/public/js/libs/sweetalert2.all.min.js"></script>
    <!-- JQuery y script.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>/public/js/script.js"></script>
</head>

<body>
    <!--HEADER-->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <!--Breadcrumb-->
        <nav class="breadcrumbs-container-client">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a>
                </li>
                <li class="breadcrumb-item current-page">
                    Mis Mascotas
                </li>
            </ol>
        </nav>
        <section class="main-content">
            <div>
                <div class="tittles">
                    <h1><strong>Mis Mascotas 🐾</strong></h1>
                    <div>
                        <a href="<?= BASE_URL ?>/index.php?controller=appointment&action=index"
                            class="btn-dark-blue">Agendar Cita<i class="bi bi-calendar4-week"></i></a>
                    </div>
                </div>
                <div class="my-pets-list">
                    <?php if (!empty($mascotas)): ?>
                        <?php foreach ($mascotas as $pet): ?>
                            <div class="my-pet-card">
                                <div>
                                    <div class="my-pet-card-content">
                                        <div class="pet-info">
                                            <h3><strong><?= htmlspecialchars($pet['NOMBRE_MASCOTA']) ?></strong></h3>
                                            <span class="pet-type"><strong>Especie:</strong>
                                                <?= htmlspecialchars($pet['ESPECIE']) ?></span>
                                            <span class="pet-type"><strong>Nacimiento:</strong>
                                                <?= htmlspecialchars($pet['FECHA_NACIMIENTO']) ?></span>
                                            <span class="pet-breed"><strong>Raza:</strong>
                                                <?= htmlspecialchars($pet['RAZA'] ?? 'No especificada') ?></span>
                                        </div>
                                        <div class="pet-img">
                                            <?php if (!empty($pet['MASCOTA_IMAGEN_URL'])): ?>
                                                <img src="<?= htmlspecialchars($pet['MASCOTA_IMAGEN_URL']) ?>">
                                            <?php else: ?>
                                                <img src="<?= BASE_URL ?>/public/assets/images/default-pet-image.jpg">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= BASE_URL ?>/index.php?controller=pets&action=details&codigo=<?= $pet['CODIGO_MASCOTA'] ?>"
                                    class="btn-green my-pet-card-button">Ver Detalles</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center mt-4">No tienes mascotas registradas todavía 🐶🐱</p>
                    <?php endif; ?>
                </div>
                <?php if ($estadoActivo && $clienteVetExiste && !$yaVinculado): ?>
                    <div class="alert alert-info mt-3 d-flex justify-content-between align-items-center">
                        <span>
                            🔗 Hemos detectado que ya eras cliente de Veterinaria.<br>
                            ¿Deseas vincular tus datos y mascotas?
                        </span>
                        <button id="btnVincularCuenta" class="btn btn-dark-blue">
                            Vincular Datos <i class="bi bi-link-45deg ms-2"></i>
                        </button>
                    </div>
                <?php endif; ?>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->

    <!--FOODER-->
    <?php require_once __DIR__ . "/../partials/fooder.php"; ?>
    <!--FOODER-->
</body>


</html>
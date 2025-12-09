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
                        <li class="breadcrumb-item current-page">Perfil de Usuario</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h1><strong>Perfil de Usuario</strong></h1>
                </div>
                <div class="contentProfile">
                    <?php if ($usuario): ?>
                        <div class="infoProfileAdmin">
                            <div class="profileImgContainer">
                                <div class="profileImg">
                                    <img src="<?= !empty($usuario['USUARIO_IMAGEN_URL'])
                                        ? htmlspecialchars($usuario['USUARIO_IMAGEN_URL'])
                                        : BASE_URL . '/public/assets/images/default-user-image.png' ?>"
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
                                            href="<?= BASE_URL ?>/index.php?controller=employeeProfile&action=edit&id=<?= $usuario['ID_USUARIO_PK'] ?>">
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
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                </div>
            </section>
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
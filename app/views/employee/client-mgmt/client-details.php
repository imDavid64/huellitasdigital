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
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-person-vcard"></i><strong> Detalles de Cliente</strong></h2>
                    </div>
                </div>
                <div class="client-container">
                    <div class="vet-main-content">
                        <div class="client-vet-info-content">
                            <div class="vet-client-container">
                                <div class="subtittles">
                                    <h3>Información del Cliente</h3>
                                    <div>
                                        <?php if (strtoupper($cliente['TIPO']) === 'USUARIO'): ?>
                                            <button type="button" class="btn btn-blue btn-sm" disabled
                                                title="No se puede editar un usuario.">
                                                <strong>Editar Cliente</strong> <i class="bi bi-lock-fill"></i>
                                            </button>
                                        <?php else: ?>
                                            <a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=edit&codigo=<?= urlencode($cliente['CODIGO']) ?>"
                                                class="btn btn-purple btn-sm">
                                                <strong>Editar Cliente</strong> <i class="bi bi-pencil-square"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="vet-client-info">
                                    <div class="vet-client-info-container">
                                        <span><strong>Nombre: </strong>
                                            <?= htmlspecialchars($cliente['NOMBRE']) ?></span>
                                        <span><strong>Cédula: </strong>
                                            <?= htmlspecialchars($cliente['IDENTIFICACION']) ?></span>
                                        <span><strong>Correo: </strong>
                                            <?= htmlspecialchars($cliente['CORREO']) ?></span>
                                    </div>
                                    <div class="vet-client-info-container">
                                        <?php
                                        // Construir dirección solo con los campos existentes
                                        $partesDireccion = [];

                                        if (!empty($cliente['DIRECCION']) && strtoupper($cliente['DIRECCION']) !== 'NO REGISTRADA') {
                                            $partesDireccion[] = htmlspecialchars($cliente['DIRECCION']);
                                        }
                                        if (!empty($cliente['DISTRITO'])) {
                                            $partesDireccion[] = htmlspecialchars($cliente['DISTRITO']);
                                        }
                                        if (!empty($cliente['CANTON'])) {
                                            $partesDireccion[] = htmlspecialchars($cliente['CANTON']);
                                        }
                                        if (!empty($cliente['PROVINCIA'])) {
                                            $partesDireccion[] = htmlspecialchars($cliente['PROVINCIA']);
                                        }

                                        // Si no hay partes, mostrar "No registrada"
                                        $direccionFinal = !empty($partesDireccion)
                                            ? implode(', ', $partesDireccion)
                                            : 'No registrada';
                                        ?>
                                        <span><strong>Dirección: </strong>
                                            <?= $direccionFinal ?></span>
                                        <span><strong>Teléfono: </strong>
                                            <?= htmlspecialchars($cliente['TELEFONO']) ?></span>
                                        <div class="d-flex row" style="width: 80px"><strong>Tipo: </strong>
                                            <p style="margin-left: 0.8rem;"
                                                class="badge mt-1 <?= $cliente['TIPO'] === 'USUARIO' ? 'bg-info' : 'bg-success' ?>">
                                                <?= htmlspecialchars($cliente['TIPO']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vet-pet-list-table">
                                <div class="subtittles">
                                    <h3>Mascotas</h3>
                                    <div>
                                        <?php if (strtoupper($cliente['TIPO']) === 'USUARIO'): ?>
                                            <!-- 👇 Cuando el propietario es un USUARIO -->
                                            <a href="<?= BASE_URL ?>/index.php?controller=employeePet&action=create&usuario=<?= urlencode($cliente['CODIGO']) ?>"
                                                class="btn-green btn-sm">
                                                <strong>Agregar Mascota</strong> <i class="bi bi-patch-plus-fill"></i>
                                            </a>
                                        <?php else: ?>
                                            <!-- 👇 Cuando el propietario es un CLIENTE -->
                                            <a href="<?= BASE_URL ?>/index.php?controller=employeePet&action=create&cliente=<?= urlencode($cliente['CODIGO']) ?>"
                                                class="btn-green btn-sm">
                                                <strong>Agregar Mascota</strong> <i class="bi bi-patch-plus-fill"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">Cod Mascota</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Especie</th>
                                            <th scope="col">Raza</th>
                                            <th style="" scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php if (empty($mascotas)): ?>
                                            <tr>
                                                <td colspan="5">Sin mascotas registradas.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($mascotas as $m): ?>
                                                <tr>
                                                    <td><?= $m['CODIGO_MASCOTA'] ?></td>
                                                    <td><?= htmlspecialchars($m['NOMBRE_MASCOTA']) ?></td>
                                                    <td><?= htmlspecialchars($m['ESPECIE']) ?></td>
                                                    <td><?= htmlspecialchars($m['RAZA']) ?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= BASE_URL ?>/index.php?controller=employeePet&action=details&codigo=<?= urlencode($m['CODIGO_MASCOTA']) ?>"
                                                                class="btn btn-blue btn-sm">Ver Mascota <i
                                                                    class="bi bi-pencil-square"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
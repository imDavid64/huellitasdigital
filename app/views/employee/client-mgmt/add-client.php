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
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employee&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=index">Gestión de
                                Clientes</a>
                        </li>
                        <li class="breadcrumb-item current-page">Agregar Cliente</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-person-fill-add"></i><strong> Agregar Usuario</strong></h2>
                </div>
                <div class="employee-form-container">
                    <form action="<?= BASE_URL ?>/index.php?controller=employeeClient&action=store" id="addClientForm"
                        method="POST" enctype="multipart/form-data">
                        <div class="form-container">
                            <div class="form-item">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" name="cliente_nombre" class="form-control" required>
                            </div>

                            <div class="form-item">
                                <label class="form-label">Correo electrónico</label>
                                <input type="email" name="cliente_correo" class="form-control" required>
                            </div>

                            <div class="form-item">
                                <label class="form-label">Identificación</label>
                                <input type="text" name="cliente_identificacion" class="form-control" required>
                            </div>

                            <div class="form-item">
                                <label class="form-label">Teléfono</label>
                                <input type="number" name="telefono_id" class="form-control" required>
                            </div>

                            <div class="form-item">
                                <label>Provincia (opcional)</label>
                                <select id="provincia" name="provincia" class="form-select">
                                    <option value="">Seleccione una provincia</option>
                                    <?php foreach ($provincias as $p): ?>
                                        <option value="<?= $p['ID_DIRECCION_PROVINCIA_PK'] ?>"
                                            <?= ($user['ID_DIRECCION_PROVINCIA_FK'] ?? 0) == $p['ID_DIRECCION_PROVINCIA_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['NOMBRE_PROVINCIA']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label>Cantón (opcional)</label>
                                <select id="canton" name="canton" class="form-select">
                                    <option value="">Seleccione un cantón</option>
                                    <?php foreach ($cantones as $c): ?>
                                        <option value="<?= $c['ID_DIRECCION_CANTON_PK'] ?>"
                                            <?= ($user['ID_DIRECCION_CANTON_FK'] ?? 0) == $c['ID_DIRECCION_CANTON_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['NOMBRE_CANTON']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label>Distrito (opcional)</label>
                                <select id="distrito" name="distrito" class="form-select">
                                    <option value="">Seleccione un distrito</option>
                                    <?php foreach ($distritos as $d): ?>
                                        <option value="<?= $d['ID_DIRECCION_DISTRITO_PK'] ?>"
                                            <?= ($user['ID_DIRECCION_DISTRITO_FK'] ?? 0) == $d['ID_DIRECCION_DISTRITO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($d['NOMBRE_DISTRITO']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-item">
                                <label for="senas">Señas Exactas (opcional)</label>
                                <textarea id="senas" name="senas"
                                    rows="3"><?= htmlspecialchars($usuario['DIRECCION_SENNAS'] ?? '') ?></textarea>
                            </div>

                            <div class="form-item">
                                <label class="form-label">Observaciones (opcional)</label>
                                <textarea name="cliente_observaciones" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="form-item">
                                <label class="form-label">Estado</label>
                                <select name="estado_id" class="form-select" required>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"><?= $estado['ESTADO_DESCRIPCION'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn-blue">
                                <strong>Agregar Cliente</strong> <i class="bi bi-person-fill-add"></i>
                            </button>
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
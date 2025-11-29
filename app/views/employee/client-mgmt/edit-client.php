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
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=index">Gestión de
                                Clientes</a>
                        </li>
                        <li class="breadcrumb-item current-page">Editar Cliente</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-person-fill-add"></i><strong> Editar Cliente</strong></h2>
                </div>
                <div class="employee-form-container">
                    <form action="<?= BASE_URL ?>/index.php?controller=employeeClient&action=update" 
                          id="editClientForm" method="POST" enctype="multipart/form-data">

                        <!-- IDs ocultos -->
                        <input type="hidden" name="codigo_cliente" value="<?= htmlspecialchars($cliente['CODIGO']) ?>">
                        <input type="hidden" name="direccion_id" value="<?= htmlspecialchars($cliente['ID_DIRECCION'] ?? 0) ?>">
                        <input type="hidden" name="telefono_id" value="<?= htmlspecialchars($cliente['ID_TELEFONO'] ?? 0) ?>">

                        <div class="form-container">
                            <!-- Nombre -->
                            <div class="form-item">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" name="cliente_nombre" class="form-control" 
                                    value="<?= htmlspecialchars($cliente['NOMBRE']) ?>" required>
                            </div>

                            <!-- Correo (no editable) -->
                            <div class="form-item">
                                <label class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" 
                                    value="<?= htmlspecialchars($cliente['CORREO']) ?>" disabled>
                            </div>

                            <!-- Identificación -->
                            <div class="form-item">
                                <label class="form-label">Identificación</label>
                                <input type="text" name="cliente_identificacion" class="form-control"
                                    value="<?= htmlspecialchars($cliente['IDENTIFICACION'] ?? '') ?>">
                            </div>

                            <!-- Teléfono -->
                            <div class="form-item">
                                <label class="form-label">Teléfono</label>
                                <input type="number" name="telefono_id" class="form-control"
                                    value="<?= htmlspecialchars($cliente['TELEFONO'] ?? '') ?>" required>
                            </div>

                            <!-- Provincia -->
                            <div class="form-item">
                                <label>Provincia (opcional)</label>
                                <select id="provincia" name="provincia" class="form-select">
                                    <option value="">Seleccione una provincia</option>
                                    <?php foreach ($provincias as $p): ?>
                                        <option value="<?= $p['ID_DIRECCION_PROVINCIA_PK'] ?>"
                                            <?= ($cliente['PROVINCIA'] ?? '') === $p['NOMBRE_PROVINCIA'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['NOMBRE_PROVINCIA']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Cantón -->
                            <div class="form-item">
                                <label>Cantón (opcional)</label>
                                <select id="canton" name="canton" class="form-select">
                                    <option value="">Seleccione un cantón</option>
                                    <?php foreach ($cantones as $c): ?>
                                        <option value="<?= $c['ID_DIRECCION_CANTON_PK'] ?>"
                                            <?= ($cliente['CANTON'] ?? '') === $c['NOMBRE_CANTON'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['NOMBRE_CANTON']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Distrito -->
                            <div class="form-item">
                                <label>Distrito (opcional)</label>
                                <select id="distrito" name="distrito" class="form-select">
                                    <option value="">Seleccione un distrito</option>
                                    <?php foreach ($distritos as $d): ?>
                                        <option value="<?= $d['ID_DIRECCION_DISTRITO_PK'] ?>"
                                            <?= ($cliente['DISTRITO'] ?? '') === $d['NOMBRE_DISTRITO'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($d['NOMBRE_DISTRITO']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Señas -->
                            <div class="form-item">
                                <label for="senas">Señas exactas (opcional)</label>
                                <textarea id="senas" name="senas" rows="3"><?= htmlspecialchars($cliente['DIRECCION'] ?? '') ?></textarea>
                            </div>

                            <!-- Observaciones -->
                            <div class="form-item">
                                <label class="form-label">Observaciones (opcional)</label>
                                <textarea name="cliente_observaciones" class="form-control" rows="2"><?= htmlspecialchars($cliente['OBSERVACIONES'] ?? '') ?></textarea>
                            </div>

                            <!-- Estado -->
                            <div class="form-item">
                                <label class="form-label">Estado</label>
                                <select name="estado_id" class="form-select" required>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>" 
                                            <?= ($cliente['ESTADO'] == $estado['ESTADO_DESCRIPCION']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Botón -->
                            <button type="submit" class="btn-blue">
                                <strong>Guardar Cambios</strong> <i class="bi bi-check-circle-fill"></i>
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
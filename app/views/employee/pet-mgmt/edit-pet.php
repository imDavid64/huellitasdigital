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
                <!-- Breadcrumbs -->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=index">Gestión de
                                Clientes</a>
                        </li>
                        <li class="breadcrumb-item current-page">Editar Mascota</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-person-fill-add"></i><strong> Editar Mascota</strong></h2>
                </div>
                <div class="employee-form-container">
                    <form action="<?= BASE_URL ?>/index.php?controller=employeePet&action=update" id="editPetForm"
                        method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="codigo_mascota"
                            value="<?= htmlspecialchars($mascota['CODIGO_MASCOTA']) ?>">
                        <input type="hidden" id="raza_actual"
                            value="<?= htmlspecialchars($mascota['ID_MASCOTA_RAZA_FK']) ?>">
                        <input type="hidden" name="current_image_url" value="<?= $mascota['MASCOTA_IMAGEN_URL'] ?>">


                        <div class="form-container">

                            <!-- Nombre -->
                            <div class="form-item">
                                <label class="form-label">Nombre de la Mascota</label>
                                <input type="text" name="nombre_mascota" class="form-control" required
                                    value="<?= htmlspecialchars($mascota['NOMBRE_MASCOTA']) ?>">
                            </div>

                            <!-- Nueva Imagen -->
                            <div class="form-item">
                                <label class="form-label">Nueva foto de mascota</label>
                                <input type="file" name="imagen_file" accept="image/*">
                                <small class="text-muted">Si sube una nueva imagen se reemplazará la actual.</small>
                            </div>

                            <!-- Fecha nacimiento -->
                            <div class="form-item">
                                <label class="form-label">Fecha de nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-control" required
                                    value="<?= htmlspecialchars($mascota['FECHA_NACIMIENTO']) ?>">
                            </div>

                            <!-- Género -->
                            <div class="form-item">
                                <label class="form-label">Género</label>
                                <select name="genero" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="MACHO" <?= $mascota['GENERO'] == 'MACHO' ? 'selected' : '' ?>>Macho
                                    </option>
                                    <option value="HEMBRA" <?= $mascota['GENERO'] == 'HEMBRA' ? 'selected' : '' ?>>Hembra
                                    </option>
                                </select>
                            </div>

                            <!-- Especie -->
                            <div class="form-item">
                                <label class="form-label">Especie</label>
                                <select name="especie_id" id="especie" class="form-select" required>
                                    <option value="">Seleccione especie</option>
                                    <?php foreach ($especies as $e): ?>
                                        <option value="<?= $e['ID_MASCOTA_ESPECIE_PK'] ?>"
                                            <?= ($mascota['ESPECIE'] === $e['NOMBRE_ESPECIE']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($e['NOMBRE_ESPECIE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">

                                <!-- Buscador -->
                                <div class="form-item">
                                    <label class="form-label">Buscar Raza</label>
                                    <input type="text" id="buscar_raza" class="form-control"
                                        placeholder="Escriba para buscar...">
                                </div>

                                <!-- Raza -->
                                <div class="form-item" style="width: 500px;">
                                    <label class="form-label">Raza</label>
                                    <select name="raza_id" id="raza" class="form-select" required>
                                        <option value="">Seleccione raza</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="form-item">
                                <label class="form-label">Estado</label>
                                <select name="estado_id" class="form-select" required>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= ($mascota['ESTADO'] === $estado['ESTADO_DESCRIPCION']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Botón -->
                            <button type="submit" class="btn-blue mt-3">
                                <strong>Actualizar Mascota</strong>
                                <i class="bi bi-save-fill"></i>
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
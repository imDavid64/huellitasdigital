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
                            <a href="<?= BASE_URL ?>/index.php?controller=employee&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=index">Gestión de
                                Clientes</a>
                        </li>
                        <li class="breadcrumb-item current-page">Agregar Mascota</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-person-fill-add"></i><strong> Agregar Usuario</strong></h2>
                </div>
                <div class="employee-form-container">
                    <form action="<?= BASE_URL ?>/index.php?controller=employeePet&action=store" id="addPetForm"
                        method="POST" enctype="multipart/form-data">

                        <div class="form-container">

                            <!-- DUEÑO (oculto y obligatorio) -->
                            <?php if ($tipoPropietario === 'CLIENTE'): ?>
                                <input type="hidden" name="codigo_cliente" value="<?= htmlspecialchars($codigoCliente) ?>">
                            <?php else: ?>
                                <input type="hidden" name="codigo_usuario" value="<?= htmlspecialchars($codigoUsuario) ?>">
                            <?php endif; ?>

                            <!-- Nombre de la mascota -->
                            <div class="form-item">
                                <label class="form-label">Nombre de la Mascota</label>
                                <input type="text" name="nombre_mascota" class="form-control" required>
                            </div>

                            <!-- Imagen de la mascota -->
                            <div class="form-item">
                                <label class="form-label">Imagen de la Mascota</label>
                                <input type="file" name="imagen_file" accept="image/*">
                                <small class="text-muted">Puede subir una imagen o dejar solo la URL.</small>
                            </div>

                            <!-- Fecha de nacimiento -->
                            <div class="form-item">
                                <label class="form-label">Fecha de nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-control" required>
                            </div>

                            <!-- Género -->
                            <div class="form-item">
                                <label class="form-label">Género</label>
                                <select name="genero" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="MACHO">Macho</option>
                                    <option value="HEMBRA">Hembra</option>
                                </select>
                            </div>

                            <!-- Especie -->
                            <div class="form-item">
                                <label class="form-label">Especie</label>
                                <select name="especie_id" id="especie" class="form-select" required>
                                    <option value="">Seleccione especie</option>
                                    <?php foreach ($especies as $e): ?>
                                        <option value="<?= $e['ID_MASCOTA_ESPECIE_PK'] ?>">
                                            <?= htmlspecialchars($e['NOMBRE_ESPECIE']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <!-- Buscador de razas -->
                                <div class="form-item">
                                    <label class="form-label">Buscar Raza</label>
                                    <input type="text" id="buscar_raza" class="form-control"
                                        placeholder="Escriba para buscar...">
                                </div>

                                <!-- Raza-->
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
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>">
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Botón guardar -->
                            <button type="submit" class="btn-blue mt-3">
                                <strong>Agregar Mascota</strong>
                                <i class="bi bi-patch-plus-fill"></i>
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
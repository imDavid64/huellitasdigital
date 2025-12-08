<?php
include_once __DIR__ . '/../includes/auth.php';
checkRole(['EMPLEADO', 'ADMINISTRADOR']);
?>
<script>
    const BASE_URL_JS = "<?= BASE_URL ?>";
</script>

<!DOCTYPE html>
<html lang="es">

<?php include_once __DIR__ . "/../partials/employeeHead.php"; ?>

<body>
    <?php include_once __DIR__ . "/../partials/header.php"; ?>

    <main>
        <section class="admin-main">

            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>

            <section class="vet-main-content">

                <!-- Breadcrumb -->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item current-page">Gestión de Expedientes</li>
                    </ol>
                </nav>

                <div class="tittles mb-4">
                    <h2>
                        <i class="bi bi-journal-medical"></i>
                        <strong> Gestión de Expedientes</strong>
                    </h2>
                </div>

                <!-- 🔍 Buscador -->
                <section class="search-section mb-4">
                    <div class="card shadow-sm p-4" style="border-radius: 12px;">
                        <h5 class="mb-3">Buscar Expediente</h5>
                        <div class="input-group header-search-files">
                            <input id="searchExpediente" type="search" class="form-control"
                                placeholder="Buscar por mascota, dueño o código...">
                        </div>
                    </div>
                </section>

                <!-- 📋 Contenedor de Expedientes -->
                <section class="admin-main-content-mgmt">

                    <div id="expedientesContainer" class="row g-4"></div>

                    <!-- 📌 Paginación -->
                    <div class="mt-4">
                        <nav id="paginationNav"></nav>
                    </div>

                </section>
            </section>

        </section>
    </main>

    <footer>
        <div class="post-footer" style="background-color:#002557;color:white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>
</body>

</html>
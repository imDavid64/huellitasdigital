<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--HEAD-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>
<!--HEAD-->

<body>
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>

            <section class="admin-main-content">
                <!--Breadcrumb-->
                <nav class="breadcrumbs-container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=admin&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminSupplier&action=index">Gestión de Proveedores</a>
                        </li>
                        <li class="breadcrumb-item current-page">Agregar Proveedor</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-building-fill-add"></i><strong> Agregar Proveedor</strong></h2>
                </div>
                <div class="admin-form-container">
                    <form id="supplierForm" action="<?= BASE_URL ?>/index.php?controller=adminSupplier&action=store"
                        method="POST" novalidate>

                        <div class="form-container">
                            <div class="form-item">
                                <label for="suppliername">Nombre del Proveedor</label>
                                <input type="text" id="suppliername" name="suppliername" required>
                                <small class="error" id="error-suppliername"></small>
                            </div>

                            <div class="form-item">
                                <label for="suppliercontact">Nombre del Contacto</label>
                                <input type="text" id="suppliercontact" name="suppliercontact" required>
                                <small class="error" id="error-suppliercontact"></small>
                            </div>

                            <div class="form-item">
                                <label for="suppliernumber">Teléfono</label>
                                <input type="text" id="suppliernumber" name="suppliernumber" maxlength="15" required>
                                <small class="error" id="error-suppliernumber"></small>
                            </div>

                            <div class="form-item">
                                <label for="supplieremail">Correo electrónico</label>
                                <input type="email" id="supplieremail" name="supplieremail" required>
                                <small class="error" id="error-supplieremail"></small>
                            </div>

                            <div class="form-item">
                                <label for="supplieraddress">Dirección</label>
                                <input type="text" id="supplieraddress" name="supplieraddress" required>
                                <small class="error" id="error-supplieraddress"></small>
                            </div>

                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>">
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="error" id="error-state"></small>
                            </div>

                            <button type="submit" class="btn-blue">
                                <strong>Agregar Proveedor</strong>
                                <i class="bi bi-building-fill-add"></i>
                            </button>
                        </div>
                    </form>
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

    <!--VALIDACIONES-->
    <script>
        document.getElementById('supplierForm').addEventListener('submit', function (e) {
            let valid = true;

            // Limpiar mensajes previos
            document.querySelectorAll('.error').forEach(err => err.textContent = '');

            const suppliername = document.getElementById('suppliername');
            const suppliercontact = document.getElementById('suppliercontact');
            const suppliernumber = document.getElementById('suppliernumber');
            const supplieremail = document.getElementById('supplieremail');
            const supplieraddress = document.getElementById('supplieraddress');
            const state = document.getElementById('state');

            // Validaciones personalizadas
            if (suppliername.value.trim() === '') {
                document.getElementById('error-suppliername').textContent = 'El nombre del proveedor es obligatorio.';
                valid = false;
            }

            if (suppliercontact.value.trim() === '') {
                document.getElementById('error-suppliercontact').textContent = 'Debe ingresar el nombre del contacto.';
                valid = false;
            }

            if (!/^\d{8,15}$/.test(suppliernumber.value.trim())) {
                document.getElementById('error-suppliernumber').textContent = 'Ingrese un número telefónico válido (solo números, entre 8 y 15 dígitos).';
                valid = false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(supplieremail.value.trim())) {
                document.getElementById('error-supplieremail').textContent = 'Ingrese un correo electrónico válido.';
                valid = false;
            }

            if (supplieraddress.value.trim() === '') {
                document.getElementById('error-supplieraddress').textContent = 'La dirección no puede ir vacía.';
                valid = false;
            }

            if (state.value === '') {
                document.getElementById('error-state').textContent = 'Debe seleccionar un estado.';
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    </script>

    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</body>

</html>
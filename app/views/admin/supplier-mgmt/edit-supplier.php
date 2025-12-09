<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>
<!--HEAD-->

<body data-error="<?= $_SESSION['error'] ?? '' ?>" data-success="<?= $_SESSION['success'] ?? '' ?>">
    <?php unset($_SESSION['error'], $_SESSION['success']); ?>

    <!--Include para el herder-->
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
                            <a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">Inicio</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminSupplier&action=index">Gestión de
                                Proveedores</a>
                        </li>
                        <li class="breadcrumb-item current-page">Editar Proveedor</li>
                    </ol>
                </nav>
                <div class="tittles">
                    <h2><i class="bi bi-pencil-square"></i><strong> Editar Proveedor</strong></h2>
                </div>
                <div class="admin-form-container">
                    <form id="supplierForm" action="<?= BASE_URL ?>/index.php?controller=adminSupplier&action=update"
                        method="POST" novalidate>
                        <input type="hidden" name="id_supplier"
                            value="<?= htmlspecialchars($supplier['ID_PROVEEDOR_PK']) ?>">

                        <div class="form-container">
                            <div class="form-item">
                                <label for="suppliername">Nombre del Proveedor</label>
                                <input type="text" id="suppliername" name="suppliername"
                                    value="<?= htmlspecialchars($supplier['PROVEEDOR_NOMBRE']) ?>" required>
                                <small class="error" id="error-suppliername"></small>
                            </div>

                            <div class="form-item">
                                <label for="suppliercontact">Nombre del Contacto</label>
                                <input type="text" id="suppliercontact" name="suppliercontact"
                                    value="<?= htmlspecialchars($supplier['NOMBRE_REPRESENTANTE']) ?>" required>
                                <small class="error" id="error-suppliercontact"></small>
                            </div>

                            <div class="form-item">
                                <label for="suppliernumber">Teléfono</label>
                                <input type="text" id="suppliernumber" name="suppliernumber"
                                    value="<?= htmlspecialchars($supplier['TELEFONO_CONTACTO']) ?>" required
                                    maxlength="15">
                                <small class="error" id="error-suppliernumber"></small>
                            </div>

                            <div class="form-item">
                                <label for="supplieraddress">Dirección</label>
                                <input type="text" id="supplieraddress" name="supplieraddress"
                                    value="<?= htmlspecialchars($supplier['DIRECCION']) ?>" required>
                                <small class="error" id="error-supplieraddress"></small>
                            </div>

                            <div class="form-item">
                                <label for="supplieremail">Correo electrónico</label>
                                <input type="email" id="supplieremail" name="supplieremail"
                                    value="<?= htmlspecialchars($supplier['PROVEEDOR_CORREO']) ?>" required>
                                <small class="error" id="error-supplieremail"></small>
                            </div>

                            <div class="form-item">
                                <label for="state">Estado</label>
                                <select id="state" name="state" required>
                                    <option value="" disabled>Seleccione un estado</option>
                                    <?php foreach ($estados as $estado): ?>
                                        <option value="<?= $estado['ID_ESTADO_PK'] ?>"
                                            <?= $supplier['ID_ESTADO_FK'] == $estado['ID_ESTADO_PK'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="error" id="error-state"></small>
                            </div>

                            <button type="submit" class="btn-dark-blue">
                                <strong>Guardar Cambios</strong>
                                <i class="bi bi-floppy2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->

    <!--FOOTER-->
    <footer>
        <div class="post-footer" style="background-color: #002557; color: white;">
            <span>&copy; 2025 - Dra Huellitas</span>
        </div>
    </footer>
    <!--FOOTER-->

    <!--VALIDACIONES-->
    <script>
        document.getElementById('supplierForm').addEventListener('submit', function (e) {
            let valid = true;
            document.querySelectorAll('.error').forEach(err => err.textContent = '');

            const suppliername = document.getElementById('suppliername');
            const suppliercontact = document.getElementById('suppliercontact');
            const suppliernumber = document.getElementById('suppliernumber');
            const supplieremail = document.getElementById('supplieremail');
            const supplieraddress = document.getElementById('supplieraddress');
            const state = document.getElementById('state');

            if (suppliername.value.trim() === '') {
                document.getElementById('error-suppliername').textContent = 'El nombre del proveedor es obligatorio.';
                valid = false;
            }

            if (suppliercontact.value.trim() === '') {
                document.getElementById('error-suppliercontact').textContent = 'El nombre del contacto es obligatorio.';
                valid = false;
            }

            if (!/^\d{8,15}$/.test(suppliernumber.value.trim())) {
                document.getElementById('error-suppliernumber').textContent = 'Ingrese un número de teléfono válido (solo números, entre 8 y 15 dígitos).';
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
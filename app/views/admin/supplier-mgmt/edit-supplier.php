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

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <aside class="admin-aside">
                <div class="aside-container">
                    <div class="aside-main">
                        <ul>
                            <li><a href="home.php"><i class="bi bi-opencollective"></i>Dashboard</a></li>
                            <li><a href="user-mgmt.php"><i class="bi bi-people-fill"></i>Gestión de Usuarios</a></li>
                            <li><a href="role-mgmt.php"><i class="bi bi-diagram-2-fill"></i>Gestión de Roles</a></li>
                            <li><a href="supplier-mgmt.php"><i class="bi bi-building-fill"></i>Gestión de Proveedores</a></li>
                            <li><a href="product-mgmt.php"><i class="bi bi-box2-fill"></i>Gestión de productos</a></li>
                            <li><a href="inventory-mgmt.php"><i class="bi bi-clipboard2-check-fill"></i>Gestión de Inventario</a></li>
                            <li><a href="accounting-record.php"><i class="bi bi-calculator-fill"></i>Registro Contable</a></li>
                            <li><a href="order-mgmt.php"><i class="bi bi-cart-fill"></i>Gestión de pedidos</a></li>
                            <li><a href="appointment-mgmt.php"><i class="bi bi-calendar-week-fill"></i>Gestión de citas</a></li>
                            <li><a href="general-settings.php"><i class="bi bi-gear-fill"></i>Configuración general</a></li>
                        </ul>
                    </div>
                    <hr />
                    <div class="aside-footer">
                        <a class="btn-dark-blue" href="../../processes/logout.php"><strong>
                                Cerrar Sesión</strong></a>
                    </div>
                </div>
            </aside>

            <section class="admin-main-content-add-user">
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-pencil-square"></i><strong> Editar Proveedor</strong></h2>
                    </div>
                </div>

                <div class="admin-form-container">
                    <form id="supplierForm"
                          action="/huellitasdigital/app/controllers/admin/supplierController.php?action=update"
                          method="POST"
                          novalidate>
                        <input type="hidden" name="id_supplier" value="<?= htmlspecialchars($supplier['ID_PROVEEDOR_PK']) ?>">

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
                                    value="<?= htmlspecialchars($supplier['TELEFONO_CONTACTO']) ?>" required maxlength="15">
                                <small class="error" id="error-suppliernumber"></small>
                            </div>

                            <div class="form-item">
                                <label for="supplieraddress">Dirección</label>
                                <input type="text" id="supplieraddress" name="supplieraddress"
                                    value="<?= htmlspecialchars($supplier['DIRECCION_SENNAS']) ?>" required>
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

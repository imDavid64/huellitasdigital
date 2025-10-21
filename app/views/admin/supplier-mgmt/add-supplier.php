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
                <div class="tittles">
                    <h2><i class="bi bi-building-fill-add"></i><strong> Agregar Proveedor</strong></h2>
                </div>

                <div class="admin-form-container">
                    <form id="supplierForm" 
                          action="/huellitasdigital/app/controllers/admin/supplierController.php?action=store" 
                          method="POST" 
                          novalidate>

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
        document.getElementById('supplierForm').addEventListener('submit', function(e) {
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

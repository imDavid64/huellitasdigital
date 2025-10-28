<aside class="admin-aside">
    <div class="aside-container">
        <div class="aside-main">
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php?controller=admin&action=index">
                        <i class="bi bi-opencollective"></i> Dashboard
                    </a></li>

                <li><a href="<?= BASE_URL ?>/index.php?controller=adminUser&action=index">
                        <i class="bi bi-people-fill"></i> Gestión de Usuarios
                    </a></li>

                <li><a href="<?= BASE_URL ?>/index.php?controller=adminRole&action=index">
                        <i class="bi bi-diagram-2-fill"></i> Gestión de Roles
                    </a></li>

                <li><a href="<?= BASE_URL ?>/index.php?controller=adminSupplier&action=index">
                        <i class="bi bi-building-fill"></i> Gestión de Proveedores
                    </a></li>

                <li><a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=index">
                        <i class="bi bi-box2-fill"></i> Gestión de Productos
                    </a></li>

                <li><a href="<?= BASE_URL ?>/index.php?controller=adminContabilidad&action=index">
                        <i class="bi bi-calculator-fill"></i> Registro Contable
                    </a></li>

                <li><a href="<?= BASE_URL ?>/index.php?controller=adminPedido&action=index">
                        <i class="bi bi-cart-fill"></i> Gestión de Pedidos
                    </a></li>

                <li><a href="<?= BASE_URL ?>/index.php?controller=adminCita&action=index">
                        <i class="bi bi-calendar-week-fill"></i> Gestión de Citas
                    </a></li>

                <li><a href="<?= BASE_URL ?>/index.php?controller=adminGeneralSetting&action=index">
                        <i class="bi bi-gear-fill"></i> Configuración General
                    </a></li>
            </ul>
        </div>
        <hr />
        <div class="aside-footer">
            <a class="btn-dark-blue" href="<?= BASE_URL ?>/index.php?controller=auth&action=logout"><strong>
                    Cerrar Sesión</strong></a>
        </div>
    </div>
</aside>
<aside class="admin-aside">
    <div class="aside-container">
        <div>
            <div class="f-flex flex-column align-items-center">
                <h6>Bienvenido!</h6>
                <h5><strong><?= $_SESSION['user_name'] ?? 'Usuario' ?></strong></h5>
                <p class="text-secondary text-opacity-75" style="margin-bottom: 0px; font-size: 12px;"><?= $_SESSION['user_role'] ?? 'Rol' ?></p>
            </div>
        </div>
        <hr />
        <div class="aside-main">
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index"><i
                            class="bi bi-house-fill"></i>Dashboard</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=employeeFile&action=index"><i
                            class="bi bi-folder-fill"></i>Expedientes</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=index"><i
                            class="bi bi-people-fill"></i>Clientes</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=employeeAppointment&action=index"><i
                            class="bi bi-calendar-week-fill"></i>Citas</a></li>
            </ul>
        </div>
        <hr />
        <div class="aside-footer">
            <a class="btn-orange" href="<?= BASE_URL ?>/index.php?controller=auth&action=logout"><strong>
                    Cerrar Sesión</strong></a>
        </div>
    </div>
</aside>
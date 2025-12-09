<?php
//NO QUITAR//
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../../config/bootstrap.php';
}

$userPhoto = !empty($_SESSION['user_image'])
    ? $_SESSION['user_image']
    : BASE_URL . '/public/assets/images/default-user-image.png';
?>
<script>
    const BASE_URL = "<?= BASE_URL ?>";
    const USER_LOGGED_IN = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
</script>
<!--NO QUITAR-->

<header class="main-header">
    <nav class="header-container-admin">
        <div class="header-container-left">
            <!--Boton del logo-->
            <div>
                <a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index" class="header-logo-admin">
                    <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Logo Veterinaria Dra.Huellitas">
                    <span>Huellitas<br><strong>Digital</strong></span>
                </a>
            </div>
        </div>

        <!--Botones de Login, registro e info del usuario-->
        <div class="header-container-right">
            <!-- Botón de notificaciones -->
            <div class="admin-notification-icon">
                <a href="#" id="btnNotifications"><i class="bi bi-bell-fill"></i>
                    <span id="notification-count" class="notification-count">0</span></a>
                <div class="notification-dropdown" id="notificationDropdown" style="display:none;">
                    <div class="notification-header">Notificaciones</div>
                    <div class="notification-list"></div>
                    <div class="notification-footer">
                        <button id="markAsRead" class="btn btn-sm btn-link">Marcar todas como leídas</button>
                    </div>
                </div>
            </div>
            <div class="header-menu-icon">
                <button class="header-user-img header-user-admin" id="header-user-img">
                    <?php if (!empty($_SESSION['user_image'])): ?>
                        <img src="<?= htmlspecialchars($userPhoto) ?>" alt="Foto" class="header-user-photo">
                    <?php else: ?>
                        <i class="bi bi-person-fill"></i>
                    <?php endif; ?>
                </button>
                <!---->
                <div class="admin-header-user-menu" id="header-user-menu">
                    <ul>
                        <li><a href="<?= BASE_URL ?>/index.php?controller=employeeProfile&action=index"><i
                                    class="bi bi-person-fill"></i> Mi Perfil</a></li>
                        <?php if ($_SESSION['user_role'] === 'ADMINISTRADOR'): ?>
                            <li><a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">
                                    <i class="bi bi-tools"></i> Panel Administrador</a></li>
                            <li><a href="<?= BASE_URL ?>/index.php?controller=employeeDashboard&action=index">
                                    <i class="bi bi-person-vcard-fill"></i> Panel Empleado</a></li>
                            <li><a href="<?= BASE_URL ?>/index.php?controller=home&action=index">
                                    <i class="bi bi-basket2-fill"></i> Modo Cliente</a></li>
                        <?php endif; ?>
                        <li><a href="<?= BASE_URL ?>/index.php?controller=auth&action=logout">
                                <i class="bi bi-door-open-fill"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
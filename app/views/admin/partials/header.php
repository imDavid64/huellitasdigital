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
</script>
<!--NO QUITAR-->

<header class="main-header">
    <nav class="header-container-admin">
        <div class="header-container-left">
            <!--Boton del logo-->
            <div>
                <a href="<?= BASE_URL ?>/index.php?controller=admin&index" class="header-logo-admin">
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
                        <li><a href="<?= BASE_URL ?>/index.php?controller=user&action=index"><i
                                    class="bi bi-person-fill"></i> Mi Pefil</a></li>
                        <li><a href="<?= BASE_URL ?>/index.php?controller=home&action=index">
                                <i class="bi bi-bag-fill"></i> Modo Cliente</a></li>
                        <li><a href="<?= BASE_URL ?>/index.php?controller=auth&action=logout">
                                <i class="bi bi-door-open-fill"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<header class="main-header">
    <nav class="header-container-admin">
        <div class="header-container-left">
            <!--Boton del logo-->
            <div>
                <a href="home.html" class="header-logo-admin">
                    <img src="/huellitasdigital/public/assets/images/logo.png" alt="Logo Veterinaria Dra.Huellitas">
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
                    <i class="bi bi-person-fill"></i>
                </button>
                <!---->
                <div class="admin-header-user-menu" id="header-user-menu">
                    <ul>
                        <li><a href="pages/profile.html"><i class="bi bi-person-fill"></i> Mi Pefil</a></li>
                        <li><a href="/huellitasdigital/app/controller/homeController.php?action=index">
                                <i class="bi bi-bag-fill"></i> Modo Cliente</a></li>
                        <li><a href="/huellitasdigital/app/routes/web.php?action=logout">
                                <i class="bi bi-door-open-fill"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
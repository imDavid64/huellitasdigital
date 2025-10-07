<!--Ventana Emergente "LOGIN"-->
    <section class="display-login" id="display-login">
        <div class="form-login">
            <div class="login-head">
                <span class="title-login">Inicio de Sesión</span>
                <i id="btnCloseXLogin" class="bi bi-x"></i>
            </div>
            <div class="input-login">
                <form action="app/routes/web.php?action=login" method="POST">
                    <div>
                        <label for="login-user-email">Correo Electrónico</label>
                        <input type="email" id="login-user-email" name="login-user-email"
                            placeholder="ejemplo@gmail.com" required>
                    </div>
                    <div>
                        <label for="login-user-password">Contraseña</label>
                        <input type="password" id="login-user-password" name="login-user-password"
                            placeholder="contraseña" required>
                    </div>
                    <div>
                        <a id="btnResetPass" href="#">¿Olvidastes tu contraseña?</a>
                    </div>
                    <div class="btns-login">
                        <div>
                            <div>
                                <button type="submit" class="btn-blue" id="btnStartLogin">Iniciar Sesión</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Ventana Emergente "LOGIN"-->

    <!--Ventana Emergente "REGISTRO"-->
    <section class="display-register" id="display-register">
        <div class="form-register">
            <div class="register-head">
                <span class="title-register">Registro</span>
                <i id="btnCloseXRegister" class="bi bi-x"></i>
            </div>
            <div class="input-register">
                <form action="app/routes/web.php?action=register" method="POST">
                    <div>
                        <label for="register-user-name">Nombre Completo</label>
                        <input type="text" id="register-user-name" name="register-user-name" required>
                    </div>
                    <div>
                        <label for="register-user-email">Correo Electrónico</label>
                        <input type="email" id="register-user-email" name="register-user-email"
                            placeholder="ejemplo@gmail.com" required>
                    </div>
                    <div>
                        <label for="register-user-identification">Identificación</label>
                        <input type="number" name="register-user-identification" id="register-user-identification"
                            required>
                    </div>
                    <div>
                        <label for="register-user-password">Contraseña</label>
                        <input type="password" id="register-user-password" name="register-user-password"
                            placeholder="contraseña" required>
                    </div>
                    <div class="btns-register">
                        <div>
                            <div>
                                <button type="submit" class="btn-blue" id="btnStartRegister">Registrarse</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Ventana Emergente "REGISTRO"-->

    <!--Ventana Emergente "RECUPERACION CONTRASEÑA"-->
    <section class="display-resetPass" id="display-resetPass">
        <div class="form-resetPass">
            <div class="resetPass-head">
                <span class="title-resetPass">Recuperación de Contraseña</span>
                <i id="btnCloseXResetPass" class="bi bi-x"></i>
            </div>
            <div class="input-resetPass">
                <form action="app/recovery.php" method="POST">
                    <div>
                        <label for="resetPass-user-email">Correo Electrónico</label>
                        <input type="email" id="resetPass-user-email" name="resetPass-user-email"
                            placeholder="ejemplo@gmail.com" required>
                    </div>
                    <div>
                        <span>*Le enviamos un correo para que pueda restablecer su contraseña.</span>
                    </div>
                    <div class="btns-resetPass">
                        <div>
                            <div>
                                <button type="submit" class="btn-blue" id="btnStartResetPass">Recuperar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Ventana Emergente "RECUPERACION CONTRASEÑA"-->

    <!--Logica para el Modal de recuperación de contraseña-->
    <?php
    $message = isset($_GET['message']) ? $_GET['message'] : null;

    // Definir textos según el parámetro
    $alertText = "";
    if ($message === "pass_changed") {
        $alertText = "✅ Tu contraseña ha sido cambiada con éxito.";
    } elseif ($message === "ok") {
        $alertText = "✅ Se te ha enviado un correo para restablecer tu contraseña.";
    } elseif ($message === "error") {
        $alertText = "❌ Ocurrió un error, intenta nuevamente.";
    } elseif ($message === "not_found") {
        $alertText = "❌ Correo no encontrado, intenta nuevamente.";
    }
    ?>

    <?php if ($alertText): ?>
        <!-- Modal Bootstrap -->
        <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">Mensaje</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center">
                        <?php echo $alertText; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-blue" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var myModal = new bootstrap.Modal(document.getElementById('messageModal'));
                myModal.show();
            });
        </script>
    <?php endif; ?>

    <header class="main-header">
        <nav class="header-container">
            <div class="header-container-left">
                <!--Boton del logo-->
                <div>
                    <a href="index.php" class="header-logo">
                        <img src="/huellitasdigital/public/assets/images/Logo-AzulOscuro.png" alt="Logo Veterinaria Dra.Huellitas">
                        <span>Huellitas<br><strong>Digital</strong></span>
                    </a>
                </div>
                <!--Boton de nuestra Ubicación-->
                <div>
                    <a href="pages/location.php" class="header-vet-location">
                        <i class="bi bi-geo-alt"></i>
                    </a>
                </div>
                <!--Barra de busqueda-->
                <div class="header-search">
                    <input type="search" id="header-search" placeholder="Buscar">
                    <i class="bi bi-search"></i>
                </div>
                <!--Boton de carrito-->
                <div class="header-cart">
                    <div>
                        <a class="btn-orange" href="pages/cart.php">Carrito <i class="bi bi-cart"></i></a>
                    </div>
                </div>
            </div>

            <!--Botones de Login, registro e info del usuario-->
            <div class="header-container-right">
                <?php if (isset($_SESSION['user_name'])): ?>
                    <!-- Si hay sesión, mostrar bienvenida y menú -->
                    <div class="header-myPets">
                        <div>
                            <a class="btn-green" href="pages/myPets/home.php">Mis Mascotas <i
                                    class="bi bi-clipboard-heart"></i></a>
                        </div>
                    </div>
                    <div class="header-user">
                        <span>Bienvenido!</span>
                        <h5><span><?php echo htmlspecialchars($_SESSION['user_first_name']); ?></span></h5>
                    </div>
                    <div>
                        <button class="header-user-img" id="header-user-img">
                            <i class="bi bi-person-fill"></i>
                        </button>
                        <div class="header-user-menu" id="header-user-menu">
                            <ul>
                                <li><a href="/huellitasdigital/app/controllers/client/userController.php?action=index"><i class="bi bi-person-fill"></i> Mi Perfil</a></li>
                                <li><a href="pages/myOrders.php"><i class="bi bi-bag-check-fill"></i> Mis Pedidos</a></li>
                                <li><a href="pages/myAppointment.php"><i class="bi bi-calendar-event-fill"></i> Mis
                                        Citas</a></li>
                                <li><a href="/huellitasdigital/app/routes/web.php?action=logout"><i class="bi bi-door-open-fill"></i> Cerrar Sesión</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Si no hay sesión, mostrar botones de login/registro -->
                    <div class="header-login">
                        <div>
                            <a class="btn-blue" id="btnLogin" href="#">Iniciar Sesión</a>
                        </div>
                    </div>
                    <div class="header-register"></div>
                    <div>
                        <a class="btn-dark-blue" id="btnRegister" href="#">Registrarse</a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>

        <!--Barra de navegación-->
        <nav class="navbar-container">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li>
                    <a href="pages/products.php">Productos <i class="bi bi-caret-down-fill"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="pages/Products/alimentos.php">Alimentos</a></li>
                        <li><a href="pages/Products/accesorios.php">Accesorios</a></li>
                        <li><a href="pages/Products/medicamentos.php">Medicamentos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="pages/services.php">Servicios <i class="bi bi-caret-down-fill"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="pages/services/Consultas.php">Consultas</a></li>
                        <li><a href="pages/services/vacunas.php">Vacunas</a></li>
                        <li><a href="pages/services/desparacitacion.php">Desparacitación</a></li>
                        <li><a href="pages/services/examLab.php">Examenes de Laboratorio</a></li>
                        <li><a href="pages/services/ultrasonido.php">Ultrasonido</a></li>
                        <li><a href="pages/services/cirugiasMenores.php">Cirugias Menores</a></li>
                        <li><a href="pages/services/limpiezasDentales.php">Limpiezas Dentales</a></li>
                    </ul>
                </li>
                <li>
                    <a href="pages/aboutUs.php">Sobre Nosotros</a>
                </li>
            </ul>
        </nav>
    </header>
    <!--HEADER-->
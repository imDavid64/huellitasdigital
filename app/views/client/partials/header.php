<style>
  .error-text {
    color: red;
    font-size: 0.85rem;
    display: none; /* oculto por defecto */
    margin: 2px 0; /* margen pequeño arriba y abajo */
    line-height: 1.1; /* compacto */
  }
</style>

<!--Ventana Emergente "LOGIN"-->
<section class="display-login" id="display-login">
  <div class="form-login">
    <div class="login-head">
      <span class="title-login">Inicio de Sesión</span>
      <i id="btnCloseXLogin" class="bi bi-x"></i>
    </div>
    <div class="input-login">
      <form id="loginForm" action="/huellitasdigital/app/routes/web.php?action=login" method="POST" onsubmit="return validateForm('loginForm')">
        <div>
          <label for="login-user-email">Correo Electrónico</label>
          <span class="error-text" id="error-login-user-email">Ingrese un correo válido</span>
          <input type="email" id="login-user-email" name="login-user-email" placeholder="ejemplo@gmail.com" required onblur="validateEmail(this)">
        </div>
        <div>
          <label for="login-user-password">Contraseña</label>
          <span class="error-text" id="error-login-user-password">Ingrese su contraseña</span>
          <input type="password" id="login-user-password" name="login-user-password" placeholder="contraseña" required onblur="validateNotEmpty(this)">
        </div>
        <div>
          <a id="btnResetPass" href="#">¿Olvidaste tu contraseña?</a>
        </div>
        <div class="btns-login">
          <button type="submit" class="btn-blue" id="btnStartLogin">Iniciar Sesión</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!--Ventana Emergente "REGISTRO"-->
<section class="display-register" id="display-register">
  <div class="form-register">
    <div class="register-head">
      <span class="title-register">Registro</span>
      <i id="btnCloseXRegister" class="bi bi-x"></i>
    </div>
    <div class="input-register">
      <form id="registerForm" action="/huellitasdigital/app/routes/web.php?action=register" method="POST" onsubmit="return validateForm('registerForm')">
        <div>
          <label for="register-user-name">Nombre Completo</label>
          <span class="error-text" id="error-register-user-name">Ingrese su nombre completo</span>
          <input type="text" id="register-user-name" name="register-user-name" required onblur="validateNotEmpty(this)">
        </div>
        <div>
          <label for="register-user-email">Correo Electrónico</label>
          <span class="error-text" id="error-register-user-email">Ingrese un correo válido</span>
          <input type="email" id="register-user-email" name="register-user-email" placeholder="ejemplo@gmail.com" required onblur="validateEmail(this)">
        </div>
        <div>
          <label for="register-user-identification">Identificación</label>
          <span class="error-text" id="error-register-user-identification">Ingrese su identificación</span>
          <input type="number" name="register-user-identification" id="register-user-identification" required onblur="validateNotEmpty(this)">
        </div>
        <div>
          <label for="register-user-password">Contraseña</label>
          <span class="error-text" id="error-register-user-password">Ingrese su contraseña</span>
          <input type="password" id="register-user-password" name="register-user-password" placeholder="contraseña" required onblur="validateNotEmpty(this)">
        </div>
        <div class="btns-register">
          <button type="submit" class="btn-blue" id="btnStartRegister">Registrarse</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!--Ventana Emergente "RECUPERACION CONTRASEÑA"-->
<section class="display-resetPass" id="display-resetPass">
  <div class="form-resetPass">
    <div class="resetPass-head">
      <span class="title-resetPass">Recuperación de Contraseña</span>
      <i id="btnCloseXResetPass" class="bi bi-x"></i>
    </div>
    <div class="input-resetPass">
      <form id="resetPassForm" action="app/recovery.php" method="POST" onsubmit="return validateForm('resetPassForm')">
        <div>
          <label for="resetPass-user-email">Correo Electrónico</label>
          <span class="error-text" id="error-resetPass-user-email">Ingrese un correo válido</span>
          <input type="email" id="resetPass-user-email" name="resetPass-user-email" placeholder="ejemplo@gmail.com" required onblur="validateEmail(this)">
        </div>
        <div>
          <span>*Le enviamos un correo para que pueda restablecer su contraseña.</span>
        </div>
        <div class="btns-resetPass">
          <button type="submit" class="btn-blue" id="btnStartResetPass">Recuperar</button>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
  // Validación de correo
  function validateEmail(input) {
    const errorSpan = document.getElementById('error-' + input.id);
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(input.value.trim())) {
      errorSpan.style.display = 'block';
      return false;
    } else {
      errorSpan.style.display = 'none';
      return true;
    }
  }

  // Validación de campos no vacíos
  function validateNotEmpty(input) {
    const errorSpan = document.getElementById('error-' + input.id);
    if (input.value.trim() === '') {
      errorSpan.style.display = 'block';
      return false;
    } else {
      errorSpan.style.display = 'none';
      return true;
    }
  }

  // Validación completa antes de enviar el formulario
  function validateForm(formId) {
    const form = document.getElementById(formId);
    let valid = true;
    form.querySelectorAll('input[required]').forEach(input => {
      if (input.type === 'email') valid = validateEmail(input) && valid;
      else valid = validateNotEmpty(input) && valid;
    });
    return valid;
  }
</script>



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
                    <img src="/huellitasdigital/public/assets/images/Logo-AzulOscuro.png"
                        alt="Logo Veterinaria Dra.Huellitas">
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
                <input type="search" id="header-search" placeholder="Buscar producto...">
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

                            <?php if ($_SESSION['user_role'] === 'ADMINISTRADOR'): ?>
                                <li><a href="/huellitasdigital/app/views/admin/home.php">
                                        <i class="bi bi-gear-fill"></i> Modo Administrador</a></li>
                            <?php endif; ?>
                            <li><a href="/huellitasdigital/app/controllers/client/userController.php?action=index">
                                    <i class="bi bi-person-fill"></i> Mi Perfil</a></li>
                            <li><a href="pages/myOrders.php">
                                    <i class="bi bi-bag-check-fill"></i> Mis Pedidos</a></li>
                            <li><a href="pages/myAppointment.php">
                                    <i class="bi bi-calendar-event-fill"></i> Mis Citas</a></li>
                            <li><a href="/huellitasdigital/app/routes/web.php?action=logout">
                                    <i class="bi bi-door-open-fill"></i> Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <!-- Si no hay sesión, mostrar botones de login/registro -->
                <div class="header-login">
                    <div>
                        <a class="btn-blue btnLogin" href="#">Iniciar Sesión</a>
                    </div>
                </div>
                <div class="header-register">
                    <div>
                        <a class="btn-dark-blue" id="btnRegister" href="#">Registrarse</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <!--Barra de navegación-->
    <nav class="navbar-container">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li>
                <a href="/huellitasdigital/app/controllers/client/productController.php?action=index">Productos <i
                        class="bi bi-caret-down-fill"></i></a>
                <ul class="dropdown-menu">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a
                                    href="/huellitasdigital/app/controllers/client/productController.php?action=index&idCategoria=<?= $category['ID_CATEGORIA_PK'] ?>">
                                    <?= htmlspecialchars($category['DESCRIPCION_CATEGORIA']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay categorias disponibles.</p>
                    <?php endif; ?>
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
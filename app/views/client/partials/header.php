<?php
//NO QUITAR//
if (!defined('BASE_URL')) {
  require_once __DIR__ . '/../../../config/bootstrap.php';
}

?>
<script>
  const BASE_URL = "<?= BASE_URL ?>";
  const USER_LOGGED_IN = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
</script>
<!--NO QUITAR-->



<style>
  .error-text {
    color: red;
    font-size: 0.85rem;
    display: none;
    /* oculto por defecto */
    margin: 2px 0;
    /* margen pequeño arriba y abajo */
    line-height: 1.1;
    /* compacto */
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
      <form id="loginForm" action="<?= BASE_URL ?>/index.php?controller=auth&action=login" method="POST"
        onsubmit="return validateForm('loginForm')">
        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
        <div>
          <label for="login-user-email">Correo Electrónico</label>
          <span class="error-text" id="error-login-user-email">Ingrese un correo válido</span>
          <input type="email" id="login-user-email" name="login-user-email" placeholder="ejemplo@gmail.com" required
            onblur="validateEmail(this)">
        </div>
        <div>
          <label for="login-user-password">Contraseña</label>
          <span class="error-text" id="error-login-user-password">Ingrese su contraseña</span>
          <input type="password" id="login-user-password" name="login-user-password" placeholder="contraseña" required
            onblur="validateNotEmpty(this)">
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
      <form id="registerForm" method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
        <div>
          <label for="register-user-name">Nombre Completo</label>
          <input type="text" id="register-user-name" name="register-user-name" required>
        </div>

        <div>
          <label for="register-user-email">Correo Electrónico</label>
          <input type="email" id="register-user-email" name="register-user-email" required>
        </div>

        <div>
          <label for="register-user-identification">Identificación</label>
          <input type="text" id="register-user-identification" maxlength="9" minlength="9"
            name="register-user-identification" required>
        </div>

        <div>
          <label for="register-user-password">Contraseña</label>
          <input type="password" id="register-user-password" name="register-user-password" required>
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
      <form id="resetPassForm" action="<?= BASE_URL ?>/index.php?controller=auth&action=recovery" method="POST"
        onsubmit="return validateForm('resetPassForm')">
        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
        <div>
          <label for="resetPass-user-email">Correo Electrónico</label>
          <span class="error-text" id="error-resetPass-user-email">Ingrese un correo válido</span>
          <input type="email" id="resetPass-user-email" name="resetPass-user-email" placeholder="ejemplo@gmail.com"
            required onblur="validateEmail(this)">
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
        <a href="<?= BASE_URL ?>/index.php?controller=home&action=index" class="header-logo">
          <img src="<?= BASE_URL ?>/public/assets/images/Logo-AzulOscuro.png" alt="Logo Veterinaria Dra.Huellitas">
          <span>Huellitas<br><strong>Digital</strong></span>
        </a>
      </div>
      <!--Boton de nuestra Ubicación-->
      <div>
        <a href="#vet-location" class="header-vet-location">
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
          <a class="btn-orange" href="<?= BASE_URL ?>/index.php?controller=cart&action=index">Carrito <i
              class="bi bi-cart"></i></a>
        </div>
      </div>
    </div>

    <!--Botones de Login, registro e info del usuario-->
    <div class="header-container-right">
      <?php if (isset($_SESSION['user_name'])): ?>
        <!-- Si hay sesión, mostrar bienvenida y menú -->
        <div class="header-myPets">
          <div>
            <a class="btn-green" href="<?= BASE_URL ?>/index.php?controller=pets&action=index">Mis Mascotas <i
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
                <li><a href="<?= BASE_URL ?>/index.php?controller=adminDashboard&action=index">
                    <i class="bi bi-gear-fill"></i> Modo Administrador</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=employee&action=index">
                    <i class="bi bi-person-vcard-fill"></i> Modo Empleado</a></li>
              <?php endif; ?>
              <?php if ($_SESSION['user_role'] === 'EMPLEADO'): ?>
                <li><a href="<?= BASE_URL ?>/index.php?controller=employee&action=index">
                    <i class="bi bi-person-vcard-fill"></i> Modo Empleado</a></li>
              <?php endif; ?>
              <li><a href="<?= BASE_URL ?>/index.php?controller=user&action=index">
                  <i class="bi bi-person-fill"></i> Mi Perfil</a></li>
              <li><a href="<?= BASE_URL ?>/index.php?controller=orders&action=list">
                  <i class="bi bi-bag-check-fill"></i> Mis Pedidos</a></li>
              <li><a href="pages/myAppointment.php">
                  <i class="bi bi-calendar-event-fill"></i> Mis Citas</a></li>
              <li><a href="<?= BASE_URL ?>/index.php?controller=auth&action=logout">
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
      <li><a href="<?= BASE_URL ?>/index.php?controller=home&action=index">Inicio</a></li>
      <li>
        <a href="<?= BASE_URL ?>/index.php?controller=product&action=index">Productos <i
            class="bi bi-caret-down-fill"></i></a>
        <ul class="dropdown-menu">
          <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
              <li>
                <a
                  href="<?= BASE_URL ?>/index.php?controller=product&action=index&idCategoria=<?= $category['ID_CATEGORIA_PK'] ?>">
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
        <a href="<?= BASE_URL ?>/index.php?controller=service&action=index">Servicios <i
            class="bi bi-caret-down-fill"></i></a>
        <ul class="dropdown-menu">
          <?php if (!empty($services)): ?>
            <?php foreach ($services as $navbarService): ?>
              <li>
                <a
                  href="<?= BASE_URL ?>/index.php?controller=service&action=serviceDetails&idService=<?= $navbarService['ID_SERVICIO_PK'] ?>">
                  <?= htmlspecialchars($navbarService['NOMBRE_SERVICIO']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No hay servicios disponibles.</p>
          <?php endif; ?>
        </ul>
      </li>
      <li>
        <a href="<?= BASE_URL ?>/index.php?controller=aboutUs&action=index">Sobre Nosotros</a>
      </li>
    </ul>
  </nav>
</header>
<!--HEADER-->
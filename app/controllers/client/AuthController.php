<?php
namespace App\Controllers\Client;

use App\Models\Client\UserModel;
use App\Helpers\EmailHelper;

require_once __DIR__ . '/../../config/bootstrap.php';

session_regenerate_id(true);

class AuthController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

        // Verificar método POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
                return;
            }
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        // Validar CSRF token
        if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'CSRF inválido.']);
                return;
            }
            $_SESSION['error'] = 'Petición no válida.';
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        $email = trim($_POST['login-user-email'] ?? '');
        $password = trim($_POST['login-user-password'] ?? '');

        //Validación básica
        if (empty($email) || empty($password)) {
            $msg = 'Todos los campos son obligatorios.';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $msg]);
                return;
            }
            $_SESSION['error'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        //Validar credenciales con el modelo
        $row = $this->userModel->validarLogin($email, $password);

        if ($row && $row['LOGIN_EXITOSO']) {
            $userData = $this->userModel->getUsuarioById($row['ID_USUARIO']);

            // Variables de sesión
            $_SESSION['user_id'] = $userData['ID_USUARIO_PK'];
            $_SESSION['user_code'] = $userData['CODIGO_USUARIO'];
            $_SESSION['user_name'] = $userData['USUARIO_NOMBRE'];
            $_SESSION['user_first_name'] = explode(' ', $userData['USUARIO_NOMBRE'])[0];
            $_SESSION['user_role'] = $userData['ROL'];

            $msg = '✅ Bienvenido ' . htmlspecialchars($userData['USUARIO_NOMBRE']);

            // 🔹 Respuesta AJAX
            if ($isAjax) {
                // Definir la URL según el rol
                switch ($_SESSION['user_role']) {
                    case 'ADMINISTRADOR':
                        $redirect = BASE_URL . '/index.php?controller=adminDashboard&action=index';
                        break;
                    case 'EMPLEADO':
                        $redirect = BASE_URL . '/index.php?controller=employee&action=index';
                        break;
                    default:
                        $redirect = BASE_URL . '/index.php?controller=home&action=index';
                        break;
                }

                echo json_encode([
                    'success' => true,
                    'message' => $msg,
                    'redirect' => $redirect
                ]);
                return;
            }

            // 🔹 Flujo tradicional
            $_SESSION['success'] = $msg;
            switch ($_SESSION['user_role']) {
                case 'ADMINISTRADOR':
                    header('Location: ' . BASE_URL . '/index.php?controller=admin&action=index');
                    break;
                case 'EMPLEADO':
                    header('Location: ' . BASE_URL . '/index.php?controller=employee&action=index');
                    break;
                default:
                    header('Location: ' . BASE_URL . '/index.php?controller=home&action=index');
                    break;
            }
            exit;
        } else {
            $mensaje = $row['MENSAJE'] ?? 'Credenciales incorrectas.';
            $msg = htmlspecialchars($mensaje);

            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $msg]);
                return;
            }

            $_SESSION['error'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }
    }


    public function register()
    {
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
                return;
            }
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=registerForm');
            exit;
        }

        // Validar CSRF token
        if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'CSRF inválido.']);
                return;
            }
            $_SESSION['error'] = 'Petición no válida.';
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=registerForm');
            exit;
        }

        $nombre = trim($_POST['register-user-name'] ?? '');
        $email = trim($_POST['register-user-email'] ?? '');
        $identificacion = (int) trim($_POST['register-user-identification'] ?? '');
        $password = trim($_POST['register-user-password'] ?? '');

        // 🔸 Validación de campos vacíos
        if (empty($nombre) || empty($email) || empty($identificacion) || empty($password)) {
            $msg = 'Todos los campos son obligatorios.';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $msg]);
                return;
            }
            $_SESSION['error'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=registerForm');
            exit;
        }

        // 🔸 Validar correo duplicado
        if ($this->userModel->emailExiste($email)) {
            $msg = 'Este correo ya está registrado.';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $msg]);
                return;
            }
            $_SESSION['error'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=registerForm');
            exit;
        }

        // 🔸 Validar identificación duplicada
        if ($this->userModel->identificacionExiste($identificacion)) {
            $msg = 'Esta identificación ya está registrada.';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $msg]);
                return;
            }
            $_SESSION['error'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=registerForm');
            exit;
        }

        // 🔸 Iniciar transacción
        $this->userModel->beginTx();
        $newId = $this->userModel->registrarUsuario($nombre, $email, $identificacion, $password);
        if (!$newId) {
            $this->userModel->rollback();
            $msg = 'Error al registrar el usuario.';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $msg]);
                return;
            }
            $_SESSION['error'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=registerForm');
            exit;
        }

        // 🔸 Crear token
        $token = $this->userModel->crearToken($newId, 'VERIFICACION', 1440, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
        if (!$token) {
            $this->userModel->rollback();
            $msg = 'No se pudo generar el token de verificación.';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $msg]);
                return;
            }
            $_SESSION['error'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=registerForm');
            exit;
        }

        // 🔸 Enviar correo
        $enviado = EmailHelper::enviarCorreoVerificacion($email, $nombre, $token);

        if ($enviado) {
            $this->userModel->commit();
            $msg = 'Registro exitoso. Verifique su correo electrónico para activar su cuenta.';
            if ($isAjax) {
                echo json_encode(['success' => true, 'message' => $msg]);
                return;
            }
            $_SESSION['success'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        } else {
            $this->userModel->rollback();
            $msg = 'No se pudo enviar el correo de verificación. Intente nuevamente.';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => $msg]);
                return;
            }
            $_SESSION['error'] = $msg;
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=registerForm');
            exit;
        }
    }



    public function verificarCuenta()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $_SESSION['error'] = '❌ Token inválido.';
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        // Validar token en la tabla HUELLITAS_TOKENS_TB
        $idUsuario = $this->userModel->validarToken($token, 'VERIFICACION');

        if ($idUsuario) {
            $this->userModel->activarCuenta($idUsuario);
            $this->userModel->marcarTokenUsado($token);
            $_SESSION['success'] = '✅ Cuenta verificada correctamente. Ya puede iniciar sesión.';
        } else {
            $_SESSION['error'] = '⚠️ Token inválido o expirado.';
        }

        header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
        exit;
    }

    // ==========================================
    // SOLICITAR RECUPERACIÓN (envía el correo)
    // ==========================================
    public function recovery()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        // Validar CSRF token
        if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = '❌ Petición inválida.';
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        // Validar email
        $email = trim($_POST['resetPass-user-email'] ?? '');
        if (empty($email)) {
            $_SESSION['error'] = '❌ Debe ingresar su correo.';
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        // Buscar usuario
        $user = $this->userModel->getUsuarioByEmail($email);
        if (!$user || $user['ID_ESTADO_FK'] != 1) {
            $_SESSION['error'] = '⚠️ No existe una cuenta activa con este correo.';
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        // Crear token de recuperación (15 minutos)
        $token = $this->userModel->crearToken($user['ID_USUARIO_PK'], 'RECUPERACION', 15, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);

        if (!$token) {
            $_SESSION['error'] = '⚠️ No se pudo generar el token de recuperación.';
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        // Enviar correo
        if (EmailHelper::enviarCorreoRecuperacion($email, $user['USUARIO_NOMBRE'], $token)) {
            $_SESSION['success'] = '📩 Revise su correo para restablecer la contraseña.';
        } else {
            $_SESSION['error'] = '❌ Error al enviar el correo.';
        }

        header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
        exit;
    }

    // ==========================================
    // MOSTRAR FORMULARIO DE NUEVA CONTRASEÑA
    // ==========================================
    public function resetForm()
    {
        $token = $_GET['token'] ?? '';
        if (empty($token)) {
            $_SESSION['error'] = '❌ Token inválido.';
            header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
            exit;
        }

        require __DIR__ . '/../../views/client/auth/reset-pass.php';
    }

    // ==========================================
    // PROCESAR CAMBIO DE CONTRASEÑA
    // ==========================================
    public function resetPassword()
    {
        //validar CSRF token
        if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'CSRF inválido.';
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=resetForm&token=" . urlencode($_POST['token']));
            exit;
        }

        $token = $_POST['token'] ?? '';
        $password = trim($_POST['new-password'] ?? '');

        if (empty($token) || empty($password)) {
            $_SESSION['error'] = '❌ Todos los campos son obligatorios.';
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=resetForm&token=" . urlencode($token));
            exit;
        }

        if ($this->userModel->resetPasswordByToken($token, $password)) {
            $_SESSION['success'] = '✅ Contraseña restablecida correctamente. Inicie sesión.';
        } else {
            $_SESSION['error'] = '⚠️ Token inválido o expirado.';
        }

        header('Location: ' . BASE_URL . '/index.php?controller=auth&action=loginForm');
        exit;
    }

    public function vincularCliente()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            return;
        }

        // Recibir el código de usuario desde AJAX
        $codigoUsuario = trim($_POST['codigoUsuario'] ?? '');

        if (empty($codigoUsuario)) {
            echo json_encode(['success' => false, 'message' => 'Código de usuario inválido.']);
            return;
        }

        // Iniciar transacción
        $this->userModel->beginTx();

        // Llamar al SP mediante el nuevo método
        if ($this->userModel->vincularClientePorCodigo($codigoUsuario)) {

            $this->userModel->commit();
            echo json_encode([
                'success' => true,
                'message' => 'Vinculación completada correctamente.'
            ]);

        } else {

            $this->userModel->rollback();
            echo json_encode([
                'success' => false,
                'message' => 'Error al vincular los datos.'
            ]);
        }
    }


    public function registerForm()
    {
        header('Location: ' . BASE_URL . '/index.php?controller=home&action=index');
        exit;
    }

    public function loginForm()
    {
        header('Location: ' . BASE_URL . '/index.php?controller=home&action=index');
        exit;
    }

    public function passwordRecoveryForm()
    {
        header('Location: ' . BASE_URL . '/index.php?controller=home&action=index');
        exit;
    }


    // Cerrar sesión
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/index.php?controller=home&action=index');
        exit;
    }

}

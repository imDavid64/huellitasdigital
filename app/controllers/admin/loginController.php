<?php
session_start();
require_once __DIR__ . '/../../models/admin/userModel.php';
require_once __DIR__ . '/../../models/conexionDB.php';

class LoginController
{
    private $userModel;

    public function __construct()
    {
        $db = new ConexionDatabase();   // crea el objeto de conexión
        $conn = $db->connectDB();       // obtiene la conexión mysqli
        $this->userModel = new UsuarioModel($conn);  // pásala al modelo
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST["login-user-email"]);
            $password = trim($_POST["login-user-password"]);

            if (empty($email) || empty($password)) {
                echo "<script>alert('❌ Todos los campos son obligatorios.'); window.history.back();</script>";
                exit;
            }

            $row = $this->userModel->validarLogin($email, $password);

            if ($row && $row['LOGIN_EXITOSO']) {
                $userData = $this->userModel->getUsuarioById($row["ID_USUARIO"]);

                $_SESSION["user_id"] = $userData["ID_USUARIO_PK"];
                $_SESSION["user_name"] = $userData["USUARIO_NOMBRE"];
                $_SESSION["user_first_name"] = explode(' ', $userData["USUARIO_NOMBRE"])[0];
                $_SESSION["user_role"] = $userData["ROL"];

                echo "<script>alert('✅ Bienvenido {$userData['USUARIO_NOMBRE']}');</script>";

                switch ($_SESSION["user_role"]) {
                    case "ADMINISTRADOR":
                        header("Location: /huellitasdigital/app/views/admin/home.php");
                        break;
                    case "EMPLEADO":
                        header("Location: /huellitasdigital/app/views/empleadoVeterinario/home.php");
                        break;
                    default:
                        header("Location: /huellitasdigital/index.php");
                        break;
                }
                exit;
            } else {
                $mensaje = $row['MENSAJE'] ?? 'Error en el login';
                echo "<script>alert('❌ {$mensaje}'); window.history.back();</script>";
                exit;
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /huellitasdigital/index.php");
        exit;
    }

}

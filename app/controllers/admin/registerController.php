<?php
session_start();
require_once __DIR__ . '/../../models/conexionDB.php';
require_once __DIR__ . '/../../models/admin/registerModel.php';

class RegisterController
{
    private $registerModel;

    public function __construct()
    {
        $db = new ConexionDatabase();
        $conn = $db->connectDB();
        $this->registerModel = new RegisterModel($conn);
    }

    public function registrarUsuario()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = trim($_POST["register-user-name"]);
            $email = trim($_POST["register-user-email"]);
            $identificacion = trim($_POST["register-user-identification"]);
            $password = trim($_POST["register-user-password"]);

            if (empty($nombre) || empty($email) || empty($password) || empty($identificacion)) {
                echo "<script>alert('❌ Todos los campos son obligatorios.'); window.history.back();</script>";
                exit;
            }

            $resultado = $this->registerModel->crearUsuario($nombre, $email, $identificacion, $password);

            if ($resultado['status'] === 'success') {
                echo "<script>alert('✅ " . $resultado['message'] . "'); window.location='../../index.php';</script>";
            } else {
                echo "<script>alert('❌ " . $resultado['message'] . "'); window.history.back();</script>";
            }
        }
    }
}

<?php
session_start();
include_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/client/userModel.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();
$usuarioModel = new UsuarioModel($conn);

$action = $_GET['action'] ?? 'index';

// ✅ Aseguramos que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: /huellitasdigital/login.php");
    exit;
}

$id_usuario = intval($_SESSION['user_id']); // guardamos el ID una sola vez

switch ($action) {
    case 'index':
        // ✅ Cargar siempre desde la BD los datos del usuario actual
        $usuario = $usuarioModel->getUsuarioById($id_usuario);
        require '../../views/client/userProfile/profile.php';
        break;

    case 'edit':
        // ✅ Cargar los datos reales del usuario desde la BD
        $usuario = $usuarioModel->getUsuarioById($id_usuario);
        require '../../views/client/userProfile/editProfile.php';
        break;

    case 'updateProfile':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['usuario_nombre']);
            $identificacion = intval($_POST['usuario_identificacion']);
            $cuenta_bancaria = trim($_POST['usuario_cuenta_bancaria']);
            $telefono = intval($_POST['usuario_telefono']);
            $id_provincia = intval($_POST['id_provincia']);
            $id_canton = intval($_POST['id_canton']);
            $id_distrito = intval($_POST['id_distrito']);
            $senas = trim($_POST['direccion_senas']);
            $imagen_url = $_SESSION['user_img'] ?? null;

            $currentUserData = $usuarioModel->getUsuarioById($id_usuario);
            $imagen_url = $currentUserData['USUARIO_IMAGEN_URL'] ?? null;

            // ✅ Manejo de imagen en Firebase
            if (isset($_FILES['imagenFile']) && $_FILES['imagenFile']['error'] === UPLOAD_ERR_OK) {
                require_once __DIR__ . "/../../config/firebase.php";
                $firebase = new FirebaseConfig();
                $tempFile = $_FILES['imagenFile']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['imagenFile']['name']);
                $uploaded_url = $firebase->uploadUserImage($tempFile, $fileName);
                if ($uploaded_url) {
                    $imagen_url = $uploaded_url;
                }
            }

            // ✅ Actualizar en base de datos mediante el procedimiento almacenado
            $resultado = $usuarioModel->updatePerfilUsuario(
                $id_usuario,
                $nombre,
                $identificacion,
                $cuenta_bancaria,
                $imagen_url,
                $id_provincia,
                $id_canton,
                $id_distrito,
                $senas,
                $telefono
            );

            if ($resultado) {
                // ✅ Actualizamos solo los datos que SÍ están en la sesión
                $_SESSION['user_name'] = $nombre;
                $_SESSION['user_first_name'] = explode(' ', $nombre)[0];
                $_SESSION['success'] = "✅ Perfil actualizado correctamente.";
            } else {
                $_SESSION['error'] = "❌ No se pudo actualizar el perfil.";
            }

            header("Location: userController.php?action=index");
            exit;
        }
        break;


    case 'create':
        $roles = $catalogModel->getAllRoles();
        $estados = $catalogModel->getAllEstados();
        require '../../views/admin/user-mgmt/add-user.php';
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $estado = $_POST['state'];
            $rol = $_POST['role'];
            $direccionId = $_POST['direccion_id'] ?? null;
            $telefonoId = $_POST['telefono_id'] ?? null;

            if ($usuarioModel->addUsuario($username, $email, $password, $estado, $rol, $direccionId, $telefonoId)) {
                $_SESSION['success'] = "✅ Usuario agregado correctamente.";
            } else {
                $_SESSION['error'] = "❌ Error al agregar usuario.";
            }

            header("Location: userController.php?action=index");
            exit;
        } else {
            die("Acceso no permitido.");
        }



    default:
        echo "Acción no válida";
}

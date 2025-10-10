<?php
include_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/admin/userModel.php";
require_once __DIR__ . "/../../models/admin/catalogModel.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();

$usuarioModel = new UsuarioModel($conn);
$catalogModel = new CatalogModel($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $usuarios = $usuarioModel->getAllUsuarios();
        require '../../views/admin/user-mgmt/user-mgmt.php';
        break;

    case 'edit':
        $id = intval($_GET['id']);
        $usuario = $usuarioModel->getUsuarioById($id);
        $roles = $catalogModel->getAllRoles();
        $estados = $catalogModel->getAllEstados();
        require '../../views/admin/user-mgmt/edit-user.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_usuario = intval($_POST['id_usuario']);
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $estado = $_POST['state'];
            $rol = $_POST['role'];

            // Manejo de foto
            $profile_pic = null;
            if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] == 0) {
                $ext = pathinfo($_FILES['profile-pic']['name'], PATHINFO_EXTENSION);
                $filename = "profile_" . $id_usuario . "." . $ext;
                $target_dir = __DIR__ . "/../../uploads/profile_pics/";
                if (!is_dir($target_dir))
                    mkdir($target_dir, 0755, true);
                $target_file = $target_dir . $filename;
                if (move_uploaded_file($_FILES['profile-pic']['tmp_name'], $target_file)) {
                    $profile_pic = $filename;
                }
            }

            if ($usuarioModel->updateUsuario($id_usuario, $username, $email, $estado, $rol, $password, $profile_pic)) {
                $_SESSION['success'] = "✅ Usuario actualizado correctamente.";
            } else {
                $_SESSION['error'] = "❌ Error al actualizar usuario.";
            }

            header("Location: userController.php?action=index");
            exit;
        } else {
            die("Acceso no permitido.");
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
        break;


    default:
        echo "Acción no válida";
}


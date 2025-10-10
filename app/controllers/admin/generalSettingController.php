<?php
require_once __DIR__ . "/../../models/admin/generalSettingModel.php";
include_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/admin/catalogModel.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();
$geSettingModel = new GeSettingModel($conn);
$catalogModel = new CatalogModel($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_rol = intval($_POST['id_rol']);
            $rol_nombre = trim($_POST['rolename']);
            $estado = intval($_POST['state']);

            try {
                if ($roleModel->updateRole($id_rol, $rol_nombre, $estado)) {
                    $_SESSION['success'] = "✅ Rol actualizado correctamente.";
                } else {
                    $_SESSION['error'] = "❌ Error al actualizar rol.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header("Location: RoleController.php?action=index");
            exit;
        } else {
            die("❌ Acceso no permitido.");
        }
        break;

    case 'edit':
        $id_rol = intval($_GET['id'] ?? 0);
        $rol = $roleModel->getRoleById($id_rol);
        $estados = $catalogModel->getAllEstados();
        require __DIR__ . '/../../views/admin/role-mgmt/edit-role.php';
        break;

    case 'create_slider_banner':
        $estados = $catalogModel->getAllEstados();
        require __DIR__ . '/../../views/admin/geSettings-mgmt/add-slider-banner.php';
        break;

    case 'store_slider_banner':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $descripcion = trim($_POST['descripcion']);
            $id_estado = intval($_POST['estado']);

            require_once __DIR__ . "/../../config/firebase.php";
            $firebase = new FirebaseConfig();

            $imagen_url = null;
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $tempFile = $_FILES['imagen']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['imagen']['name']);

                // Subir a Firebase y obtener URL
                $imagen_url = $firebase->uploadSliderBannerImage($tempFile, $fileName);
            }

            try {
                if ($geSettingModel->addSliderBanner( $descripcion, $imagen_url, $id_estado)) {
                    $_SESSION['success'] = "✅ Slider/Banner agregado correctamente.";
                } else {
                    $_SESSION['error'] = "❌ Error al agregar Slider/Banner.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            header("Location: generalSettingController.php?action=index");
            exit;
        }
        break;

    case 'index':

    default:
        $geSettings = $geSettingModel->getAllGeSettings();
        require __DIR__ . "/../../views/admin/geSettings-mgmt/general-settings.php";
        break;
}

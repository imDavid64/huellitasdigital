<?php
namespace App\Controllers\Employee;
use App\Models\Employee\ProfileModel;
use App\Models\Admin\CatalogModel;
use App\Config\FirebaseConfig;

class EmployeeProfileController
{
    private ProfileModel $profileModel;
    private CatalogModel $catalogModel;

    public function __construct()
    {
        // ✅ Solo empleados y administradores
        if (
            !isset($_SESSION['user_role']) ||
            ($_SESSION['user_role'] !== 'EMPLEADO' && $_SESSION['user_role'] !== 'ADMINISTRADOR')
        ) {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        $this->profileModel = new ProfileModel();
        $this->catalogModel = new CatalogModel();
    }

    public function index()
    {
        $id_usuario = intval($_SESSION['user_id']);
        $usuario = $this->profileModel->getUsuarioById($id_usuario);

        require VIEW_PATH . "/employee/profile-mgmt/profile.php";
    }

    public function edit()
    {
        $id_usuario = intval($_SESSION['user_id']);
        $usuario = $this->profileModel->getUsuarioById($id_usuario);

        $provincias = $this->catalogModel->getAllProvincias();
        $cantones = $this->catalogModel->getAllCantones();
        $distritos = $this->catalogModel->getAllDistritos();

        $sessionUserId = $_SESSION['user_id'] ?? 0;

        if ($id_usuario !== $sessionUserId) {
            http_response_code(403);
            require VIEW_PATH . '/error403.php';
            exit;
        }

        require VIEW_PATH . '/employee/profile-mgmt/edit-profile.php';
    }

    public function updateProfile(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?controller=employeeProfile&action=index');
            exit;
        }

        $identificacion_raw = $_POST['usuario_identificacion'] ?? '';
        $telefono_raw = $_POST['usuario_telefono'] ?? '';

        $identificacion = ($identificacion_raw === '')
            ? null
            : (int) preg_replace('/\D+/', '', $identificacion_raw);

        $telefono = ($telefono_raw === '')
            ? null
            : (int) preg_replace('/\D+/', '', $telefono_raw);


        $id_usuario = intval($_SESSION['user_id']);
        $nombre = trim($_POST['usuario_nombre']);
        $cuenta_bancaria = trim($_POST['usuario_cuenta_bancaria']);
        $id_provincia = intval($_POST['provincia']);
        $id_canton = intval($_POST['canton']);
        $id_distrito = intval($_POST['distrito']);
        $senas = trim($_POST['senas']);
        $current_user_image_url = $_POST['current_user_image_url'] ?? '';

        $new_user_image_url = $current_user_image_url;

        // 📸 Manejo de imagen de perfil (Firebase)
        if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] === UPLOAD_ERR_OK) {
            $firebase = new FirebaseConfig();
            $tempFile = $_FILES['userImage']['tmp_name'];
            $fileName = uniqid() . '_' . basename($_FILES['userImage']['name']);
            $uploaded_url = $firebase->uploadUserImage($tempFile, $fileName);

            if ($uploaded_url) {
                if (!empty($current_user_image_url)) {
                    $firebase->deleteImage($current_user_image_url);
                }
                $new_user_image_url = $uploaded_url;
            }
        }

        // ✅ Llamar al modelo
        $resultado = $this->profileModel->updatePerfilUsuario(
            $id_usuario,
            $nombre,
            $identificacion,
            $cuenta_bancaria,
            $new_user_image_url,
            $id_provincia,
            $id_canton,
            $id_distrito,
            $senas,
            $telefono
        );

        if ($resultado) {
            $_SESSION['user_name'] = $nombre;
            $_SESSION['user_first_name'] = explode(' ', $nombre)[0];
            $_SESSION['user_image'] = $new_user_image_url;
            $_SESSION['success'] = "✅ Perfil actualizado correctamente.";
        } else {
            $_SESSION['error'] = "❌ No se pudo actualizar el perfil.";
        }

        header('Location: ' . BASE_URL . '/index.php?controller=employeeProfile&action=index');
        exit;
    }
}

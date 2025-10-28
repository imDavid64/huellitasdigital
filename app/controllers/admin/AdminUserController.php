<?php
namespace App\Controllers\Admin;

use App\Models\Admin\UserModel;
use App\Models\Admin\CatalogModel;
use App\Config\FirebaseConfig;

class AdminUserController
{
    private UserModel $userModel;
    private CatalogModel $catalogModel;
    private FirebaseConfig $firebase;

    public function __construct()
    {
        // ✅ Protección por rol: Solo ADMIN
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=index");
            exit;
        }

        $this->userModel = new UserModel();
        $this->catalogModel = new CatalogModel();
        $this->firebase = new FirebaseConfig();
    }

    // ✅ Mostrar lista inicial
    public function index()
    {
        $query = '';
        $page = 1;
        $limit = 10;
        $offset = 0;

        $usuarios = $this->userModel->searchUserPaginated($query, $limit, $offset);
        $total = $this->userModel->countUsers($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/user-mgmt/user-mgmt.php";
    }

    // ✅ Búsqueda AJAX (tabla)
    public function search()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $usuarios = $this->userModel->searchUserPaginated($query, $limit, $offset);
        $total = $this->userModel->countUsers($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/user-mgmt/partials/user-table.php";
    }

    // ✅ Formulario edición
    public function edit()
    {
        $id = intval($_GET['id'] ?? 0);
        $usuario = $this->userModel->getUsuarioById($id);
        $roles = $this->catalogModel->getAllRoles();
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/admin/user-mgmt/edit-user.php";
    }

    // ✅ Procesar actualización
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            exit("❌ Acceso denegado.");

        $id = intval($_POST['id_usuario']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $estado = intval($_POST['state']);
        $rol = intval($_POST['role']);
        $identificacion = trim($_POST['user_identification']);
        $telefono = trim($_POST['user_phone']);

        $currentImage = $_POST['current_user_image_url'] ?? null;
        $newImage = $currentImage;

        if (!empty($_FILES['userImage']['tmp_name'])) {
            $fileTemp = $_FILES['userImage']['tmp_name'];
            $fileName = uniqid() . '_' . basename($_FILES['userImage']['name']);
            $uploadedUrl = $this->firebase->uploadUserImage($fileTemp, $fileName);
            if ($uploadedUrl) {
                if ($currentImage) {
                    $this->firebase->deleteImage($currentImage);
                }
                $newImage = $uploadedUrl;
            }
        }

        try {
            $resultado = $this->userModel->updateUsuario(
                $id,
                $username,
                $email,
                $estado,
                $rol,
                $identificacion,
                $telefono,
                !empty($password) ? $password : null,
                $newImage
            );

            $_SESSION['success'] = "✅ Usuario actualizado correctamente.";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header("Location: " . BASE_URL . "/index.php?controller=adminUser&action=index");
        exit;
    }


    // ✅ Formulario alta
    public function create()
    {
        $roles = $this->catalogModel->getAllRoles();
        $estados = $this->catalogModel->getActiveInactiveStates();
        require VIEW_PATH . "/admin/user-mgmt/add-user.php";
    }

    // ✅ Guardar nuevo usuario
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            exit("❌ Acceso denegado.");

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $estado = intval($_POST['state']);
        $rol = intval($_POST['role']);
        $identificacion = trim($_POST['user_identification']);
        $telefono = trim($_POST['user_phone']);

        $resultado = $this->userModel->addUsuario(
            $username,
            $email,
            $password,
            $estado,
            $rol,
            $identificacion,
            $telefono
        );

        $_SESSION[$resultado ? 'success' : 'error'] =
            $resultado ? "✅ Usuario agregado correctamente."
            : "❌ Error al agregar usuario.";

        header("Location: " . BASE_URL . "/index.php?controller=adminUser&action=index");
        exit;
    }
}

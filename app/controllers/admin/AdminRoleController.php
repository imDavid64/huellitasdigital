<?php
namespace App\Controllers\Admin;

use App\Models\Admin\RoleModel;
use App\Models\Admin\CatalogModel;

class AdminRoleController
{
    private RoleModel $roleModel;
    private CatalogModel $catalogModel;

    public function __construct()
    {
        // ✅ Solo administradores
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        $this->roleModel = new RoleModel();
        $this->catalogModel = new CatalogModel();
    }

    // ✅ Listar roles
    public function index()
    {
        $query = $_GET['query'] ?? '';
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $roles = $this->roleModel->searchRolePaginated($query, $limit, $offset);
        $total = $this->roleModel->countRoles($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/role-mgmt/role-mgmt.php";
    }

    // ✅ Búsqueda AJAX
    public function search()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $roles = $this->roleModel->searchRolePaginated($query, $limit, $offset);
        $total = $this->roleModel->countRoles($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/role-mgmt/partials/role-table.php";
    }

    // ✅ Mostrar formulario de edición
    public function edit()
    {
        $id_rol = intval($_GET['id'] ?? 0);
        $rol = $this->roleModel->getRoleById($id_rol);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/admin/role-mgmt/edit-role.php";
    }

    // ✅ Guardar cambios
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit("❌ Acceso no permitido.");
        }

        $id_rol = intval($_POST['id_rol']);
        $rol_nombre = trim($_POST['rolename']);
        $estado = intval($_POST['state']);

        if ($this->roleModel->updateRole($id_rol, $rol_nombre, $estado)) {
            $_SESSION['success'] = "✅ Rol actualizado correctamente.";
        } else {
            $_SESSION['error'] = "❌ Error al actualizar rol.";
        }

        header("Location: " . BASE_URL . "/index.php?controller=adminRole&action=index");
        exit;
    }

    // ✅ Formulario para crear nuevo rol
    public function create()
    {
        $estados = $this->catalogModel->getActiveInactiveStates();
        require VIEW_PATH . "/admin/role-mgmt/add-role.php";
    }

    // ✅ Guardar nuevo rol
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit("❌ Acceso no permitido.");
        }

        $rolename = trim($_POST['addrolename']);
        $estado = intval($_POST['state']);

        if ($this->roleModel->addRole($rolename, $estado)) {
            $_SESSION['success'] = "✅ Rol agregado correctamente.";
        } else {
            $_SESSION['error'] = "❌ Error al agregar rol.";
        }

        header("Location: " . BASE_URL . "/index.php?controller=adminRole&action=index");
        exit;
    }
}
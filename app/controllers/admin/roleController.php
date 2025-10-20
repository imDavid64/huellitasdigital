<?php
require_once __DIR__ . "/../../models/admin/roleModel.php";
include_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/admin/catalogModel.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();
$roleModel = new RoleModel($conn);
$catalogModel = new CatalogModel($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'search':
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $roles = $roleModel->searchRolePaginated($query, $limit, $offset);
        $total = $roleModel->countRoles($query);
        $totalPages = ceil($total / $limit);

        // Si es AJAX (solo tabla)
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            require __DIR__ . "/../../views/admin/role-mgmt/partials/role-table.php";
            exit;
        }

        require __DIR__ . "/../../views/admin/role-mgmt/role-mgmt.php";
        break;

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
        require '../../views/admin/role-mgmt/edit-role.php';
        break;

    case 'create':
        $estados = $catalogModel->getAllEstados();
        require '../../views/admin/role-mgmt/add-role.php';
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rolename = trim($_POST['addrolename']);
            $estado = $_POST['state'];

            if ($roleModel->addRole($rolename, $estado)) {
                $_SESSION['success'] = "✅ Rol agregado correctamente.";
            } else {
                $_SESSION['error'] = "❌ Error al agregar rol.";
            }

            header("Location: roleController.php?action=index");
            exit;
        } else {
            die("Acceso no permitido.");
        }
        break;

    case 'index':

    default:
        $query = '';
        $page = 1;
        $limit = 10;
        $offset = 0;

        $roles = $roleModel->searchRolePaginated($query, $limit, $offset);
        $total = $roleModel->countRoles($query);
        $totalPages = ceil($total / $limit);

        require __DIR__ . "/../../views/admin/role-mgmt/role-mgmt.php";
        break;
}

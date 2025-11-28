<?php
namespace App\Controllers\Admin;

use App\Models\Admin\CatalogModel;

class AdminAccountingRecordController
{
    private CatalogModel $catalogModel;

    public function __construct()
    {
        // ✅ Solo administradores
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }
        $this->catalogModel = new CatalogModel();
    }


    public function index()
    {
        $query = $_GET['query'] ?? '';
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        //$roles = $this->roleModel->searchRolePaginated($query, $limit, $offset);
        //$total = $this->roleModel->countRoles($query);
        //$totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/accounting-record-mgmt/accounting-record.php";
    }
}
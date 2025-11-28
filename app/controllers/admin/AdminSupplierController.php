<?php
namespace App\Controllers\Admin;

use App\Models\Admin\SupplierModel;
use App\Models\Admin\CatalogModel;

class AdminSupplierController
{
    private SupplierModel $supplierModel;
    private CatalogModel $catalogModel;

    public function __construct()
    {
        // ✅ Solo administradores
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        $this->supplierModel = new SupplierModel();
        $this->catalogModel = new CatalogModel();
    }

    // ✅ Listar proveedores
    public function index()
    {
        $query = $_GET['query'] ?? '';
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $suppliers = $this->supplierModel->searchSupplierPaginated($query, $limit, $offset);
        $total = $this->supplierModel->countSuppliers($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/supplier-mgmt/supplier-mgmt.php";
    }

    // ✅ Búsqueda AJAX (solo la tabla)
    public function search()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $suppliers = $this->supplierModel->searchSupplierPaginated($query, $limit, $offset);
        $total = $this->supplierModel->countSuppliers($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/supplier-mgmt/partials/supplier-table.php";
    }

    // ✅ Mostrar formulario de edición
    public function edit()
    {
        $id = intval($_GET['id'] ?? 0);
        $supplier = $this->supplierModel->getSupplierById($id);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/admin/supplier-mgmt/edit-supplier.php";
    }

    // ✅ Procesar actualización
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit("❌ Acceso no permitido.");
        }

        $id = intval($_POST['id_supplier']);
        $nombre = trim($_POST['suppliername']);
        $contacto = trim($_POST['suppliercontact']);
        $correo = trim($_POST['supplieremail']);
        $telefono = intval(trim($_POST['suppliernumber']));
        $direccion = trim($_POST['supplieraddress']);
        $estado = intval($_POST['state']);

        if ($this->supplierModel->updateSupplier($id, $nombre, $contacto, $correo, $estado, $telefono, $direccion)) {
            $_SESSION['success'] = "✅ Proveedor actualizado correctamente.";
        } else {
            $_SESSION['error'] = "❌ Error al actualizar el proveedor.";
        }

        header("Location: " . BASE_URL . "/index.php?controller=adminSupplier&action=index");
        exit;
    }

    // ✅ Mostrar formulario de creación
    public function create()
    {
        $estados = $this->catalogModel->getActiveInactiveStates();
        require VIEW_PATH . "/admin/supplier-mgmt/add-supplier.php";
    }

    // ✅ Guardar nuevo proveedor
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit("❌ Acceso no permitido.");
        }

        $nombre = trim($_POST['suppliername']);
        $contacto = trim($_POST['suppliercontact']);
        $correo = trim($_POST['supplieremail']);
        $estado = intval($_POST['state']);
        $telefono = intval(trim($_POST['suppliernumber']));

        if ($this->supplierModel->addSupplier($nombre, $contacto, $correo, $estado, $telefono)) {
            $_SESSION['success'] = "✅ Proveedor agregado correctamente.";
        } else {
            $_SESSION['error'] = "❌ Error al agregar el proveedor.";
        }

        header("Location: " . BASE_URL . "/index.php?controller=adminSupplier&action=index");
        exit;
    }
}

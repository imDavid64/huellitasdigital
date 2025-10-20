<?php
include_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/admin/supplierModel.php";
require_once __DIR__ . "/../../models/admin/catalogModel.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();

$supplierModel = new SupplierModel($conn);
$catalogModel = new CatalogModel($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'search':
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $suppliers = $supplierModel->searchSupplierPaginated($query, $limit, $offset);
        $total = $supplierModel->countSuppliers($query);
        $totalPages = ceil($total / $limit);

        // Si es AJAX (búsqueda o cambio de página)
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            require __DIR__ . "/../../views/admin/supplier-mgmt/partials/supplier-table.php";
            exit;
        }

        require __DIR__ . "/../../views/admin/supplier-mgmt/supplier-mgmt.php";
        break;

    case 'edit':
        $id = intval($_GET['id']);
        $supplier = $supplierModel->getSupplierById($id);
        $estados = $catalogModel->getAllEstados();
        require '../../views/admin/supplier-mgmt/edit-supplier.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = intval($_POST['id_supplier']);
            $nombre = trim($_POST['suppliername']);
            $contacto = trim($_POST['suppliercontact']);
            $correo = trim($_POST['supplieremail']);
            $telefono = intval(trim($_POST['suppliernumber']));
            $direccion = trim($_POST['supplieraddress']);
            $estado = intval($_POST['state']);

            if ($supplierModel->updateSupplier($id, $nombre, $contacto, $correo, $estado, $telefono, $direccion)) {
                $_SESSION['success'] = "✅ Proveedor actualizado correctamente.";
            } else {
                $_SESSION['error'] = "❌ Error al actualizar el proveedor.";
            }

            header("Location: supplierController.php?action=index");
            exit;
        } else {
            die("Acceso no permitido.");
        }
        break;


    case 'create':
        $estados = $catalogModel->getAllEstados();
        require '../../views/admin/supplier-mgmt/add-supplier.php';
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['suppliername']);
            $contacto = trim($_POST['suppliercontact']);
            $correo = trim($_POST['supplieremail']);
            $estado = intval($_POST['state']);
            $telefono = intval(trim($_POST['suppliernumber']));

            if ($supplierModel->addSupplier($nombre, $contacto, $correo, $estado, $telefono)) {
                $_SESSION['success'] = "✅ Proveedor agregado correctamente.";
            } else {
                $_SESSION['error'] = "❌ Error al agregar el proveedor.";
            }

            header("Location: supplierController.php?action=index");
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

        $suppliers = $supplierModel->searchSupplierPaginated($query, $limit, $offset);
        $total = $supplierModel->countSuppliers($query);
        $totalPages = ceil($total / $limit);

        require __DIR__ . "/../../views/admin/supplier-mgmt/supplier-mgmt.php";
        break;
}

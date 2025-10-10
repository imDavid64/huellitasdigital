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
    case 'index':
        $suppliers = $supplierModel->getAllSuppliers();
        require '../../views/admin/supplier-mgmt/supplier-mgmt.php';
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


    default:
        echo "Acción no válida";
}

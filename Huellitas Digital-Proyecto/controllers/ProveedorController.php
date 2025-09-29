<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/ProveedorModel.php';

$model = new ProveedorModel($pdo);

$action = $_GET['action'] ?? '';
switch($action){

    case 'create':
        $model->crear($_POST['nombre'], $_POST['contacto'],
                      $_POST['telefono'], $_POST['correo']);
        header("Location: ../pages/proveedores/index.php");
        break;

    case 'update':
        $model->actualizar($_POST['id'], $_POST['nombre'], $_POST['contacto'],
                           $_POST['telefono'], $_POST['correo']);
        header("Location: ../pages/proveedores/index.php");
        break;

    case 'delete': // Desactivar
        $model->cambiarEstado($_GET['id'], 'inactivo');
        header("Location: ../pages/proveedores/index.php");
        break;

    case 'activate': // Activar
        $model->cambiarEstado($_GET['id'], 'activo');
        header("Location: ../pages/proveedores/index.php");
        break;

    default:
        header("Location: ../pages/proveedores/index.php");
}

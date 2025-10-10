<?php
include_once __DIR__ . "/../../models/conexionDB.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        require '../../views/admin/home.php';
        break;


    default:
        echo "Acción no válida";

}
?>
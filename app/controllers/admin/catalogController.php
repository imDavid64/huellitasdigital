<?php
include_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/admin/catalogModel.php";

header('Content-Type: application/json; charset=utf-8');

$db = new ConexionDatabase();
$conn = $db->connectDB();
$catalogModel = new CatalogModel($conn);

// --- Validar acción ---
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'getCantones':
            if (isset($_GET['idProvincia'])) {
                $idProvincia = intval($_GET['idProvincia']);
                $cantones = $catalogModel->getCantonesByProvincia($idProvincia);
                echo json_encode($cantones);
            } else {
                echo json_encode(['error' => 'Falta idProvincia']);
            }
            break;

        case 'getDistritos':
            if (isset($_GET['idCanton'])) {
                $idCanton = intval($_GET['idCanton']);
                $distritos = $catalogModel->getDistritosByCanton($idCanton);
                echo json_encode($distritos);
            } else {
                echo json_encode(['error' => 'Falta idCanton']);
            }
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
} else {
    echo json_encode(['error' => 'No se especificó acción']);
}
?>

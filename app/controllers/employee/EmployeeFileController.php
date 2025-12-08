<?php
namespace App\Controllers\Employee;

use App\Models\Employee\FilesModel;

require_once __DIR__ . '/../../config/bootstrap.php';

class EmployeeFileController
{
    private $filesModel;
    public function __construct()
    {
        $this->filesModel = new FilesModel();

        if (
            !isset($_SESSION['user_role']) ||
            ($_SESSION['user_role'] !== 'EMPLEADO' && $_SESSION['user_role'] !== 'ADMINISTRADOR')
        ) {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }
    }

    public function index()
    {
        $busqueda = isset($_GET['q']) ? trim($_GET['q']) : "";

        $expedientes = $this->filesModel->obtenerExpedientes($busqueda);

        require VIEW_PATH . '/employee/files-mgmt/files-mgmt.php';
    }

    public function ajaxBuscarExpedientes()
    {
        header('Content-Type: application/json');

        $busqueda = $_GET['q'] ?? "";
        $pagina = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limite = 9; // cards por página
        $offset = ($pagina - 1) * $limite;

        // Obtener TODOS los expedientes según búsqueda
        $expedientes = $this->filesModel->obtenerExpedientes($busqueda);

        $total = count($expedientes);

        // Aplicar paginación manual
        $expedientesPaginados = array_slice($expedientes, $offset, $limite);

        echo json_encode([
            "data" => $expedientesPaginados,
            "total" => $total,
            "pagina" => $pagina,
            "limite" => $limite,
            "total_paginas" => ceil($total / $limite)
        ]);
        exit;
    }



}
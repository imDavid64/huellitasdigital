<?php
namespace App\Controllers\Admin;

require_once __DIR__ . '/../../config/bootstrap.php';

class AdminController
{
    public function __construct()
    {
        // ✅ Solo administradores
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }
    }

    public function index()
    {
        require VIEW_PATH . '/admin/home.php';
    }
}
<?php
namespace App\Controllers\Admin;

require_once __DIR__ . '/../../config/bootstrap.php';

class AdminController
{
    public function index()
    {
        require VIEW_PATH . '/admin/home.php';
    }
}
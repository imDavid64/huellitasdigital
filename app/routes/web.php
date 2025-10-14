<?php
$action = $_GET['action'] ?? '';

// Importar controladores según la acción
switch ($action) {
    case 'login':
    case 'logout':
        require_once __DIR__ . '/../controllers/admin/loginController.php';
        $controller = new LoginController();
        break;

    case 'register':
        require_once __DIR__ . '/../controllers/admin/registerController.php';
        $controller = new RegisterController();
        break;

    default:
        header("Location: ../index.php");
        exit;
}

// Ejecutar acción correspondiente
switch ($action) {
    case 'login':
        $controller->login();
        break;

    case 'logout':
        $controller->logout();
        break;

    case 'register':
        $controller->registrarUsuario();
        break;

    default:
        header("Location: ../../../index.php");
        break;
}

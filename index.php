<?php
session_start();

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// ruta del controlador
$controllerFile = "app/controllers/{$controller}Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = ucfirst($controller) . 'Controller';
    $controllerObj = new $controllerClass();

    if (method_exists($controllerObj, $action)) {
        $controllerObj->$action();
    } else {
        die("Acción '$action' no encontrada en el controlador '$controllerClass'.");
    }
} else {
    die("Controlador '$controller' no encontrado.");
}

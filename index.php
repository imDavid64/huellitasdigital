<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/config/bootstrap.php';

// === Parámetros ===
$controllerName = ucfirst($_REQUEST['controller'] ?? 'home') . 'Controller';
$action = $_REQUEST['action'] ?? 'index';

// === Carpetas donde buscar ===
$folders = [
    '',         // raíz: app/controllers/
    'client',   // app/controllers/client/
    'admin',    // app/controllers/admin/
];

$controllerFile = null;
$controllerClass = null;

// === Búsqueda dinámica ===
foreach ($folders as $folder) {
    $path = $folder ? "/app/controllers/{$folder}/{$controllerName}.php"
                    : "/app/controllers/{$controllerName}.php";

    $fullPath = __DIR__ . $path;

    if (file_exists($fullPath)) {
        $controllerFile = $fullPath;
        $namespace = $folder ? "App\\Controllers\\" . ucfirst($folder)
                             : "App\\Controllers";
        $controllerClass = "{$namespace}\\{$controllerName}";
        break;
    }
}

if (!$controllerFile) {
    exit("❌ Archivo del controlador '{$controllerName}' no existe.");
}

require_once $controllerFile;

if (!class_exists($controllerClass)) {
    exit("❌ Clase de controlador '{$controllerClass}' no encontrada.");
}

$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    exit("❌ Acción '{$action}' no encontrada.");
}

$controller->$action();

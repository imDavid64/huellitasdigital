<?php
/**
 * =============================================================
 *  BOOTSTRAP GLOBAL DE HUELLITAS DIGITAL
 * =============================================================
 *  - Detecta entorno (local o producción)
 *  - Configura rutas base globales
 *  - Carga automática de Composer
 *  - Configura manejo de errores
 * =============================================================
 */

// ---------------------------------------------
// DETECCIÓN DEL ENTORNO Y BASE_URL
// ---------------------------------------------
require_once __DIR__ . '/config.php'; // contiene la lógica del $base_url

// Define BASE_URL como constante global
if (!defined('BASE_URL')) {
    define('BASE_URL', $base_url);
}

// ---------------------------------------------
// CONFIGURACIÓN DE ERRORES (solo desarrollo)
// ---------------------------------------------
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    // En producción, los errores se guardan en logs
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../../storage/logs/php-error.log');
}

// ---------------------------------------------
// RUTAS ABSOLUTAS DEL PROYECTO
// ---------------------------------------------
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/../../')); // raíz del proyecto
}

define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', APP_PATH . '/config');
define('MODEL_PATH', APP_PATH . '/models');
define('CONTROLLER_PATH', APP_PATH . '/controllers');
define('VIEW_PATH', APP_PATH . '/views');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// ---------------------------------------------
// AUTOLOAD DE COMPOSER
// ---------------------------------------------
$autoloadPath = ROOT_PATH . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    die('❌ No se encontró el autoload de Composer. Ejecuta: <b>composer install</b>');
}

// ---------------------------------------------
// SESIÓN GLOBAL
// ---------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ---------------------------------------------
// CSRF TOKEN GLOBAL
// ---------------------------------------------
if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('validate_csrf_token')) {
    function validate_csrf_token($token)
    {
        return isset($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }
}

// ---------------------------------------------
// CARGAR VARIABLES DE ENTORNO (.env)
// ---------------------------------------------
$dotenvPath = ROOT_PATH . '/.env';
if (file_exists($dotenvPath)) {
    // Usa la librería vlucas/phpdotenv (Composer)
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
    $dotenv->load();
} else {
    error_log("⚠️ Archivo .env no encontrado en: " . $dotenvPath);
}

// ---------------------------------------------
// ✅ Listo: variables globales disponibles en todo el sistema
// ---------------------------------------------
// BASE_URL  -> '/huellitasdigital' o '' (en producción)
// ROOT_PATH -> 'C:\xampp\htdocs\huellitasdigital'
// VIEW_PATH -> 'C:\xampp\htdocs\huellitasdigital\app\views'
// etc.

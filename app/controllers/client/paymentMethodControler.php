<?php
// paymentMethodController.php
session_start();
require_once __DIR__ . "/../../models/conexionDB.php";
require_once __DIR__ . "/../../models/client/paymentMethodModel.php";
require_once __DIR__ . "/../../models/client/userModel.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /huellitasdigital/login.php");
    exit;
}

$db = new ConexionDatabase();
$conn = $db->connectDB();
$paymentMethodModel = new PaymentMethodModel($conn);
$usuarioModel = new UsuarioModel($conn);

$action = $_GET['action'] ?? 'create';

// Luhn check simple
function luhnValid($number)
{
    $sum = 0;
    $alt = false;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
        $n = intval($number[$i]);
        if ($alt) {
            $n *= 2;
            if ($n > 9)
                $n -= 9;
        }
        $sum += $n;
        $alt = !$alt;
    }
    return ($sum % 10) === 0;
}

switch ($action) {

    case 'create':
    case 'addpaymentMethod': // compat
        $usuario = $usuarioModel->getUsuarioById(intval($_SESSION['user_id']));
        require '../../views/client/userProfile/addPaymentMethod.php';
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: paymentMethodController.php?action=create");
            exit;
        }

        // CSRF
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
            $_SESSION['error'] = "Solicitud inválida (CSRF).";
            header("Location: paymentMethodController.php?action=create");
            exit;
        }

        // Sanitizar/validar
        $idUsuario = intval($_SESSION['user_id']);
        $nombreTitular = trim($_POST['nombre_titular'] ?? '');
        $tipoTarjeta = strtoupper(trim($_POST['tipo_tarjeta'] ?? ''));
        $marcaTarjeta = strtoupper(trim($_POST['marca_tarjeta'] ?? ''));
        $numeroTarjeta = preg_replace('/\D+/', '', $_POST['numero_tarjeta'] ?? '');
        $fechaVenc = trim($_POST['fecha_vencimiento'] ?? ''); // formato AAAA-MM
        $cvv = preg_replace('/\D+/', '', $_POST['cvv'] ?? '');
        $esPredet = isset($_POST['es_predeterminado']) ? 1 : 0;
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;

        // Reglas
        if (
            $nombreTitular === '' || !in_array($tipoTarjeta, ['CREDITO', 'DEBITO'], true)
            || !in_array($marcaTarjeta, ['VISA', 'MASTERCARD', 'AMEX', 'DINERS', 'OTHER'], true)
            || $numeroTarjeta === '' || $fechaVenc === '' || $cvv === ''
        ) {
            $_SESSION['error'] = "Todos los campos marcados con * son obligatorios.";
            header("Location: paymentMethodController.php?action=create");
            exit;
        }

        if (strlen($numeroTarjeta) < 13 || strlen($numeroTarjeta) > 19 || !ctype_digit($numeroTarjeta)) {
            $_SESSION['error'] = "Número de tarjeta inválido (debe tener entre 13 y 19 dígitos).";
            header("Location: paymentMethodController.php?action=create");
            exit;
        }

        // Luhn
        if (!luhnValid($numeroTarjeta)) {
            $_SESSION['error'] = "Número de tarjeta inválido (falla validación Luhn).";
            header("Location: paymentMethodController.php?action=create");
            exit;
        }

        // Fecha vencimiento: AAAA-MM → último día del mes
        if (!preg_match('/^\d{4}-\d{2}$/', $fechaVenc)) {
            $_SESSION['error'] = "Fecha de vencimiento inválida (use AAAA-MM).";
            header("Location: paymentMethodController.php?action=create");
            exit;
        }
        // Validar que sea futura
        $ymNow = (new DateTime('first day of this month'))->format('Y-m');
        if ($fechaVenc < $ymNow) {
            $_SESSION['error'] = "La tarjeta está vencida.";
            header("Location: paymentMethodController.php?action=create");
            exit;
        }

        // CVV 3-4 dígitos
        if (!preg_match('/^\d{3,4}$/', $cvv)) {
            $_SESSION['error'] = "CVV inválido (3 o 4 dígitos).";
            header("Location: paymentMethodController.php?action=create");
            exit;
        }

        // Insertar (el trigger cifrará número y CVV)
        try {
            $newId = $paymentMethodModel->addPaymentMethod(
                $idUsuario,
                $tipoTarjeta,
                $marcaTarjeta,
                $nombreTitular,
                $numeroTarjeta,    // se envía plano; trigger lo cifra
                $fechaVenc,        // AAAA-MM
                $cvv,              // se envía plano; trigger lo cifra
                $esPredet,
                $ip
            );

            // Borrar variables sensibles en memoria (mejor práctica)
            $numeroTarjeta = $cvv = null;

            if ($newId) {
                $_SESSION['success'] = "✅ Método de pago agregado correctamente.";
                header("Location: /huellitasdigital/app/controllers/client/userController.php?action=index");
            } else {
                $_SESSION['error'] = "❌ No se pudo agregar el método de pago.";
                header("Location: paymentMethodController.php?action=create");
            }
            exit;

        } catch (Throwable $e) {
            // Mensaje genérico para no filtrar detalles de validación internos
            $_SESSION['error'] = "❌ Error al guardar el método de pago.";
            header("Location: paymentMethodController.php?action=create");
            exit;
        }

    default:
        header("Location: paymentMethodController.php?action=create");
        exit;
}

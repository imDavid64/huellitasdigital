<?php
require_once __DIR__ . '/../../../../services/paypalService.php';
require_once __DIR__ . '/../../../../models/paymentModel.php';

$paypal = new PaypalService();
$paymentModel = new PaymentModel($conn);

$action = $_GET['action'] ?? 'create';

switch ($action) {
    case 'create':
        $amount = $_POST['amount'];
        $order = $paypal->createOrder($amount);
        echo json_encode($order);
        break;

    case 'success':
        // Guardar en base de datos
        $paymentModel->savePayment($_GET['orderID'], 'PayPal', $amount, 'COMPLETADO');
        header("Location: /huellitasdigital/app/views/client/checkout/paypal-success.php");
        break;

    case 'cancel':
        header("Location: /huellitasdigital/app/views/client/checkout/paypal-cancel.php");
        break;
}

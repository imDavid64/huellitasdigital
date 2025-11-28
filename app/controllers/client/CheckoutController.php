<?php
namespace App\Controllers\Client;

use App\Models\Client\CheckoutModel;
use App\Models\Admin\CatalogModel;
use App\Models\Client\CartModel;
use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;
use App\Models\Client\UserModel;
use App\Config\FirebaseConfig;
use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/../../config/bootstrap.php';

class CheckoutController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=loginForm");
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->getUsuarioById($_SESSION['user_id']); // ✅ Cargar info usuario

        // Guardar temporalmente en sesión o pasar directo a la vista
        $_SESSION['user_nombre'] = $user['USUARIO_NOMBRE'] ?? '';
        $_SESSION['user_correo'] = $user['USUARIO_CORREO'] ?? '';
        $_SESSION['user_telefono'] = $user['USUARIO_TELEFONO'] ?? '';

        $cartModel = new CartModel();
        $productModel = new ProductModel();
        $serviceModel = new ServiceModel();
        $checkoutModel = new CheckoutModel();
        $catalogModel = new CatalogModel();

        // === Listas dinámicas ===
        $provincias = $catalogModel->getAllProvincias();
        $cantones = $catalogModel->getCantonesByProvincia($user['ID_DIRECCION_PROVINCIA_FK'] ?? null);
        $distritos = $catalogModel->getDistritosByCanton($user['ID_DIRECCION_CANTON_FK'] ?? null);

        $services = $serviceModel->getAllActiveServices();
        $categories = $productModel->getAllActiveCategories();
        $cartItems = $cartModel->getCartByUser($_SESSION['user_id']);
        $totals = $cartModel->calculateCartTotals($_SESSION['user_id'], 2000);

        require __DIR__ . '/../../views/client/checkout/checkout_multistep.php';
    }

    private function validarCamposRequeridos($campos)
    {
        foreach ($campos as $nombre => $valor) {
            if (!isset($valor) || trim($valor) === '') {
                return "El campo '$nombre' es obligatorio.";
            }
        }
        return true;
    }



    public function procesar()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Sesión expirada.']);
            return;
        }

        $userId = (int) $_SESSION['user_id'];
        $direccion = [
            'provincia' => $_POST['provincia'] ?? '',
            'canton' => $_POST['canton'] ?? '',
            'distrito' => $_POST['distrito'] ?? '',
            'sennas' => $_POST['sennas'] ?? ''
        ];

        $validacionDireccion = $this->validarCamposRequeridos([
            'provincia' => $direccion['provincia'],
            'canton' => $direccion['canton'],
            'distrito' => $direccion['distrito'],
            'sennas' => $direccion['sennas']
        ]);

        if ($validacionDireccion !== true) {
            echo json_encode(['success' => false, 'message' => $validacionDireccion]);
            return;
        }


        $pago = [
            'metodo' => $_POST['metodo_pago'] ?? '',
            'tarjeta_id' => $_POST['tarjeta_id'] ?? null,
            'costo_envio' => 2000
        ];

        $metodosValidos = ['PAYPAL', 'TRANSFERENCIA'];

        if (!in_array($pago['metodo'], $metodosValidos)) {
            echo json_encode([
                'success' => false,
                'message' => 'Método de pago inválido o no seleccionado.'
            ]);
            return;
        }


        // ======================================================
        // VALIDACIÓN + SUBIDA DEL COMPROBANTE (TRANSFERENCIA)
        // ======================================================
        $comprobanteUrl = null;

        if ($pago['metodo'] === 'TRANSFERENCIA') {

            if (
                !isset($_FILES['comprobante_transferencia']) ||
                $_FILES['comprobante_transferencia']['error'] !== 0
            ) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Debes subir el comprobante de pago para continuar.'
                ]);
                return;
            }

            $fileTmp = $_FILES['comprobante_transferencia']['tmp_name'];
            $fileName = uniqid('comprobante_') . "_" . $_FILES['comprobante_transferencia']['name'];

            // Validar MIME real
            $mime = mime_content_type($fileTmp);
            if (!in_array($mime, ['image/jpeg', 'image/png'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El comprobante debe ser una imagen JPG o PNG válida.'
                ]);
                return;
            }

            // Validar tamaño máximo (2MB)
            if ($_FILES['comprobante_transferencia']['size'] > 2 * 1024 * 1024) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El comprobante no debe exceder los 2 MB.'
                ]);
                return;
            }

            // Subir a Firebase
            $firebase = new FirebaseConfig();
            $comprobanteUrl = $firebase->uploadPaymentReceipt($fileTmp, $fileName);

            error_log("🔥 URL comprobante Firebase: " . $comprobanteUrl);
        }

        // ======================================================
        // PROCESAR EL CHECKOUT (SP)
        // ======================================================
        $checkoutModel = new CheckoutModel();
        $result = $checkoutModel->procesarCheckout($userId, $direccion, $pago);

        if (is_string($result)) {
            echo json_encode(['success' => false, 'message' => $result]);
            return;
        }

        $pedidoId = $result['pedido_id'];
        $codigoPedido = $result['codigo_pedido'];

        // ======================================================
        // REGISTRAR COMPROBANTE DE PAGO EN BD (SI APLICA)
        // ======================================================
        if ($pago['metodo'] === 'TRANSFERENCIA' && $comprobanteUrl) {

            $resComprobante = $checkoutModel->registrarComprobantePago(
                $pedidoId,
                $userId,
                $comprobanteUrl
            );

            if (!$resComprobante['success']) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al guardar el comprobante: ' . $resComprobante['message']
                ]);
                return;
            }
        }

        // ======================================================
        // VERIFICAR SI EL PAGO ESTÁ PAGADO ANTES DE GENERAR FACTURA
        // ======================================================
        $estadoPago = $checkoutModel->getPaymentStatus($pedidoId);

        if ($estadoPago === "PAGADO") {

            try {
                $detalle = $checkoutModel->getOrderDetail($codigoPedido);
                $pedido = $detalle['pedido'];
                $productos = $detalle['productos'];

                $userModel = new UserModel();
                $user = $userModel->getUsuarioById($userId);

                // Render PDF
                $options = new Options();
                $options->set('isRemoteEnabled', true);

                $dompdf = new Dompdf($options);

                ob_start();
                require __DIR__ . '/../../views/client/orders/invoice_template.php';
                $html = ob_get_clean();

                $dompdf->loadHtml($html, 'UTF-8');
                $dompdf->setPaper('A4');
                $dompdf->render();

                $tempPath = sys_get_temp_dir() . '/factura_' . $userId . '_' . time() . '.pdf';
                file_put_contents($tempPath, $dompdf->output());

                // Subir a Firebase
                $firebase = new FirebaseConfig();
                $invoiceUrl = $firebase->uploadInvoicePdf($tempPath, $userId, $pedido['CODIGO_PEDIDO']);

                // Enviar correo
                \App\Helpers\EmailHelper::enviarFacturaCompra(
                    $pedido['USUARIO_CORREO'],
                    $pedido['USUARIO_NOMBRE'],
                    $tempPath
                );

                unlink($tempPath);

            } catch (\Throwable $e) {
                error_log('❌ Error generando/enviando factura: ' . $e->getMessage());
            }
        }
        echo json_encode(['success' => true, 'message' => 'Tu compra se ha realizado correctamente.']);
    }


    public function verificarCarrito()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'No hay sesión activa.'
            ]);
            return;
        }

        $cartModel = new CartModel();
        $cartItems = $cartModel->getCartByUser($_SESSION['user_id']);

        if (empty($cartItems)) {
            echo json_encode([
                'success' => false,
                'message' => 'Tu carrito está vacío. Agrega productos antes de continuar.'
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'message' => 'Carrito válido.'
            ]);
        }
    }
}

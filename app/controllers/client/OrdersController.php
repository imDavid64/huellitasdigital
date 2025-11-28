<?php
namespace App\Controllers\Client;

use App\Models\Client\OrdersModel;
use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;
use App\Config\FirebaseConfig;
use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/../../config/bootstrap.php';

class OrdersController
{

    private $firebase;

    public function __construct()
    {
        $this->firebase = new FirebaseConfig();
    }


    public function list()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=loginForm");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $ordersModel = new OrdersModel();
        $serviceModel = new ServiceModel();
        $productModel = new ProductModel();

        $perPage = 5;
        $currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $offset = ($currentPage - 1) * $perPage;


        $services = $serviceModel->getAllActiveServices();
        $categories = $productModel->getAllActiveCategories();
        $orders = $ordersModel->getOrdersByUserPaginated($userId, $perPage, $offset);
        $totalOrders = $ordersModel->getTotalOrdersByUser($userId);
        $totalPages = ceil($totalOrders / $perPage);

        require __DIR__ . '/../../views/client/orders/list.php';
    }

    public function detail()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=loginForm");
            exit;
        }

        $codigoPedido = $_GET['codigoPedido'] ?? null;

        if (!$codigoPedido) {
            header("Location: " . BASE_URL . "/index.php?controller=orders&action=list");
            exit;
        }

        $ordersModel = new OrdersModel();
        $serviceModel = new ServiceModel();
        $productModel = new ProductModel();

        $comprobante = $ordersModel->getLastPaymentProof($codigoPedido);
        $services = $serviceModel->getAllActiveServices();
        $categories = $productModel->getAllActiveCategories();
        $data = $ordersModel->getOrderDetail($codigoPedido);

        if (!$data['pedido']) {
            header("Location: " . BASE_URL . "/index.php?controller=orders&action=list");
            exit;
        }

        $pedido = $data['pedido'];
        $productos = $data['productos'];

        require __DIR__ . '/../../views/client/orders/detail.php';
    }

    public function invoice()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=loginForm");
            exit;
        }

        $codigoPedido = $_GET['codigoPedido'] ?? null;
        if (!$codigoPedido) {
            header("Location: " . BASE_URL . "/index.php?controller=orders&action=list");
            exit;
        }

        $ordersModel = new OrdersModel();
        $data = $ordersModel->getOrderDetail($codigoPedido);

        $pedido = $data['pedido'];
        $productos = $data['productos'];

        //VALIDACIÓN: SOLO PERMITIR FACTURA SI ESTÁ PAGADO
        if (strtoupper($pedido['ESTADO_PAGO']) !== "PAGADO") {
            die("La factura solo está disponible cuando el pago ha sido confirmado.");
        }

        //VALIDACIÓN: Debe pertenecer al usuario
        if ($pedido['ID_USUARIO_FK'] != $_SESSION['user_id']) {
            die("No tienes permiso para ver esta factura.");
        }

        require __DIR__ . '/../../views/client/orders/invoice.php';
    }


    public function downloadInvoice()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=loginForm");
            exit;
        }

        $codigoPedido = $_GET['codigoPedido'] ?? null;

        if (!$codigoPedido) {
            header("Location: " . BASE_URL . "/index.php?controller=orders&action=list");
            exit;
        }

        $ordersModel = new OrdersModel();
        $data = $ordersModel->getOrderDetail($codigoPedido);

        $pedido = $data['pedido'];
        $productos = $data['productos'];

        // VALIDACIÓN DE PROPIEDAD DEL PEDIDO
        if ($pedido['ID_USUARIO_FK'] != $_SESSION['user_id']) {
            die("No tienes permiso para ver esta factura.");
        }

        // VALIDACIÓN IMPORTANTE: NO PERMITIR FACTURA SI NO ESTÁ PAGADO
        if (strtoupper($pedido['ESTADO_PAGO']) !== "PAGADO") {
            die("La factura solo está disponible cuando el pago ha sido confirmado.");
        }

        // Generar factura normalmente
        ob_start();
        require __DIR__ . '/../../views/client/orders/invoice_template.php';
        $html = ob_get_clean();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', __DIR__ . '/../../../');
        $options->setDefaultFont('DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Factura_{$pedido['CODIGO_PEDIDO']}.pdf", ["Attachment" => true]);
    }


    public function cancelar()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Sesión expirada.']);
            return;
        }

        $pedidoId = $_POST['pedido_id'] ?? null;
        $userId = $_SESSION['user_id'];

        if (!$pedidoId) {
            echo json_encode(['success' => false, 'message' => 'Falta el ID del pedido.']);
            return;
        }

        $ordersModel = new OrdersModel();
        $result = $ordersModel->cancelarPedido($pedidoId, $userId);

        echo json_encode($result);
    }

    public function subirComprobante()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Sesión expirada.']);
            return;
        }

        $pedidoCodigo = $_POST['codigoPedido'] ?? null;
        $userId = $_SESSION['user_id'];

        if (!$pedidoCodigo || empty($_FILES['comprobante'])) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos.']);
            return;
        }

        $ordersModel = new OrdersModel();

        // ⚠️ 1. Obtener comprobante anterior
        $lastProof = $ordersModel->getLastPaymentProof($pedidoCodigo);

        if ($lastProof && $lastProof['ESTADO_VERIFICACION'] === 'RECHAZADO') {

            // Extraer ruta interna real del bucket
            $url = $lastProof['URL_COMPROBANTE'];

            if (preg_match('/\/o\/([^?]+)/', $url, $match)) {
                $firebasePath = urldecode($match[1]); // comprobantes/archivo123.png
                $this->firebase->deleteImage($url);   // usa tu método deleteImage
            }
        }

        // ⚡ 2. Subir nuevo comprobante
        $ext = pathinfo($_FILES['comprobante']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid("cp_") . "." . $ext;

        try {
            $newUrl = $this->firebase->uploadPaymentReceipt(
                $_FILES["comprobante"]["tmp_name"],
                $fileName
            );
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error subiendo archivo a Firebase']);
            return;
        }

        $result = $ordersModel->uploadNewPaymentProof($pedidoCodigo, $userId, $newUrl);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result);
        exit;
    }



}

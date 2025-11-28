<?php
namespace App\Controllers\Admin;

use App\Models\Admin\CatalogModel;
use App\Models\Admin\OrderModel;
use App\Config\FirebaseConfig;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Helpers\EmailHelper;

class AdminOrderController
{
    private CatalogModel $catalogModel;
    private OrderModel $orderModel;

    public function __construct()
    {
        // ✅ Solo administradores
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMINISTRADOR') {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        $this->catalogModel = new CatalogModel();
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $query = '';
        $page = 1;
        $limit = 10;
        $offset = 0;

        $orders = $this->orderModel->searchOrdersPaginated($query, $limit, $offset);
        $total = $this->orderModel->countOrders($query);
        $totalPages = ceil($total / $limit);

        $states = $this->catalogModel->getAllOrderStates();

        require VIEW_PATH . "/admin/order-mgmt/order-mgmt.php";
    }

    // ✅ Búsqueda AJAX (tabla)
    public function search()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $orders = $this->orderModel->searchOrdersPaginated($query, $limit, $offset);
        $total = $this->orderModel->countOrders($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/admin/order-mgmt/partials/order-mgmt.php";
    }

    public function details()
    {
        $codigo = $_GET['codigo'] ?? '';
        if (!$codigo) {
            header("Location: " . BASE_URL . "/index.php?controller=adminOrder&action=index");
            exit;
        }

        $data = $this->orderModel->getOrderByCode($codigo);
        $comprobante = $this->orderModel->getPaymentProof($codigo);

        if (!$data['pedido']) {
            header("Location: " . BASE_URL . "/index.php?controller=adminOrder&action=index");
            exit;
        }

        $pedido = $data['pedido'];
        $productos = $data['productos'];

        $paymentStates = $this->catalogModel->getAllPaymentStates();
        $estados = $this->catalogModel->getAllOrderStates();

        require VIEW_PATH . "/admin/order-mgmt/order-detail.php";
    }


    public function getStates()
    {
        $estados = $this->catalogModel->getAllOrderStates();
        $estadosPago = $this->catalogModel->getAllPaymentStates();

        echo json_encode([
            'success' => true,
            'estados' => $estados,
            'estadosPago' => $estadosPago
        ]);
        exit;
    }

    public function updateStatus()
    {
        $codigoPedido = $_POST['codigoPedido'] ?? '';
        $nuevoEstado = $_POST['nuevoEstado'] ?? '';

        if (empty($codigoPedido) || empty($nuevoEstado)) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
            return;
        }

        // Obtener pedido
        $data = $this->orderModel->getOrderByCode($codigoPedido);
        $pedido = $data['pedido'] ?? null;

        if (!$pedido) {
            echo json_encode(['success' => false, 'message' => 'Pedido no encontrado.']);
            return;
        }

        // Validación: Pago debe estar confirmado
        if (strtoupper($pedido['ESTADO_PAGO']) !== 'PAGADO') {
            echo json_encode([
                'success' => false,
                'message' => 'No puedes cambiar el estado del pedido porque el pago aún no está confirmado.'
            ]);
            return;
        }

        // Validación: Pedido cancelado
        if (strtoupper($pedido['ESTADO_PEDIDO']) === 'CANCELADO') {
            echo json_encode([
                'success' => false,
                'message' => 'No puedes actualizar un pedido cancelado.'
            ]);
            return;
        }

        // Actualizar estado
        $success = $this->orderModel->updateOrderStatus($codigoPedido, $nuevoEstado);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Estado actualizado correctamente.' : 'No se pudo actualizar el estado.'
        ]);
    }


    public function reviewPaymentProofAjax()
    {
        $codigo = $_GET['codigo'] ?? '';

        $comprobante = $this->orderModel->getPaymentProof($codigo);
        $estadoComprobante = $this->catalogModel->getAllPaymentProofStates();

        if (!$comprobante || (isset($comprobante['EXITO']) && $comprobante['EXITO'] == 0)) {

            ob_start();
            ?>
            <p class="text-danger">No se encontró un comprobante para este pedido.</p>
            <?php

            $html = ob_get_clean();
            ob_clean();

            echo json_encode(['html' => $html]);
            return;
        }

        ob_start();

        // Renderizar HTML para archivo
        ?>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Usuario:</strong> <?= htmlspecialchars($comprobante['USUARIO_NOMBRE']) ?></p>
                <p><strong>Correo:</strong> <?= htmlspecialchars($comprobante['USUARIO_CORREO']) ?></p>
                <p><strong>Método de Pago:</strong> <?= htmlspecialchars($comprobante['METODO_PAGO']) ?></p>
                <p><strong>Estado Actual:</strong> <?= htmlspecialchars($comprobante['ESTADO_VERIFICACION']) ?></p>
                <p><strong>Fecha Subida:</strong> <?= htmlspecialchars($comprobante['FECHA_SUBIDA']) ?></p>
                <p><strong>Observaciones:</strong></p>
                <textarea class="form-control" name="observacionesAdmin" id="observacionesAdmin"
                    rows="3"><?= htmlspecialchars($comprobante['OBSERVACIONES_ADMIN'] ?? '') ?></textarea>
            </div>

            <div class="col-md-6 text-center">
                <?php if ($comprobante['URL_COMPROBANTE']): ?>
                    <img src="<?= htmlspecialchars($comprobante['URL_COMPROBANTE']) ?>" class="img-fluid rounded border">
                <?php else: ?>
                    <p class="text-danger">No hay comprobante disponible.</p>
                <?php endif; ?>
            </div>
        </div>

        <hr>

        <h5>Actualizar Estado del Comprobante</h5>

        <?php
        $estadosValidos = ['APROBADO', 'RECHAZADO', 'EN REVISIÓN'];

        foreach ($estadoComprobante as $estado):
            $nombre = strtoupper(trim($estado['ESTADO_DESCRIPCION']));
            if (!in_array($nombre, $estadosValidos))
                continue;
            ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="estadoComprobante" value="<?= $estado['ID_ESTADO_PK'] ?>">
                <label class="form-check-label">
                    <?= htmlspecialchars($estado['ESTADO_DESCRIPCION']) ?>
                </label>
            </div>
        <?php endforeach; ?>


        <?php

        $html = ob_get_clean();
        ob_clean();

        echo json_encode(['html' => $html]);
        exit;
    }

    public function updatePaymentProofStatus()
    {
        $codigoPedido = $_POST['codigoPedido'] ?? null;
        $estado = $_POST['estadoComprobante'] ?? null;
        $obs = $_POST['observacionesAdmin'] ?? '';

        // Obtener comprobante actual
        $current = $this->orderModel->getPaymentProof($codigoPedido);

        if (!$current) {
            echo json_encode([
                'success' => false,
                'message' => 'Comprobante no encontrado.'
            ]);
            return;
        }

        // Evitar re-aprobar
        if (strtoupper($current['ESTADO_VERIFICACION']) === 'APROBADO') {
            echo json_encode([
                'success' => false,
                'message' => 'El comprobante ya está aprobado. No puede volver a modificarse.'
            ]);
            return;
        }

        // Ejecutar SP de actualización
        $resultado = $this->orderModel->updatePaymentProof($codigoPedido, $estado, $obs);

        // ======================================
        // 🔥 SI EL COMPROBANTE SE APROBÓ → ENVIAR FACTURA
        // ======================================
        if ($resultado['EXITO'] == 1) {

            // Volver a cargar comprobante actualizado
            $updated = $this->orderModel->getPaymentProof($codigoPedido);

            if ($updated && strtoupper($updated['ESTADO_VERIFICACION']) === 'APROBADO') {

                try {
                    // 1. Obtener datos completos del pedido
                    $data = $this->orderModel->getOrderByCode($codigoPedido);
                    $pedido = $data['pedido'];
                    $productos = $data['productos'];

                    if ($pedido && !empty($pedido['USUARIO_CORREO'])) {

                        // 2. Generar PDF
                        $options = new Options();
                        $options->set('isRemoteEnabled', true);
                        $options->setDefaultFont('DejaVu Sans');
                        $dompdf = new Dompdf($options);

                        ob_start();
                        require VIEW_PATH . "/client/orders/invoice_template.php";
                        $html = ob_get_clean();

                        $dompdf->loadHtml($html, "UTF-8");
                        $dompdf->setPaper("A4", "portrait");
                        $dompdf->render();

                        // 3. Guardar temporal
                        $tempPath = sys_get_temp_dir() . '/factura_' . $pedido['ID_PEDIDO_PK'] . '_' . time() . '.pdf';
                        file_put_contents($tempPath, $dompdf->output());

                        // 4. Enviar correo
                        EmailHelper::enviarFacturaCompra(
                            $pedido['USUARIO_CORREO'],
                            $pedido['USUARIO_NOMBRE'] ?? '',
                            $tempPath
                        );

                        // 5. Limpiar archivo temporal
                        unlink($tempPath);
                    }

                } catch (\Throwable $e) {
                    error_log("❌ Error enviando factura tras aprobar comprobante: " . $e->getMessage());
                }
            }
        }

        echo json_encode([
            'success' => $resultado['EXITO'],
            'message' => $resultado['MENSAJE']
        ]);
    }



    public function updatePaymentStatus()
    {
        $codigoPedido = $_POST['codigoPedido'] ?? null;
        $nuevoEstadoId = $_POST['nuevoEstadoPago'] ?? null;

        if (!$codigoPedido || !$nuevoEstadoId) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
            return;
        }

        // 1️⃣ Obtener descripción del estado seleccionado (PAGADO, EN REVISIÓN, etc.)
        $descripcionEstado = null;
        $paymentStates = $this->catalogModel->getAllPaymentStates();

        foreach ($paymentStates as $st) {
            if ((int) $st['ID_ESTADO_PK'] === (int) $nuevoEstadoId) {
                $descripcionEstado = strtoupper(trim($st['ESTADO_DESCRIPCION']));
                break;
            }
        }

        if ($descripcionEstado === null) {
            echo json_encode([
                'success' => false,
                'message' => 'Estado de pago no válido.'
            ]);
            return;
        }

        // 2️⃣ Obtener pago asociado al pedido
        $pago = $this->orderModel->getPaymentByOrderCode($codigoPedido);

        if (!$pago || empty($pago['ID_PAGO_PK'])) {
            echo json_encode([
                'success' => false,
                'message' => 'No se encontró un pago asociado al pedido.'
            ]);
            return;
        }

        $idPago = (int) $pago['ID_PAGO_PK'];

        // 3️⃣ Ejecutar actualización de estado de pago
        $resultado = $this->orderModel->updatePaymentStatus($idPago, $nuevoEstadoId);

        // 4️⃣ SI el nuevo estado es PAGADO → generar y enviar factura
        if ($descripcionEstado === 'PAGADO') {
            try {
                // Obtener detalle completo del pedido
                $data = $this->orderModel->getOrderByCode($codigoPedido);
                $pedido = $data['pedido'] ?? null;
                $productos = $data['productos'] ?? [];

                if ($pedido && !empty($pedido['USUARIO_CORREO'])) {

                    // Configurar Dompdf
                    $options = new Options();
                    $options->set('isRemoteEnabled', true);
                    $options->setDefaultFont('DejaVu Sans');

                    $dompdf = new Dompdf($options);

                    // Renderizar plantilla de factura
                    // IMPORTANTE: invoice_template.php usa $pedido y $productos
                    ob_start();
                    require VIEW_PATH . "/client/orders/invoice_template.php";
                    $html = ob_get_clean();

                    $dompdf->loadHtml($html, 'UTF-8');
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();

                    // Guardar PDF temporalmente
                    $tempPath = sys_get_temp_dir() . '/factura_' . $pedido['ID_PEDIDO_PK'] . '_' . time() . '.pdf';
                    file_put_contents($tempPath, $dompdf->output());

                    // Enviar correo con la factura adjunta
                    EmailHelper::enviarFacturaCompra(
                        $pedido['USUARIO_CORREO'],
                        $pedido['USUARIO_NOMBRE'] ?? '',
                        $tempPath
                    );

                    // Borrar archivo temporal
                    if (file_exists($tempPath)) {
                        unlink($tempPath);
                    }
                } else {
                    error_log("⚠️ No se pudo enviar factura: pedido sin datos de usuario/correo. Código: $codigoPedido");
                }

            } catch (\Throwable $e) {
                error_log('❌ Error generando/enviando factura desde Admin: ' . $e->getMessage());
                // No rompemos la respuesta al admin, solo lo dejamos registrado en logs
            }
        }

        echo json_encode([
            'success' => true,
            'message' => $resultado['MENSAJE'] ?? 'Estado de pago actualizado.'
        ]);
    }

}

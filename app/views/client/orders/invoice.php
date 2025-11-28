<?php
require_once __DIR__ . '/../../../config/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Vista previa de factura | Huellitas Digital</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f6f7fb;">

    <div class="container my-4 text-center">
        <h2 class="mb-3" style="color: #002557;">Vista previa de factura</h2>
        <div class="mb-3">
            <a href="<?= BASE_URL ?>/index.php?controller=orders&action=downloadInvoice&codigoPedido=<?= $pedido['CODIGO_PEDIDO'] ?>"
                class="btn btn-dark-blue me-2" target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
            </a>
            <a href="<?= BASE_URL ?>/index.php?controller=orders&action=list" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver a mis pedidos
            </a>
        </div>

        <iframe srcdoc="<?php
        ob_start();
        include __DIR__ . '/invoice_template.php';
        echo htmlspecialchars(ob_get_clean());
        ?>" width="100%" height="1000" style="border:1px solid #ccc; border-radius:10px;"></iframe>
    </div>

</body>

</html>
<?php
/**
 * Plantilla unificada de factura para Huellitas Digital 🐾
 * Puede ser usada por la vista previa y por Dompdf.
 */
?>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('<?= BASE_URL ?>/public/assets/Poppins/Poppins-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('<?= BASE_URL ?>/public/assets/Poppins/Poppins-Medium.ttf') format('truetype');
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('<?= BASE_URL ?>/public/assets/Poppins/Poppins-Bold.ttf') format('truetype');
            font-weight: 700;
            font-style: normal;
        }

        body {
            font-family: 'DejaVu Sans', 'Poppins', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .invoice-container {
            background: #fff;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
        }

        .invoice-header {
            text-align: center;
            border-bottom: 3px solid #004AAD;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .invoice-header img {
            width: 130px;
            margin-bottom: 5px;
        }

        .invoice-header h1 {
            color: #004AAD;
            font-size: 22px;
            margin-top: 5px;
        }

        .info-box {
            border: 1px solid #d0d7ff;
            border-radius: 8px;
            padding: 15px;
            background: #f9faff;
            margin-bottom: 15px;
        }

        .info-box h4 {
            color: #004AAD;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #004AAD;
            color: white;
            padding: 8px;
            font-size: 13px;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ccc;
        }

        tr:nth-child(even) {
            background: #f4f6ff;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
        }

        .total-section p {
            font-size: 14px;
            margin: 3px 0;
        }

        .grand-total {
            color: #004AAD;
            font-size: 16px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">

        <!-- ENCABEZADO -->
        <div class="invoice-header">
            <img src="<?= BASE_URL ?>/public/assets/images/Logo-AzulOscuro.png" alt="Logo Veterinaria Dra. Huellitas"
                width="130">
            <h1>Factura Electrónica</h1>
            <p><strong>Código:</strong> <?= htmlspecialchars($pedido['CODIGO_PEDIDO']) ?></p>
        </div>

        <!-- DATOS DEL CLIENTE -->
        <div class="info-box">
            <h4>Datos del Cliente</h4>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($pedido['USUARIO_NOMBRE']) ?></p>
            <p><strong>Correo:</strong> <?= htmlspecialchars($pedido['USUARIO_CORREO']) ?></p>
            <p><strong>Fecha del Pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['FECHA_PEDIDO'])) ?></p>
        </div>

        <!-- DIRECCIÓN -->
        <div class="info-box">
            <h4>Dirección de Envío</h4>
            <p><?= htmlspecialchars($pedido['ENVIO_PROVINCIA']) ?>,
                <?= htmlspecialchars($pedido['ENVIO_CANTON']) ?>,
                <?= htmlspecialchars($pedido['ENVIO_DISTRITO']) ?>
            </p>
            <p><strong>Señas:</strong> <?= htmlspecialchars($pedido['ENVIO_SENNAS']) ?></p>
        </div>

        <!-- PRODUCTOS -->
        <h4 style="color:#004AAD;">Detalle de Productos</h4>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $prod): ?>
                    <tr>
                        <td><?= htmlspecialchars($prod['PRODUCTO_NOMBRE']) ?></td>
                        <td><?= $prod['CANTIDAD'] ?></td>
                        
                        <td>&#8353;<?= number_format($prod['PRECIO_UNITARIO'], 2, ',', '.') ?></td>
                        <td>&#8353;<?= number_format($prod['SUBTOTAL'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- TOTALES -->
        <div class="total-section">
            <p><strong>Subtotal:</strong> &#8353;<?= number_format($pedido['TOTAL'] * 0.87, 2, ',', '.') ?></p>
            <p><strong>IVA (13%):</strong> &#8353;<?= number_format($pedido['TOTAL'] * 0.13, 2, ',', '.') ?></p>
            <p class="grand-total">Total: &#8353;<?= number_format($pedido['TOTAL'], 2, ',', '.') ?></p>
        </div>

        <!-- PIE -->
        <div class="footer">
            <p>🐾 Gracias por confiar en <strong>Huellitas Digital</strong></p>
            <p>Tel: +506 2102-8142 | drahuellitas@gmail.com</p>
            <p>Este documento es una representación digital sin validez fiscal.</p>
        </div>
    </div>
</body>

</html>
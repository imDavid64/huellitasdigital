<table class="table">
    <thead>
        <tr>
            <th scope="col">Código Pedido</th>
            <th scope="col">Cliente</th>
            <th scope="col">Correo</th>
            <th scope="col">Fecha</th>
            <th scope="col">Estado Pago</th>
            <th scope="col">Estado Pedido</th>
            <th class="text-center" scope="col" style="width: 150px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td>
                    <div class="admin-table-text-limit">
                        <?= $order['CODIGO_PEDIDO'] ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($order['CLIENTE']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($order['CORREO']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($order['FECHA_PEDIDO']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?php
                        $estado = strtoupper($order['ESTADO_PAGO']);
                        $badgeClass = match ($estado) {
                            'PENDIENTE' => 'bg-warning text-dark',
                            'EN PREPARACIÓN' => 'bg-info text-dark',
                            'ENVIADO' => 'bg-primary',
                            'ENTREGADO' => 'bg-success',
                            'CANCELADO' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($estado) ?></span>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?php
                        $estado = strtoupper($order['ESTADO_PEDIDO']);
                        $badgeClass = match ($estado) {
                            'PENDIENTE' => 'bg-warning text-dark',
                            'EN PREPARACIÓN' => 'bg-info text-dark',
                            'ENVIADO' => 'bg-primary',
                            'ENTREGADO' => 'bg-success',
                            'CANCELADO' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($estado) ?></span>
                    </div>
                </td>
                <td class="text-center">
                    <a href="<?= BASE_URL ?>/index.php?controller=adminOrder&action=details&codigo=<?= $order['CODIGO_PEDIDO'] ?>"
                        class="btn-dark-blue"> Ver Detalles
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<table class="table">
    <thead>
        <tr>
            <th>Cod Cliente</th>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>|</th>
            <th>Mascotas</th>
            <th class="text-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($clientes)): ?>
            <tr>
                <td colspan="8" class="text-center">No se encontraron registros.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['CODIGO']) ?></td>
                    <td><span class="badge <?= $cliente['TIPO'] === 'USUARIO' ? 'bg-info' : 'bg-secondary' ?>">
                            <?= htmlspecialchars($cliente['TIPO']) ?></span></td>
                    <td><?= htmlspecialchars($cliente['NOMBRE']) ?></td>
                    <td><?= htmlspecialchars($cliente['CORREO']) ?></td>
                    <td><?= htmlspecialchars($cliente['ESTADO']) ?></td>
                    <th>|</th>
                    <td>
                        <?php if ($cliente['TOTAL_MASCOTAS'] > 0): ?>
                            <?= htmlspecialchars($cliente['NOMBRES_MASCOTAS']) ?>
                        <?php else: ?>
                            <span class="badge bg-secondary">Sin mascotas</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="<?= BASE_URL ?>/index.php?controller=employeeClient&action=details&codigo=<?= $cliente['CODIGO'] ?>&tipo=<?= $cliente['TIPO'] ?>"
                            class="btn btn-dark-blue btn-sm">
                            Ver Cliente<i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>

</table>
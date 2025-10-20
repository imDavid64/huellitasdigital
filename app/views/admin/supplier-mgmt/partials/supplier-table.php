<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre de la Empresa</th>
            <th scope="col">Contacto</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Correo Electrónico</th>
            <th scope="col">Estado</th>
            <th class="text-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($suppliers as $supplier): ?>
            <tr>
                <td>
                    <div class="admin-table-text-limit">
                        <?= $supplier['ID_PROVEEDOR_PK'] ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($supplier['PROVEEDOR_NOMBRE']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($supplier['NOMBRE_REPRESENTANTE']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($supplier['TELEFONO_CONTACTO']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($supplier['PROVEEDOR_CORREO']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= $supplier['ESTADO'] ?>
                    </div>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <a href="../../../app/controllers/admin/supplierController.php?action=edit&id=<?= $supplier['ID_PROVEEDOR_PK'] ?>"
                            class="btn btn-dark-blue btn-sm">
                            Editar <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
</table>
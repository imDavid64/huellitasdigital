<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Estado</th>
            <th class="d-flex justify-content-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roles as $role): ?>
            <tr>
                <td>
                    <div class="admin-table-text-limit">
                        <?= $role['ID_ROL_USUARIO_PK'] ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($role['DESCRIPCION_ROL_USUARIO']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($role['ESTADO']) ?>
                    </div>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <a href="../../../app/controllers/admin/roleController.php?action=edit&id=<?= $role['ID_ROL_USUARIO_PK'] ?>"
                            class="btn btn-dark-blue btn-sm">
                            Editar <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
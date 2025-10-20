<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo Electrónico</th>
            <th scope="col">Rol</th>
            <th scope="col">Estado</th>
            <th class="text-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($usuario['ID_USUARIO_PK']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($usuario['USUARIO_NOMBRE']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit"></div>
                    <?= htmlspecialchars($usuario['USUARIO_CORREO']) ?>
                </td>
                <div class="admin-table-text-limit">
                    <td><?= htmlspecialchars($usuario['ROL']) ?></td>
                </div>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($usuario['ESTADO']) ?>
                    </div>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <a href="../../../app/controllers/admin/userController.php?action=edit&id=<?= $usuario['ID_USUARIO_PK'] ?>"
                            class="btn btn-dark-blue btn-sm">Editar <i class="bi bi-pencil-square"></i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
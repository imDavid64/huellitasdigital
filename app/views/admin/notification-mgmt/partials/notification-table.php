<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Titulo</th>
            <th scope="col">Mensaje</th>
            <th scope="col">Tipo de Notificacion</th>
            <th scope="col">Prioridad</th>
            <th class="d-flex justify-content-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($notifications as $notification): ?>
            <tr>
                <td>
                    <div class="admin-table-text-limit">
                        <?= $notification['ID_NOTIFICACION_PK'] ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($notification['TITULO_NOTIFICACION']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($notification['MENSAJE_NOTIFICACION']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($notification['TIPO_NOTIFICACION']) ?>
                    </div>
                </td>
                <td>
                    <div class="admin-table-text-limit">
                        <?= htmlspecialchars($notification['PRIORIDAD']) ?>
                    </div>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <a href="<?= BASE_URL ?>/index.php?controller=adminNotification&action=edit&id=<?= $notification['ID_NOTIFICACION_PK'] ?>"
                            class="btn btn-dark-blue btn-sm">
                            Editar <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
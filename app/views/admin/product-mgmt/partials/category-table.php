<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Estado</th>
            <th class="text-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['ID_CATEGORIA_PK'] ?></td>
                <td><?= htmlspecialchars($category['DESCRIPCION_CATEGORIA']) ?></td>
                <td><?= htmlspecialchars($category['ESTADO']) ?></td>
                <td class="text-center">
                    <div class="btn-group" category="group">
                        <a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=editCategory&id=<?= $category['ID_CATEGORIA_PK'] ?>"
                            class="btn btn-dark-blue btn-sm">
                            Editar <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
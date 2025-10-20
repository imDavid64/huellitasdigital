<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Logo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Estado</th>
            <th class="text-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($brands as $brand): ?>
            <tr>
                <td><?= $brand['ID_MARCA_PK'] ?></td>
                <td><img src="<?= htmlspecialchars($brand['MARCA_IMAGEN_URL']) ?>"
                        style="min-width: 70px; min-height: 70px; max-width: 70px; max-height: 70px;">
                </td>
                <td><?= htmlspecialchars($brand['NOMBRE_MARCA']) ?></td>
                <td><?= htmlspecialchars($brand['ESTADO']) ?></td>
                <td class="text-center">
                    <div class="btn-group" brand="group">
                        <a href="/huellitasdigital/app/controllers/admin/productController.php?action=editBrand&id=<?= $brand['ID_MARCA_PK'] ?>"
                            class="btn btn-dark-blue btn-sm">
                            Editar <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
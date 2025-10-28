<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Foto</th>
            <th scope="col">Nombre</th>
            <th scope="col">Categoría</th>
            <th scope="col">Precio</th>
            <th scope="col">Stock</th>
            <th scope="col">Descripción</th>
            <th scope="col">Proveedor</th>
            <th scope="col">Estado</th>
            <th class="text-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <div class="admin-table-text-limit">
                            <?= htmlspecialchars($product['ID_PRODUCTO_PK']) ?>
                        </div>
                    </td>
                    <td>
                        <img src="<?= htmlspecialchars($product['IMAGEN_URL']) ?>"
                            style="min-width: 70px; min-height: 70px; max-width: 70px; max-height: 70px;">
                    </td>
                    <td>
                        <div class="admin-table-text-limit">
                            <?= htmlspecialchars($product['PRODUCTO_NOMBRE']) ?>
                        </div>
                    </td>
                    <td>
                        <div class="admin-table-text-limit">
                            <?= htmlspecialchars($product['CATEGORIA']) ?>
                        </div>
                    </td>
                    <td>
                        <div class="admin-table-text-limit">₡<?= $product['PRODUCTO_PRECIO_UNITARIO'] ?>
                        </div>
                    </td>
                    <td>
                        <div class="admin-table-text-limit">
                            <?= htmlspecialchars($product['PRODUCTO_STOCK']) ?>
                        </div>
                    </td>
                    <td>
                        <div class="admin-table-text-limit">
                            <?= htmlspecialchars($product['PRODUCTO_DESCRIPCION']) ?>
                        </div>
                    </td>
                    <td>
                        <div class="admin-table-text-limit">
                            <?= htmlspecialchars($product['PROVEEDOR']) ?>
                        </div>
                    </td>
                    <td>
                        <div class="admin-table-text-limit"><?= htmlspecialchars($product['ESTADO']) ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" product="group">
                            <a href="<?= BASE_URL ?>/index.php?controller=adminProduct&action=edit&id=<?= $product['ID_PRODUCTO_PK'] ?>"
                                class="btn btn-dark-blue btn-sm">
                                Editar <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10" class="text-center text-muted">No se encontraron resultados</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <?php require __DIR__ . '/product-card.php'; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center mt-4">No se encontraron productos con los filtros seleccionados.</p>
<?php endif; ?>
<div class="cards product-item">
    <a href="<?= BASE_URL ?>/index.php?controller=product&action=productsDetails&id=<?= $product['ID_PRODUCTO_PK'] ?>">
        <div>
            <div class="card-img">
                <img src="<?= htmlspecialchars($product['IMAGEN_URL'] ?? 'assets/images/no-img.png') ?>"
                    alt="<?= htmlspecialchars($product['NOMBRE_PRODUCTO'] ?? '') ?>"
                    style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div class="card-name">
                <?= htmlspecialchars($product['PRODUCTO_NOMBRE'] ?? 'Sin nombre') ?>
            </div>
            <div class="card-description product-description">
                <?= htmlspecialchars($product['PRODUCTO_DESCRIPCION'] ?? '') ?>
            </div>
        </div>
        <div class="card-price">
            ₡<?= number_format($product['PRODUCTO_PRECIO_UNITARIO'], 2, ',', '.' ?? 'Sin precio') ?>
        </div>
    </a>
    <div class="card-button">
        <?php if (isset($_SESSION['user_id'])): ?>
            <button class="btn-orange btnAddToCart" data-id="<?= htmlspecialchars($product['ID_PRODUCTO_PK']) ?>"
                <?= ($product['PRODUCTO_STOCK'] <= 0 ? 'disabled' : '') ?>>
                <?= ($product['PRODUCTO_STOCK'] <= 0 ? 'Sin stock' : 'Añadir al Carrito') ?>
            </button>
        <?php else: ?>
            <a class="btn-orange btnLogin" href="#">Añadir al Carrito</a>
        <?php endif; ?>
    </div>
</div>
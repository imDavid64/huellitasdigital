<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/ProveedorModel.php';
$model = new ProveedorModel($pdo);
$p = $model->obtener($_GET['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Proveedor</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Editar Proveedor</h2>
    <form action="../../controllers/ProveedorController.php?action=update" method="POST">
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <div class="mb-3">
            <label>Nombre de la Empresa</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($p['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Contacto</label>
            <input type="text" name="contacto" class="form-control" value="<?= htmlspecialchars($p['contacto']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($p['telefono']) ?>">
        </div>
        <div class="mb-3">
            <label>Correo Electrónico</label>
            <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($p['correo']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>

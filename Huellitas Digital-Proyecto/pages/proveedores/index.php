<?php
require_once __DIR__ . '/../../models/ProveedorModel.php';
require_once __DIR__ . '/../../config/db.php';

$model = new ProveedorModel($pdo);
$proveedores = $model->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../assets/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<header class="main-header">
    <nav class="header-container-admin">
        <div class="header-container-left">
            <a href="../home.php" class="header-logo-admin">
                <img src="../../assets/images/logo.png" alt="Logo">
                <span>Huellitas<br><strong>Digital</strong></span>
            </a>
        </div>
        <div class="header-container-right">
            <div class="header-menu-icon">
                <button class="header-user-img header-user-admin" id="header-user-img">
                    <i class="bi bi-person-fill"></i>
                </button>
                <div class="header-user-menu" id="header-user-menu">
                    <ul>
                        <li><a href="../profile.php">Mi Perfil</a></li>
                        <li><a href="../../index_unlogin.php" style="color: red;">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<main>
<section class="admin-main">
    <!-- ASIDE -->
    <aside class="admin-aside">
        <div class="aside-container">
            <div class="aside-main">
                <ul>
                    <li><a href="../home.php"><i class="bi bi-opencollective"></i>Dashboard</a></li>
                    <li><a href="../usuarios/index.php"><i class="bi bi-people-fill"></i>Gestión de Usuarios</a></li>
                    <li><a href="../roles/index.php"><i class="bi bi-diagram-2-fill"></i>Gestión de Roles</a></li>
                    <li><a class="active" href="index.php"><i class="bi bi-building-fill"></i>Gestión de Proveedores</a></li>
                    <!-- … otros menús … -->
                </ul>
            </div>
            <hr />
            <div class="aside-footer">
                <a class="btn-dark-blue" href="../../index_unlogin.php"><strong>Cerrar Sesión</strong></a>
            </div>
        </div>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <section class="admin-main-content">
        <div class="tittles d-flex justify-content-between align-items-center">
            <h2><i class="bi bi-building-fill"></i><strong> Gestión de Proveedores</strong></h2>
            <a href="create.php" class="btn-blue"><strong>Agregar Proveedor</strong>
                <i class="bi bi-building-fill-add"></i>
            </a>
        </div>

        <section class="admin-main-content-mgmt">
            <div class="search mb-3">
                <input type="text" id="header-search" placeholder="Buscar proveedor...">
                <i class="bi bi-search"></i>
            </div>

            <div class="admin-mgmt-table table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre de la Empresa</th>
                            <th>Contacto</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($proveedores)>0): ?>
                            <?php foreach($proveedores as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= htmlspecialchars($p['nombre']) ?></td>
                                <td><?= htmlspecialchars($p['contacto']) ?></td>
                                <td><?= htmlspecialchars($p['telefono'] ?? '') ?></td>
                                <td><?= htmlspecialchars($p['correo'] ?? '') ?></td>
                                <td><?= ucfirst($p['estado']) ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-dark-blue btn-sm">
                                            Editar <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <?php if($p['estado']=='activo'): ?>
                                            <a href="../../controllers/ProveedorController.php?action=delete&id=<?= $p['id'] ?>"
                                               class="btn btn-black btn-sm"
                                               onclick="return confirm('¿Desactivar este proveedor?')">
                                                Desactivar <i class="bi bi-dash-square"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="../../controllers/ProveedorController.php?action=activate&id=<?= $p['id'] ?>"
                                               class="btn btn-black btn-sm">
                                                Activar <i class="bi bi-plus-square"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">No hay proveedores registrados</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</section>
</main>

<footer>
    <div class="post-footer" style="background-color:#002557;color:white;">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>
</body>
</html>

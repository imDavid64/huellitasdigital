<?php
//Este include verifica si hay sesión activa
include_once __DIR__ . '/../includes/auth.php';
checkRole(['ADMINISTRADOR']); //Solo admin puede entrar
?>

<!DOCTYPE html>
<html lang="es">

<!--Include para el head-->
<!--HEAD-->
<?php include_once __DIR__ . "/../partials/adminHead.php"; ?>
<!--HEAD-->

<body>

    <!--Include para el herder-->
    <!--HEADER-->
    <?php include_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->


    <!--CONTENIDO CENTRAL-->
    <main>
        <section class="admin-main">
            <!--Include para el menu aside-->
            <?php include_once __DIR__ . "/../partials/asideMenu.php"; ?>
            <section class="admin-main-content">
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-cart-fill"></i><strong> Gestión de Pedidos</strong></h2>
                    </div>
                </div>
                <section class="admin-main-content-mgmt">
                    <div>
                        <div class="search">
                            <input type="text" id="header-search" placeholder="Buscar pedido...">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                    <div class="admin-mgmt-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID Pedido</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Método Pago</th>
                                    <th scope="col">Estado</th>
                                    <th class="text-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>5001</td>
                                    <td>2025-08-12</td>
                                    <td>Juan Pérez</td>
                                    <td>₡50,000</td>
                                    <td>Tarjeta de Crédito</td>
                                    <td>Pendiente</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="view-order.html" class="btn btn-dark-blue btn-sm">
                                                Detalles <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="edit-order-state.html" class="btn btn-orange btn-sm">
                                                Cambiar Estado <i class="bi bi-arrow-repeat"></i>
                                            </a>
                                            <button class="btn btn-black btn-sm">
                                                Anular <i class="bi bi-x-square"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5002</td>
                                    <td>2025-08-14</td>
                                    <td>María González</td>
                                    <td>₡7,500</td>
                                    <td>Efectivo</td>
                                    <td>Procesando</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="view-order.html" class="btn btn-dark-blue btn-sm">
                                                Detalles <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="edit-order-state.html" class="btn btn-orange btn-sm">
                                                Cambiar Estado <i class="bi bi-arrow-repeat"></i>
                                            </a>
                                            <button class="btn btn-black btn-sm">
                                                Anular <i class="bi bi-x-square"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </section>
            </section>
        </section>
    </main>
    <!--CONTENIDO CENTRAL-->
</body>

<!--FOOTER-->
<footer>
    <div class="post-footer" style="background-color: #002557; color: white;">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>
</footer>
<!--FOOTER-->


</html>
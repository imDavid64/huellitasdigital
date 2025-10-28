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
            <section class="admin-main-content-add-user">
                <div>
                    <div class="tittles">
                        <h2><i class="bi bi-pencil-square"></i><strong> Cambiar Estado del Pedido</strong></h2>
                    </div>
                </div>
                <div class="admin-form-container">
                    <form action="order-mgmt.html" method="POST">
                        <div class="form-container">
                            <div class="form-item">
                                <label for="stateOrder">Estado</label>
                                <select id="stateOrder" name="stateOrder" required>
                                    <option disabled>Seleccione un rol</option>
                                    <option selected>Pendiente</option>
                                    <option>Procesando</option>
                                    <option>Completado</option>
                                    <option>Cancelado</option>
                                    <option>Pagado</option>
                                    <option>Enviado</option>
                                    <option>En Transito</option>
                                    <option>Reembolsado</option>
                                    <option>Error</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-dark-blue"><strong>Guardar Cambios</strong><i
                                    class="bi bi-floppy2"></i></button>
                        </div>
                    </form>
                </div>
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
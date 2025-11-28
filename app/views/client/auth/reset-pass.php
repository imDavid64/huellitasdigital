<?php
//NO QUITAR//
require_once __DIR__ . '/../../../config/bootstrap.php';

if (!defined('BASE_URL')) {
  require_once __DIR__ . '/../../../config/bootstrap.php';
}
?>

<script>
  const BASE_URL = "<?= BASE_URL ?>";
  const USER_LOGGED_IN = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
</script>
<!--NO QUITAR-->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- SweetAlert2 local -->
    <script src="<?= BASE_URL ?>/public/js/libs/sweetalert2.all.min.js"></script>
    <!-- JQuery y script.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>/public/js/script.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>Cambiar Contraseña</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= BASE_URL ?>/index.php?controller=auth&action=resetPassword" method="POST">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                            <div class="mb-3">
                                <label for="new-password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" name="new-password" required minlength="6"
                                    placeholder="Ingrese nueva contraseña">
                            </div>
                            <div class="d-grid justify-content-center">
                                <button type="submit" class="btn-blue">Cambiar Contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../assets/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
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
                        <form action="/huellitasdigital/app/models/change-pass.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
                            <div class="mb-3">
                                <label for="new-password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="new-password" name="new_password"
                                    required>
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
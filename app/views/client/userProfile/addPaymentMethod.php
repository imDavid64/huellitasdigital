<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huellitas Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/huellitasdigital/public/css/style.css">
    <link rel="stylesheet" href="/huellitasdigital/public/assets/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/huellitasdigital/public/js/script.js"></script>
</head>

<body>
    <!--HEADER-->
    <?php require_once __DIR__ . "/../partials/header.php"; ?>
    <!--HEADER-->

    <!--Breadcrumb-->
    <nav class="breadcrumbs-container-client">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/huellitasdigital/app/controllers/homeController.php?action=index">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a href="profile.html">Perfil de Usuario</a>
            </li>
            <li class="breadcrumb-item current-page">Agregar Metodo de Pago</li>
        </ol>
    </nav>

    <main class="container my-4">
        <section class="main-content">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Nuevo método de pago</h5>

                            <?php if (!empty($_SESSION['error'])): ?>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($_SESSION['error']);
                                    unset($_SESSION['error']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['success'])): ?>
                                <div class="alert alert-success">
                                    <?php echo htmlspecialchars($_SESSION['success']);
                                    unset($_SESSION['success']); ?></div>
                            <?php endif; ?>

                            <form method="POST"
                                action="/huellitasdigital/app/controllers/client/paymentMethodController.php?action=store"
                                novalidate autocomplete="off">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">

                                <div class="mb-3">
                                    <label class="form-label">Nombre del titular *</label>
                                    <input type="text" class="form-control" name="nombre_titular" maxlength="255"
                                        required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo *</label>
                                        <select class="form-select" name="tipo_tarjeta" required>
                                            <option value="">Seleccione</option>
                                            <option value="CREDITO">Crédito</option>
                                            <option value="DEBITO">Débito</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Marca *</label>
                                        <select class="form-select" name="marca_tarjeta" required>
                                            <option value="">Seleccione</option>
                                            <option value="VISA">VISA</option>
                                            <option value="MASTERCARD">Mastercard</option>
                                            <option value="AMEX">American Express</option>
                                            <option value="DINERS">Diners</option>
                                            <option value="OTHER">Otra</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Número de tarjeta *</label>
                                    <input type="password" inputmode="numeric" pattern="[0-9]{13,19}"
                                        class="form-control" name="numero_tarjeta" maxlength="19"
                                        placeholder="Solo dígitos, 13 a 19" required>
                                    <div class="form-text">Solo se almacenan de forma segura y los últimos 4 para
                                        presentación.</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Vence (AAAA-MM) *</label>
                                        <input type="month" class="form-control" name="fecha_vencimiento" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CVV *</label>
                                        <input type="password" inputmode="numeric" pattern="[0-9]{3,4}"
                                            class="form-control" name="cvv" maxlength="4" placeholder="3 o 4 dígitos"
                                            required>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="es_predeterminado"
                                        id="es_predeterminado" value="1">
                                    <label class="form-check-label" for="es_predeterminado">Establecer como método
                                        predeterminado</label>
                                </div>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-success" type="submit">Guardar método</button>
                                    <a class="btn btn-outline-secondary"
                                        href="/huellitasdigital/app/controllers/client/userController.php?action=index">Cancelar</a>
                                </div>
                            </form>

                            <p class="text-muted mt-3 mb-0" style="font-size:.9rem;">
                                Nunca mostramos el número completo. La información viaja por HTTPS y se cifra en la base
                                de datos
                                mediante funciones y triggers.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

<!--FOODER-->
<?php require_once __DIR__ . "/../partials/fooder.php"; ?>
<!--FOODER-->

</html>
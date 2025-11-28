// =====================================
// INTEGRACIÓN PAYPAL - HUELLITAS DIGITAL
// =====================================

// Asegúrate de tener el SDK cargado en tu checkout:
// <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID_SANDBOX&currency=USD"></script>

// =====================================
// INTEGRACIÓN PAYPAL - HUELLITAS DIGITAL
// =====================================

// =====================================
// INTEGRACIÓN PAYPAL - HUELLITAS DIGITAL
// =====================================

$(document).ready(function () {

    if (typeof paypal === "undefined") return;

    const totalColones = parseFloat($("#checkoutForm").data("total") || 0);
    const conversionUSD = (totalColones / 540).toFixed(2);

    // ================================
    // FUNCIÓN GLOBAL PARA ENVIAR EL PEDIDO AL BACKEND
    // ================================
    window.enviarCheckoutAjax = function () {

        // Setear método de pago PAYPAL en el formulario
        $("#metodoPago").val("PAYPAL");

        const formData = new FormData($("#checkoutForm")[0]);

        return new Promise(function (resolve, reject) {

            $.ajax({
                url: BASE_URL + "/index.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",

                beforeSend: function () {
                    Swal.fire({
                        title: "Procesando pedido...",
                        text: "Estamos registrando tu compra 🐾",
                        didOpen: () => Swal.showLoading(),
                        allowOutsideClick: false
                    });
                },

                success: function (data) {
                    Swal.close();
                    resolve(data);
                },

                error: function (xhr) {
                    Swal.close();
                    reject(xhr.responseText);
                }
            });

        });

    };

    // ================================
    // BOTÓN PAYPAL
    // ================================
    paypal.Buttons({

        style: {
            layout: 'vertical',
            color: 'gold',
            shape: 'rect',
            label: 'paypal'
        },

        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    description: "Compra en Huellitas Digital",
                    amount: { value: conversionUSD }
                }]
            });
        },

        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {

                console.log("💳 Pago capturado:", details);

                // Llamar a nuestro backend
                enviarCheckoutAjax()
                    .then(function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Pago realizado",
                                text: "Tu pedido fue procesado exitosamente",
                            }).then(() => {
                                window.location.href =
                                    `${BASE_URL}/index.php?controller=orders&action=list`;
                            });

                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    })
                    .catch(function (err) {
                        console.error("❌ Error AJAX:", err);
                        Swal.fire("Error", "Ocurrió un error procesando el pago", "error");
                    });
            });
        },

        onCancel: function () {
            Swal.fire('Pago cancelado', 'No se ha completado la transacción.', 'info');
        },

        onError: function (err) {
            console.error("PayPal error:", err);
            Swal.fire('Error', 'Ocurrió un problema al procesar el pago con PayPal.', 'error');
        }

    }).render('#paypal-button-container');

});



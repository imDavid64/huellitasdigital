$(function () {
    // --- Ventanas Login / Register / Reset ---
    $(".btnLogin").on("click", () => $("#display-login").css("display", "flex"));
    $("#btnRegister").on("click", () => $("#display-register").css("display", "flex"));
    $("#btnResetPass").on("click", () => {
        $("#display-login").hide();
        $("#display-resetPass").css("display", "flex");
    });

    $("#btnCloseXLogin, #btnCloseLogin").on("click", () => $("#display-login").hide());
    $("#btnCloseXRegister, #btnCloseRegister").on("click", () => $("#display-register").hide());
    $("#btnCloseXResetPass, #btnCloseResetPass").on("click", () => $("#display-resetPass").hide());

    // --- Menú usuario ---
    $("#header-user-img").on("click", function (e) {
        e.stopPropagation();
        $("#header-user-menu").toggle();
    });

    $(document).on("click", () => $("#header-user-menu").hide());
    $("#header-user-menu").on("click", e => e.stopPropagation());

    // --- Filtro sortBy ---
    let esRotado = false;
    $("#btn-filter-sortBy").on("click", function (e) {
        e.stopPropagation();
        esRotado = !esRotado;
        $("#rotate-sortBy-icon").css("transform", esRotado ? "rotate(180deg)" : "rotate(0deg)");
        $("#dropdown-menu").toggle(esRotado);
    });

    $(document).on("click", function () {
        esRotado = false;
        $("#rotate-sortBy-icon").css("transform", "rotate(0deg)");
        $("#dropdown-menu").hide();
    });

    $("#imagenFile").on("change", async function () {
        const file = this.files[0];
        if (!file) return;

        const storageRef = firebase.storage().ref(`usuarios/${file.name}`);
        const uploadTask = storageRef.put(file);

        uploadTask.on(
            "state_changed",
            null,
            (error) => alert("Error subiendo imagen: " + error),
            async () => {
                const url = await uploadTask.snapshot.ref.getDownloadURL();
                $("#usuario_imagen_url").val(url);
                $("#profilePreview img").attr("src", url);
            }
        );
    });

    // --- Registro de usuario vía AJAX ---
    $("#registerForm").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: `${BASE_URL}/index.php?controller=auth&action=register`,
            method: "POST",
            data: formData,
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Procesando...",
                    text: "Por favor espere",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                Swal.close();
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Registro exitoso 🎉",
                        text: response.message,
                        confirmButtonColor: "#3085d6"
                    }).then(() => {
                        // puedes redirigir si quieres
                        window.location.href = `${BASE_URL}/index.php?controller=auth&action=loginForm`;
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message || "Ocurrió un error durante el registro.",
                        confirmButtonColor: "#d33"
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                console.error("Error AJAX:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Error interno",
                    text: "No se pudo completar la solicitud. Intente nuevamente.",
                    confirmButtonColor: "#d33"
                });
            }
        });
    });


    // --- Login de usuario vía AJAX ---
    $("#loginForm").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: `${BASE_URL}/index.php?controller=auth&action=login`,
            method: "POST",
            data: formData,
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Verificando...",
                    text: "Por favor espere",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                Swal.close();

                if (response.success) {
                    Swal.fire({
                        didOpen: () => Swal.showLoading(),
                        title: "Iniciando sesión...",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1000,
                    }).then(() => {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message || "Credenciales incorrectas.",
                        confirmButtonColor: "#d33"
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                console.error("Error AJAX:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Error interno",
                    text: "No se pudo procesar la solicitud. Intente nuevamente.",
                    confirmButtonColor: "#d33"
                });
            }
        });
    });



    // --- Carruseles Genéricos (Marcas y Productos) ---
    function setupCarousel(leftBtn, rightBtn, carouselSelector, scrollAmount = 300) {
        const $carousel = $(carouselSelector);

        $(rightBtn).on("click", function (e) {
            e.preventDefault();
            $carousel.animate({ scrollLeft: "+=" + scrollAmount }, 800, "linear");
        });

        $(leftBtn).on("click", function (e) {
            e.preventDefault();
            $carousel.animate({ scrollLeft: "-=" + scrollAmount }, 800, "linear");
        });
    }

    // Iniciar ambos carruseles
    setupCarousel("#brand-left", "#brand-right", "#brand-carousel");
    setupCarousel("#product-left", "#product-right", "#product-carousel");
    setupCarousel("#food-left", "#food-right", "#food-carousel");
    setupCarousel("#medication-left", "#medication-right", "#medication-carousel");
    setupCarousel("#accessory-left", "#accessory-right", "#accessory-carousel");


    // --- FILTROS DE PRODUCTOS (Categoría / Marca) ---
    $(document).on("change", ".filter-category, .filter-brand", function () {
        // Obtener filtros seleccionados
        const selectedCategories = $(".filter-category:checked").map(function () {
            return $(this).val();
        }).get();

        const selectedBrands = $(".filter-brand:checked").map(function () {
            return $(this).val();
        }).get();

        console.log("Categorías:", selectedCategories);
        console.log("Marcas:", selectedBrands);

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "POST",
            data: {
                controller: "product",
                action: "filterProducts",
                categories: selectedCategories,
                brands: selectedBrands
            },
            beforeSend: function () {
                $(".cards-list-main-catalog").html(`
                <div class="text-center p-4">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando productos...</p>
                </div>
            `);
            },
            success: function (response) {
                $(".cards-list-main-catalog").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error al filtrar productos:", error, xhr.responseText);
                $(".cards-list-main-catalog").html("<p>Error al cargar los productos.</p>");
            }
        });
    });

    // --- Aplicar automáticamente el filtro si viene una categoría seleccionada ---
    $(function () {
        const $checked = $(".filter-category:checked");
        if ($checked.length) {
            $checked.first().trigger("change");
        }
    });



    // --- BUSCADOR EN EL CLIENTE ---
    $("#header-search").on("keyup", function () {
        const query = $(this).val().trim();

        if (query.length >= 2) {
            $.ajax({
                url: `${BASE_URL}/index.php`,
                method: "GET",
                data: {
                    controller: "product",
                    action: "searchProducts",
                    query: query
                },
                dataType: "json",
                success: function (productos) {
                    mostrarResultadosBusqueda(productos);
                },
                error: function (xhr, status, error) {
                    console.error("Error en la búsqueda AJAX:", error, xhr.responseText);
                }
            });
        } else {
            mostrarResultadosBusqueda([]);
        }
    });

    function mostrarResultadosBusqueda(productos) {
        let $contenedor = $("#resultados-busqueda");

        if ($contenedor.length === 0) {
            $contenedor = $("<div>", {
                id: "resultados-busqueda",
                class: "resultados-busqueda"
            }).appendTo(".header-search");
        }

        $contenedor.empty();

        if (productos.length === 0) {
            $contenedor.html("<p style='padding:10px;'>Sin resultados...</p>");
            return;
        }

        productos.forEach(p => {
            const item = $(`
            <div class="item-busqueda">
                <img src="${p.IMAGEN_URL}" alt="${p.PRODUCTO_NOMBRE}">
                <div>
                    <strong>${p.PRODUCTO_NOMBRE}</strong><br>
                    <span>₡${parseFloat(p.PRODUCTO_PRECIO_UNITARIO).toLocaleString()}</span>
                </div>
            </div>
        `);

            item.on("click", function () {
                window.location.href = `${BASE_URL}/index.php?controller=product&action=productsDetails&id=${p.ID_PRODUCTO_PK}`;
            });

            $contenedor.append(item);
        });
    }

    $(document).on("click", function (e) {
        if (!$(e.target).closest(".header-search").length) {
            $("#resultados-busqueda").remove();
        }
    });


    // --- SELECTS DEPENDIENTES (Provincia → Cantón → Distrito) ---
    $("#provincia").on("change", function () {
        const idProvincia = $(this).val();

        if (idProvincia) {
            $.ajax({
                url: `${BASE_URL}/index.php`,
                method: "GET",
                data: {
                    controller: "location",
                    action: "getCantonesPorProvincia",
                    idProvincia
                },
                dataType: "json",
                beforeSend: function () {
                    $("#canton").html("<option>Cargando cantones...</option>");
                    $("#distrito").html("<option>Seleccione un cantón primero</option>");
                },
                success: function (cantones) {
                    $("#canton").empty().append('<option value="">Seleccione un cantón</option>');
                    cantones.forEach(c => {
                        $("#canton").append(`<option value="${c.ID_DIRECCION_CANTON_PK}">${c.NOMBRE_CANTON}</option>`);
                    });
                },
                error: function () {
                    $("#canton").html("<option>Error al cargar cantones</option>");
                }
            });
        } else {
            $("#canton").html('<option value="">Seleccione una provincia primero</option>');
            $("#distrito").html('<option value="">Seleccione un cantón primero</option>');
        }
    });

    $("#canton").on("change", function () {
        const idCanton = $(this).val();

        if (idCanton) {
            $.ajax({
                url: `${BASE_URL}/index.php`,
                method: "GET",
                data: {
                    controller: "location",
                    action: "getDistritosPorCanton",
                    idCanton
                },
                dataType: "json",
                beforeSend: function () {
                    $("#distrito").html("<option>Cargando distritos...</option>");
                },
                success: function (distritos) {
                    $("#distrito").empty().append('<option value="">Seleccione un distrito</option>');
                    distritos.forEach(d => {
                        $("#distrito").append(`<option value="${d.ID_DIRECCION_DISTRITO_PK}">${d.NOMBRE_DISTRITO}</option>`);
                    });
                },
                error: function () {
                    $("#distrito").html("<option>Error al cargar distritos</option>");
                }
            });
        } else {
            $("#distrito").html('<option value="">Seleccione un cantón primero</option>');
        }
    });




    // --- PARA LAS NOTIFICAIONES ---
    $("#btnNotifications").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const $dropdown = $("#notificationDropdown");
        $dropdown.toggle();

        if ($dropdown.is(":visible")) {
            cargarNotificaciones();
        }
    });

    // Función para cargar notificaciones
    // === Cargar notificaciones ===
    function cargarNotificaciones() {
        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "GET",
            data: {
                controller: "adminNotification",
                action: "getNotifications"
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                const $list = $(".notification-list");
                $list.empty();

                if (!data || data.length === 0) {
                    $list.html("<p style='padding:10px;'>Sin notificaciones nuevas</p>");
                    return;
                }

                data.forEach(n => {
                    const item = $(`
                    <div class="notification-item" 
                        data-id="${n.ID_NOTIFICACION_PK}"
                        data-url="${n.URL_REDIRECCION || '#'}">
                        <strong>${n.TITULO_NOTIFICACION}</strong><br>
                        <small>${n.MENSAJE_NOTIFICACION}</small><br>
                        <small>${new Date(n.FECHA_CREACION).toLocaleString()}</small>
                    </div>
                `);

                    // ✅ Click para marcar y redirigir
                    item.on("click", function () {
                        let url = $(this).data("url");
                        const id = $(this).data("id");

                        $.post(`${BASE_URL}/index.php`, {
                            controller: "adminNotification",
                            action: "markOneAsRead",
                            id: id
                        });

                        if (url) {
                            if (!url.startsWith("http")) {
                                url = `${BASE_URL}${url}`;
                            }
                            window.location.href = url;
                        }
                    });


                    $list.append(item);
                });
            },
            error: function (xhr) {
                console.error("Error al cargar notificaciones:", xhr.responseText);
            }
        });
    }

    // Marcar todas como leídas
    $("#markAsRead").on("click", function () {
        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "POST",
            data: {
                controller: "adminNotification",
                action: "markAsRead"
            },
            success: function () {
                $(".notification-list").html("<p style='padding:10px;'>Sin notificaciones nuevas</p>");
                $("#notification-count").hide();
            }
        });
    });


    // === 🔄 FUNCIÓN PARA ACTUALIZAR CONTADOR ===
    function actualizarContadorNotificaciones() {
        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "GET",
            data: {
                controller: "adminNotification",
                action: "getUnreadCount"
            },
            dataType: "json",
            success: function (data) {
                const count = parseInt(data.total) || 0;
                const $badge = $("#notification-count");

                if (count > 0) {
                    $badge.text(count).show();
                } else {
                    $badge.hide();
                }
            },
            error: function (xhr) {
                console.error("Error contador:", xhr.responseText);
            }
        });
    }


    // === Actualizar contador cada 60 segundos automáticamente ===
    setInterval(actualizarContadorNotificaciones, 60000);

    // === Disminuir contador al marcar todas como leídas ===
    $("#markAsRead").on("click", function () {
        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "POST",
            data: {
                controller: "adminNotification",
                action: "markAsRead"
            },
            success: function () {
                $(".notification-list")
                    .html("<p style='padding:10px;'>Sin notificaciones nuevas</p>");
                $("#notification-count").hide(); // ✅ ocultar contador a 0
            },
            error: function (xhr) {
                console.error("Error al marcar como leídas:", xhr.responseText);
            }
        });
    });

    // === Inicializar contador al cargar la página ===
    actualizarContadorNotificaciones();


    // Sistema de búsqueda por parte del admin
    $(document).on("keyup", ".admin-search-input", function (e) {
        // Si el usuario presiona Enter o escribe más de 2 letras
        if (e.key === "Enter" || $(this).val().length >= 2 || $(this).val().length === 0) {
            const $input = $(this);
            const query = $input.val().trim();
            const target = $input.data("target"); // ej: 'product', 'brand', 'category', etc.

            // Mapeo de controladores y acciones según el destino
            const controllerMap = {
                user: {
                    url: `${BASE_URL}/index.php`,
                    action: "search",
                    controller: "adminUser"
                },
                role: {
                    url: `${BASE_URL}/index.php`,
                    action: "search",
                    controller: "adminRole"
                },
                supplier: {
                    url: `${BASE_URL}/index.php`,
                    action: "search",
                    controller: "adminSupplier"
                },
                order: {
                    url: `${BASE_URL}/index.php`,
                    action: "search",
                    controller: "adminOrder"
                },
                product: {
                    url: `${BASE_URL}/index.php`,
                    action: "search",
                    controller: "adminProduct"
                },
                brand: {
                    url: `${BASE_URL}/index.php`,
                    action: "searchBrand",
                    controller: "adminProduct"
                },
                category: {
                    url: `${BASE_URL}/index.php`,
                    action: "searchCategory",
                    controller: "adminProduct"
                },
                client: {
                    url: `${BASE_URL}/index.php`,
                    action: "search",
                    controller: "employeeClient"
                }
            };

            const config = controllerMap[target];
            if (!config) {
                console.warn("❌ Tipo de búsqueda no definido:", target);
                return;
            }

            // --- Petición AJAX ---
            $.ajax({
                url: config.url,
                method: "GET",
                data: {
                    controller: config.controller,
                    action: config.action,
                    query: query,
                    page: 1
                },
                success: function (response) {
                    $(".admin-mgmt-table").html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error al realizar la búsqueda:", error, xhr.responseText);
                }
            });

        }
    });

    // --- (Opcional) Permitir clic en el ícono de búsqueda ---
    $(document).on("click", ".search i", function () {
        $(this).siblings(".admin-search-input").trigger("keyup");
    });

    // --- Manejador de paginación AJAX ---
    $(document).on("click", ".pagination-link", function (e) {
        e.preventDefault();

        var page = $(this).data("page");
        var $input = $(".admin-search-input");
        var query = $.trim($input.val());
        var target = $input.data("target");

        // Mismo mapa de controladores que antes
        const controllerMap = {
            user: {
                url: `${BASE_URL}/index.php`,
                action: "search",
                controller: "adminUser"
            },
            role: {
                url: `${BASE_URL}/index.php`,
                action: "search",
                controller: "adminRole"
            },
            supplier: {
                url: `${BASE_URL}/index.php`,
                action: "search",
                controller: "adminSupplier"
            },
            order: {
                url: `${BASE_URL}/index.php`,
                action: "search",
                controller: "adminOrder"
            },
            product: {
                url: `${BASE_URL}/index.php`,
                action: "search",
                controller: "adminProduct"
            },
            brand: {
                url: `${BASE_URL}/index.php`,
                action: "searchBrand",
                controller: "adminProduct"
            },
            category: {
                url: `${BASE_URL}/index.php`,
                action: "searchCategory",
                controller: "adminProduct"
            },
            client: {
                url: `${BASE_URL}/index.php`,
                action: "search",
                controller: "employeeClient"
            }
        };

        var config = controllerMap[target];
        if (!config) return;

        $.ajax({
            url: config.url,
            method: "GET",
            data: {
                controller: config.controller,
                action: config.action,
                query: query,
                page: page
            },
            beforeSend: function () {
                $(".admin-mgmt-table").html("<div style='padding:10px;text-align:center;'>Cargando...</div>");
            },
            success: function (response) {
                $(".admin-mgmt-table").html(response);
            }
        });
    });

    // === previewImage.js ===
    // Script genérico para previsualizar imágenes en formularios de edición
    $(document).on('change', '.image-input', function (event) {
        const input = event.target;
        const file = input.files[0];

        // Buscamos la vista previa más cercana dentro del mismo contenedor o formulario
        const preview = $(input).closest('form, .form-container').find('.image-preview').first();

        // Si el usuario seleccionó una nueva imagen
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            // Si el input fue limpiado, restauramos la imagen original (si existe campo hidden)
            const currentImageUrl = $(input).closest('form').find('input[name="current_image_url"]').val();
            if (currentImageUrl) {
                preview.attr('src', currentImageUrl);
            }
        }
    });

    // --- AGREGAR COMENTARIO EN DETALLE DEL PRODUCTO ---
    $("#formAddComment").on("submit", function () {

        const comment = $("#commentText").val();
        const rating = $("#rating").val();
        const productId = new URLSearchParams(window.location.search).get("id");

        if (!comment.trim()) {
            alert("⚠️ El comentario no puede estar vacío");
            return;
        }

        $.ajax({
            url: `${BASE_URL}/index.php`,
            type: "POST",
            data: {
                controller: "product",
                action: "addComment",
                id_producto: productId,
                comentario: comment,
                calificacion: rating
            },
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    alert("✅ Comentario agregado correctamente");
                    location.reload();
                } else {
                    alert("❌ " + res.error);
                }
            },
            error: function (xhr) {
                alert("⚠️ Error al enviar el comentario: " + xhr.responseText);
            }
        });

    });

    // Sistema de estrellas para calificación
    $(".rating-stars i").on("click", function () {
        const value = $(this).data("value");
        $("#rating").val(value);

        $(".rating-stars i").each(function () {
            $(this).toggleClass("bi-star-fill", $(this).data("value") <= value)
                .toggleClass("text-warning", $(this).data("value") <= value)
                .toggleClass("text-secondary", $(this).data("value") > value);
        });
    });

    // Editar comentario - abrir modal
    $(document).on("click", ".btnEdit", function () {
        const comment = $(this).closest(".comment-card");
        $("#editCommentId").val($(this).data("id"));
        $("#editCommentText").val(comment.find("p").text());

        const currentStars = comment.find(".bi-star-fill").length;
        $("#editRating").val(currentStars);

        $(".edit-stars i").each(function () {
            $(this).toggleClass("bi-star-fill", $(this).data("value") <= currentStars)
                .toggleClass("text-warning", $(this).data("value") <= currentStars)
                .toggleClass("text-secondary", $(this).data("value") > currentStars);
        });

        $("#editCommentModal").modal("show");
    });

    // Editar comentario - sistema de estrellas en modal
    $("#updateCommentBtn").on("click", function () {
        $.post(`${BASE_URL}/index.php`, {
            controller: "product",
            action: "editComment",
            id_comentario: $("#editCommentId").val(),
            comentario: $("#editCommentText").val(),
            calificacion: $("#editRating").val()
        }, function (res) {
            if (res.success) {
                location.reload();
            } else {
                alert("⚠ Error al actualizar");
            }
        }, "json");
    });

    // Seleccionar estrellas dentro del modal
    $(".edit-stars i").on("click", function () {
        const valor = $(this).data("value");
        $("#editRating").val(valor);

        $(".edit-stars i").each(function () {
            $(this)
                .toggleClass("bi-star-fill", $(this).data("value") <= valor)
                .toggleClass("text-warning", $(this).data("value") <= valor)
                .toggleClass("bi-star", $(this).data("value") > valor);
        });
    });

    // Eliminar comentario - con confirmación
    $(document).on("click", ".btnDelete", function () {
        const id = $(this).data("id");

        if (confirm("¿Seguro que deseas eliminarlo?")) {
            $.post(`${BASE_URL}/index.php`, {
                controller: "product",
                action: "deleteComment",
                id_comentario: id
            }, function (res) {
                if (res.success) {
                    $("#comment-" + id).fadeOut();
                } else {
                    alert("Error al eliminar 😥");
                }
            }, "json");
        }
    });


    // ---SISTEMA DE CARRITO---
    // Agregar al carrito
    $(document).on("click", ".btnAddToCart", function (e) {
        e.preventDefault();

        const $container = $(this).closest(".product-detail-addCart, .product-item");
        const quantity = parseInt($container.find("input[type=number]").val() || 1);
        const productId = $(this).data("id");

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "POST",
            data: {
                controller: "cart",
                action: "add",
                productId: productId,
                cantidad: quantity
            },
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Agregando producto...",
                    text: "Por favor espere",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (data) {
                Swal.close();

                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "¡Producto añadido! 🛒",
                        text: data.message || "El producto se agregó correctamente al carrito.",
                        timer: 1800,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "No se pudo agregar",
                        text: data.message || "No hay suficiente stock disponible.",
                        confirmButtonColor: "#f39c12"
                    });
                }
            },
            error: function (xhr) {
                Swal.close();
                console.error("Error al agregar producto:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Error inesperado",
                    text: "❌ Ocurrió un error al agregar el producto al carrito. Intente nuevamente.",
                    confirmButtonColor: "#d33"
                });
            }
        });
    });

    // Validar input de cantidad
    $(document).on("input", ".cart-sum-item input[type=number]", function () {
        const max = parseInt($(this).attr("max") || 99, 10);
        let val = parseInt($(this).val(), 10);
        if (val < 1) val = 1;
        if (val > max) val = max;
        $(this).val(val);
    });


    //Remover ítem del carrito
    $(document).ready(function () {
        $(".btn-cart-remove").on("click", function (e) {
            e.preventDefault();
            const cartId = $(this).data("id");
            $.post("index.php?controller=cart&action=remove", { cartId }, function (resp) {
                const data = JSON.parse(resp);
                if (data.success) location.reload();
            });
        });
    });

    // Función para actualizar subtotales y total del carrito
    function updateCartTotals() {
        let subtotal = 0;
        const shipping = 2000; // Envío fijo (puede hacerse dinámico)
        const ivaRate = 0.13;

        $(".cart-item").each(function () {
            const price = parseFloat($(this).find(".cart-price").data("price"));
            const quantity = parseInt($(this).find("input[type=number]").val(), 10);
            const itemSubtotal = price * quantity;

            // Actualizar el subtotal visual de cada producto
            $(this).find(".cart-price").text(`₡${itemSubtotal.toLocaleString("es-CR", { minimumFractionDigits: 2 })}`);
            subtotal += itemSubtotal;
        });

        const iva = subtotal * ivaRate;
        const total = subtotal + iva + shipping;

        $("#cart-subtotal").text(`₡${subtotal.toLocaleString("es-CR", { minimumFractionDigits: 2 })}`);
        $("#cart-iva").text(`₡${iva.toLocaleString("es-CR", { minimumFractionDigits: 2 })}`);
        $("#cart-total").text(`₡${total.toLocaleString("es-CR", { minimumFractionDigits: 2 })}`);
    }

    // Actualizar cantidad de producto en el carrito
    $(document).on("click", ".cart-sum-item button", function () {
        const $input = $(this).siblings("input[type=number]");
        const isIncrease = $(this).text().trim() === "+";
        const $item = $(this).closest(".cart-item");
        const productId = $item.data("id-product");
        let quantity = parseInt($input.val(), 10);

        if (isIncrease) {
            quantity++;
        } else if (quantity > 1) {
            quantity--;
        }

        $input.val(quantity);

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "POST",
            data: {
                controller: "cart",
                action: "updateQuantity",
                productId: productId,
                quantity: quantity
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        updateCartTotals(); // ✅ Actualiza subtotal y total en pantalla
                    } else {
                        alert(data.message || "No se pudo actualizar la cantidad");
                        // Revertir visualmente cantidad si hubo error
                        if (isIncrease) $input.val(quantity - 1);
                        else $input.val(quantity + 1);
                    }
                } catch (e) {
                    console.error("Error al procesar respuesta:", e, response);
                }
            },
            error: function (xhr) {
                console.error("Error al actualizar cantidad:", xhr.responseText);
                alert("❌ Error al actualizar la cantidad");
            }
        });
    });

    // Obtener totales del carrito al cargar la página
    function fetchCartTotals() {
        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "POST",
            data: {
                controller: "cart",
                action: "totals",
                shipping: 2000
            },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.success) {
                    const t = data.data;
                    $("#cart-subtotal").text(`₡${t.SUBTOTAL.toLocaleString("es-CR", { minimumFractionDigits: 2 })}`);
                    $("#cart-iva").text(`₡${t.IVA.toLocaleString("es-CR", { minimumFractionDigits: 2 })}`);
                    $("#cart-total").text(`₡${t.TOTAL_FINAL.toLocaleString("es-CR", { minimumFractionDigits: 2 })}`);
                }
            }
        });
    }

    //--------------- CHECKOUT ----------------
    // Mostrar secciones según el método de pago seleccionado
    $(document).on("change", "#metodoPago", function () {
        const metodo = $(this).val();

        // Ocultar todos los bloques de pago
        $("#paypalBox, #transferenciaBox").addClass("d-none");

        // Quitar required del input si no es transferencia
        $("#comprobanteTransferencia").prop("required", false);

        if (metodo === "PAYPAL") {
            $("#paypalBox").removeClass("d-none");

        } else if (metodo === "TRANSFERENCIA") {
            $("#transferenciaBox").removeClass("d-none");
            $("#comprobanteTransferencia").prop("required", true);
        }
    });

    // ===============================
    // CHECKOUT MULTISTEP (3 pasos)
    // ===============================

    // Validar paso antes de avanzar
    function validarStep(step) {
        let valido = true;
        let mensajes = [];

        // Obtiene inputs dentro del step actual
        $("#step" + step + " input[required], #step" + step + " select[required], #step" + step + " textarea[required]")
            .each(function () {
                if (!$(this).val() || $(this).val().trim() === "") {
                    valido = false;
                    const label = $(this).closest(".form-item").find("label").first().text() || "Campo requerido";
                    mensajes.push("• " + label);
                }
            });

        if (!valido) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                html: "Completa los siguientes campos:<br><br>" + mensajes.join("<br>"),
                confirmButtonText: "Entendido"
            });
        }

        return valido;
    }

    //Evitar avanzar si hay datos incompletos
    $(document).on("click", ".next-step", function () {
        const next = $(this).data("next");
        const current = next - 1;

        // ⛔ Si faltan datos → NO avanzar
        if (!validarStep(current)) return;

        $(".checkout-step").addClass("d-none");
        $("#step" + next).removeClass("d-none");
    });


    // Control de pasos (Next / Prev)
    $(document).on("click", ".next-step", function () {
        const next = $(this).data("next");
        $(".checkout-step").addClass("d-none");
        $("#step" + next).removeClass("d-none");
    });

    $(document).on("click", ".prev-step", function () {
        const prev = $(this).data("prev");
        $(".checkout-step").addClass("d-none");
        $("#step" + prev).removeClass("d-none");
    });

    // Mostrar secciones según el método de pago seleccionado
    $(document).on("change", "#metodoPago", function () {
        const metodo = $(this).val();
        // Ocultar todos los bloques de pago
        $("#paypalBox, #transferenciaBox").addClass("d-none");

        if (metodo === "PAYPAL") {
            $("#paypalBox").removeClass("d-none");
        } else if (metodo === "TRANSFERENCIA") {
            $("#transferenciaBox").removeClass("d-none");
        }
    });

    // ===============================
    // VALIDAR CAMPOS ANTES DE ENVIAR CHECKOUT
    // ===============================
    function validarCheckoutCompleto() {
        let camposInvalidos = [];

        $("#checkoutForm input[required], #checkoutForm select[required], #checkoutForm textarea[required]")
            .each(function () {
                if (!$(this).val() || $(this).val().trim() === "") {
                    const label = $(this).closest(".form-item").find("label").first().text() || "Campo requerido";
                    camposInvalidos.push("• " + label);
                }
            });

        if (camposInvalidos.length > 0) {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos por completar",
                html: camposInvalidos.join("<br>"),
                confirmButtonText: "Entendido"
            });
            return false;
        }

        return true;
    }


    // ===============================
    // ENVÍO DE FORMULARIO (Transferencia / Efectivo)
    // ===============================
    $(document).off('submit', '#checkoutForm').on('submit', '#checkoutForm', function (e) {
        e.preventDefault();

        if (!validarCheckoutCompleto()) return;

        const metodo = $("#metodoPago").val();

        if (metodo === "PAYPAL") {
            return enviarCheckoutAjax();
        }

        Swal.fire({
            title: "¿Confirmar compra?",
            text: "¿Seguro que deseas confirmar tu pedido?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) return;

            const formData = new FormData($("#checkoutForm")[0]);

            $.ajax({
                url: BASE_URL + "/index.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function () {
                    Swal.fire({
                        title: "Procesando...",
                        text: "Estamos confirmando tu compra 🐾",
                        didOpen: () => Swal.showLoading(),
                        allowOutsideClick: false
                    });
                },
                success: function (data) {
                    Swal.close();
                    if (data.success) {
                        let msg = "";

                        if (metodo === "TRANSFERENCIA") {
                            msg = "Tu pedido ha sido registrado. Recuerda enviar el comprobante de pago a nuestro correo para confirmar tu compra.";
                        } else if (metodo === "EFECTIVO") {
                            msg = "Tu pedido se ha registrado con pago contra entrega. ¡Gracias por tu compra!";
                        } else {
                            msg = data.message || "Compra procesada correctamente.";
                        }

                        Swal.fire({
                            icon: "success",
                            title: "✅ Pedido registrado",
                            text: msg,
                            confirmButtonText: "Ver mis pedidos"
                        }).then(() => {
                            window.location.href = BASE_URL + "/index.php?controller=orders&action=list";
                        });

                    } else {
                        Swal.fire("Error", data.message || "No se pudo procesar la compra.", "error");
                    }
                },
                error: function (xhr, status, error) {
                    Swal.close();
                    console.error("Error AJAX checkout:", status, error, xhr.responseText);
                    Swal.fire("Error", "Hubo un problema de conexión con el servidor.", "error");
                }
            });
        });
    });

    // Función para enviar el checkout vía AJAX (PayPal)
    function enviarCheckoutAjax() {

        const formData = new FormData($("#checkoutForm")[0]);

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

                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Compra registrada",
                        text: data.message,
                        confirmButtonText: "Ver mis pedidos"
                    }).then(() => {
                        window.location.href =
                            BASE_URL + "/index.php?controller=orders&action=list";
                    });

                } else {
                    Swal.fire("Error", data.message, "error");
                }
            },
            error: function (xhr) {
                Swal.close();
                console.error("Error AJAX:", xhr.responseText);
                Swal.fire("Error", "No se pudo procesar el pedido.", "error");
            }
        });
    }


    // ===============================
    // VALIDAR COMPROBANTE DE TRANSFERENCIA
    // ===============================
    $(document).on('submit', '#checkoutForm', function (e) {
        const metodo = $("#metodoPago").val();

        if (metodo === "TRANSFERENCIA") {
            const file = $("#comprobanteTransferencia").val();
            if (!file) {
                e.preventDefault();
                Swal.fire("Comprobante requerido", "Debes subir el comprobante de la transferencia.", "warning");
                return;
            }
        }
    });

    // Función para validar imagen
    function validarImagen(fileInput) {
        const file = fileInput.files[0];

        if (!file) return false;

        // Tipos MIME permitidos
        const tiposPermitidos = ["image/jpeg", "image/png"];

        if (!tiposPermitidos.includes(file.type)) {
            Swal.fire({
                icon: "error",
                title: "Archivo inválido",
                text: "Solo se permiten imágenes en formato JPG o PNG."
            });
            fileInput.value = ""; // limpiar input
            return false;
        }

        // Tamaño máximo opcional (2 MB)
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            Swal.fire({
                icon: "warning",
                title: "Archivo muy pesado",
                text: "La imagen debe pesar menos de 2 MB."
            });
            fileInput.value = "";
            return false;
        }

        return true;
    }

    // Ejecutar cuando el usuario seleccione un archivo
    $(document).on("change", "#comprobanteTransferencia", function () {
        validarImagen(this);
    });

    // =======================================================
    // CLIENTE → Abrir modal para subir comprobante
    // =======================================================
    $(document).on("click", ".btnSubirComprobante", function () {

        const codigo = $(this).data("codigo");

        $("#codigoPedidoComprobanteCliente").val(codigo);
        $("#inputComprobantePago").val("");
        $("#previewComprobante").addClass("d-none").attr("src", "");

        $("#modalSubirComprobante").modal("show");
    });


    // =======================================================
    // Preview de la imagen seleccionada
    // =======================================================
    $(document).on("change", "#inputComprobantePago", function () {

        if (!validarImagen(this)) {
            return; // No continuar si la imagen no es válida
        }

        // Mostrar preview si es válida
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            $("#previewComprobante")
                .removeClass("d-none")
                .attr("src", e.target.result);
        };

        reader.readAsDataURL(file);
    });


    // =======================================================
    // CLIENTE → Enviar nuevo comprobante a Firebase + DB
    // =======================================================
    $('#formSubirComprobante').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: `${BASE_URL}/index.php?controller=orders&action=subirComprobante`,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",

            success: function (res) {
                // Cerrar modal de forma "oficial" con Bootstrap
                const modalEl = document.getElementById('modalSubirComprobante');
                const modalInstance = bootstrap.Modal.getInstance(modalEl)
                    || new bootstrap.Modal(modalEl);
                modalInstance.hide();

                if (res.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Comprobante enviado",
                        text: res.message
                    }).then(() => location.reload());
                } else {
                    Swal.fire("Error", res.message || "Ocurrió un error al procesar la solicitud.", "error");
                }
            },

            error: function (xhr) {
                Swal.fire(
                    "Error",
                    "No se pudo contactar con el servidor. Inténtalo de nuevo más tarde.",
                    "error"
                );
            }
        });
    });



    // ===============================
    // VALIDAR SI EL CARRITO ESTÁ VACÍO (solo en checkout)
    // ===============================
    if (window.location.href.includes("controller=checkout")) {
        $.ajax({
            url: BASE_URL + "/index.php",
            type: "GET",
            data: {
                controller: "checkout",
                action: "verificarCarrito"
            },
            dataType: "json",
            success: function (res) {
                if (!res.success) {
                    Swal.fire({
                        icon: "info",
                        title: "Carrito vacío 🛒",
                        text: res.message || "Agrega productos antes de continuar con el pago.",
                        confirmButtonText: "Ir a productos"
                    }).then(() => {
                        window.location.href = BASE_URL + "/index.php?controller=product&action=index";
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al verificar el carrito:", status, error, xhr.responseText);
            }
        });
    }

    // --- Paginación de pedidos (cliente) ---
    $(document).on("click", ".pagination-link", function (e) {
        e.preventDefault();
        const page = $(this).data("page");

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "GET",
            data: {
                controller: "orders",
                action: "list",
                page: page
            },
            beforeSend: function () {
                $(".orders_list-container").html(`
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3">Cargando pedidos...</p>
                </div>
            `);
            },
            success: function (html) {
                $(".main-content").html($(html).find(".main-content").html());
                window.scrollTo({ top: 0, behavior: "smooth" });
            },
            error: function (xhr) {
                console.error("Error en la paginación:", xhr.responseText);
            }
        });
    });



    // ================================
    // EDITAR ESTADO DEL PEDIDO (admin)
    // ================================
    $(document).on('click', '.btnEditStatus', function (e) {
        e.preventDefault();

        // si está bloqueado, mostramos la razón exacta y salimos
        if ($(this).hasClass("disabled-link")) {
            const razon = $(this).data("bloqueo") || "No puedes modificar el estado del pedido en este momento.";

            Swal.fire({
                icon: "warning",
                title: "Acción no permitida",
                text: razon
            });
            return;
        }

        // Si NO está bloqueado, abrimos normalmente el modal
        const codigoPedido = $(this).data('codigo');
        const estadoActual = $(this).data('current-status').trim().toUpperCase();

        // Pasar el código al modal
        $('#pedidoCodigo').val(codigoPedido);

        const $select = $('#nuevoEstado');
        $select.empty().append('<option value="" disabled selected>Cargando estados...</option>');

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: 'GET',
            data: {
                controller: 'adminOrder',
                action: 'getStates'
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        $select.empty().append('<option value="" disabled selected>Seleccionar estado...</option>');
                        data.estados.forEach(e => {
                            const selected = e.ESTADO_DESCRIPCION.toUpperCase() === estadoActual ? 'selected' : '';
                            $select.append(`<option value="${e.ID_ESTADO_PK}" ${selected}>${e.ESTADO_DESCRIPCION}</option>`);
                        });
                    }
                } catch (err) {
                    console.error("Error procesando respuesta:", err);
                    Swal.fire("Error", "Hubo un problema procesando los estados", "error");
                }
            }
        });

        // abrir modal
        $('#modalEditarEstado').modal('show');
    });


    // ================================
    // EDITAR ESTADO DE PAGO (admin)
    // ================================
    //Evitar abrir modal si el estado de pago ya no se puede modificar
    $(document).on("click", ".btnEditarEstadoPago", function (e) {

        if ($(this).hasClass("disabled-link")) {
            const razon = $(this).data("bloqueo") || "No puedes modificar este estado.";

            Swal.fire({
                icon: "warning",
                title: "Acción no permitida",
                text: razon,
            });
            return;
        }

        // Si no está bloqueado → abrir modal
        const codigo = $(this).data("codigo");
        $("#pagoCodigoPedido").val(codigo);
        $("#modalEditarEstadoPago").modal("show");
    });


    // ================================
    // REVISAR COMPROBANTE DE PAGO (admin)
    // ================================
    $(document).on("click", ".btnRevisarComprobante", function () {

        const codigo = $(this).data("codigo");

        $("#codigoPedidoComprobante").val(codigo);

        $("#contenedorComprobanteDatos").html(`
        <div class="text-center my-4">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2">Cargando comprobante...</p>
        </div>
    `);

        $("#modalComprobantePago").modal("show");

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "GET",
            data: {
                controller: "adminOrder",
                action: "reviewPaymentProofAjax",
                codigo: codigo
            },
            dataType: "json",
            success: function (response) {
                if (response.html) {
                    $("#contenedorComprobanteDatos").html(response.html);
                } else {
                    $("#contenedorComprobanteDatos").html(
                        `<p class="text-danger">No se pudo cargar el comprobante.</p>`
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("Error AJAX comprobante:", status, error);
                console.error("Respuesta:", xhr.responseText);
                $("#contenedorComprobanteDatos").html(`
                <p class="text-danger">Error al cargar el comprobante.</p>
            `);
            }
        });

    });

    //Enviar actualización de estado del comprobante de pago
    $("#formActualizarComprobante").on("submit", function (e) {
        e.preventDefault();

        const estado = $("input[name='estadoComprobante']:checked").val();

        if (!estado) {
            Swal.fire({
                icon: "warning",
                text: "Debes seleccionar un estado del comprobante."
            });
            return;
        }

        const datos = $(this).serialize();

        $.ajax({
            url: `${BASE_URL}/index.php?controller=adminOrder&action=updatePaymentProofStatus`,
            method: "POST",
            data: datos,
            dataType: "json",

            beforeSend: function () {
                Swal.fire({
                    title: "Procesando...",
                    html: "Actualizando comprobante y enviando factura<br><b>por favor espere</b> 🐾",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },

            success: function (r) {

                // ❌ Si el servidor devolvió HTML
                if (typeof r === "string" && r.trim().startsWith("<")) {
                    Swal.fire({
                        icon: "error",
                        title: "Error interno",
                        html: "El servidor devolvió un error inesperado.<br>Revisa la consola."
                    });
                    console.error("Respuesta no JSON:", r);
                    return;
                }

                Swal.close(); // Cerrar loading

                Swal.fire({
                    icon: r.success ? "success" : "error",
                    title: r.success ? "¡Listo!" : "Error",
                    text: r.message
                }).then(() => {
                    if (r.success) {
                        $("#modalComprobantePago").modal("hide");
                        location.reload();
                    }
                });
            },

            error: function (xhr, status, error) {
                Swal.close();
                console.error("Error AJAX:", status, error, xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Error de conexión",
                    text: "No se pudo comunicar con el servidor."
                });
            }
        });
    });




    //Enviar cambio de estado con confirmación
    $('#formEditarEstado').on('submit', function (e) {
        e.preventDefault();

        const codigoPedido = $('#pedidoCodigo').val();
        const nuevoEstado = $('#nuevoEstado').val();

        if (!nuevoEstado) {
            Swal.fire('Atención', 'Debe seleccionar un estado válido antes de guardar.', 'warning');
            return;
        }

        // Confirmar la acción
        Swal.fire({
            title: '¿Confirmar cambio de estado?',
            text: 'Esta acción actualizará el estado del pedido en el sistema.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: `${BASE_URL}/index.php`,
                    method: 'POST',
                    data: {
                        controller: 'adminOrder',
                        action: 'updateStatus',
                        codigoPedido: codigoPedido,
                        nuevoEstado: nuevoEstado
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Actualizando...',
                            text: 'Por favor espera un momento.',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function (response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Estado actualizado!',
                                    text: 'El estado del pedido se cambió correctamente.',
                                    timer: 1800,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#modalEditarEstado').modal('hide');
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message || 'No se pudo actualizar el estado.', 'error');
                            }
                        } catch (err) {
                            console.error('Error procesando respuesta:', err, response);
                            Swal.fire('Error', 'Ocurrió un error al procesar la respuesta del servidor.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
                    }
                });

            }
        });
    });

    //Enviar cambio de estado de pago con confirmación
    $('#formEditarEstadoPago').on('submit', function (e) {
        e.preventDefault();

        const codigoPedido = $('#pagoCodigoPedido').val();
        const nuevoEstado = $('#nuevoEstadoPago').val();

        if (!nuevoEstado) {
            Swal.fire('Atención', 'Debes seleccionar un estado válido.', 'warning');
            return;
        }

        Swal.fire({
            title: '¿Confirmar cambio?',
            text: 'El estado de pago será actualizado.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {

                $.ajax({
                    url: `${BASE_URL}/index.php`,
                    method: 'POST',
                    data: {
                        controller: 'adminOrder',
                        action: 'updatePaymentStatus',
                        codigoPedido: codigoPedido,
                        nuevoEstadoPago: nuevoEstado
                    },
                    success: function (response) {
                        try {
                            const data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Actualizado!',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        } catch (e) {
                            console.error(response);
                            Swal.fire('Error', 'Respuesta inválida del servidor.', 'error');
                        }
                    }
                });

            }
        });
    });


    // Mensaje para confirmar la cancelación del pedido
    $(document).on('click', '.btnCancelOrder', function () {
        var pedidoId = $(this).data('id');
        Swal.fire({
            title: '¿Cancelar pedido?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + "/index.php",
                    type: "POST",
                    data: {
                        controller: "orders",
                        action: "cancelar",
                        pedido_id: pedidoId
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            Swal.fire('Cancelado', data.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo conectar al servidor.', 'error');
                    }
                });
            }
        });
    });

    // ===============================
    // PANEL DE EMPLEADO
    // ===============================
    // REGISTRO DE CLIENTE (EMPLEADO)
    $(document).off("submit", "#addClientForm").on("submit", "#addClientForm", function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        Swal.fire({
            title: "Registrando cliente...",
            text: "Por favor espere un momento",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
        });

        $.ajax({
            url: `${BASE_URL}/index.php?controller=employeeClient&action=store`,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (res) {
                Swal.close();
                console.log("Respuesta:", res);

                if (res.EXITO === 1 || res.success) {
                    Swal.fire({
                        icon: "success",
                        title: "✅ Cliente agregado",
                        text: res.MENSAJE || "El cliente se registró correctamente.",
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = `${BASE_URL}/index.php?controller=employeeClient&action=index`;
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "No se pudo registrar",
                        text: res.MENSAJE || "Verifique los datos ingresados.",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#f39c12",
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                console.error("Error al registrar cliente:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Error inesperado",
                    text: "❌ Ocurrió un problema al intentar agregar el cliente.",
                    confirmButtonColor: "#d33",
                });
            },
        });
    });

    //Mensaje para verificar si se guardó correctamente la información del usuario
    $(document).on("submit", "#editClientForm", function (e) {
        e.preventDefault();

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "POST",
            data: $(this).serialize() + "&controller=employeeClient&action=update",
            dataType: "json", // ✅ fuerza a jQuery a tratarlo como JSON
            success: function (data) { // ✅ ya llega como objeto
                if (data.EXITO == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Actualización exitosa",
                        text: data.MENSAJE,
                        confirmButtonText: "Volver a detalles",
                        confirmButtonColor: "#004AAD",
                    }).then(() => {
                        window.location.href = `${BASE_URL}/index.php?controller=employeeClient&action=details&codigo=${$("input[name='codigo_cliente']").val()}`;
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Atención",
                        text: data.MENSAJE,
                        confirmButtonColor: "#FF9100",
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error del servidor",
                    text: "No se pudo conectar con el servidor.",
                    confirmButtonColor: "#d33",
                });
            }
        });
    });



    // ==============================
    // CARGAR RAZAS AL SELECCIONAR ESPECIE
    // ==============================
    $(document).on("change", "#especie", function () {
        $("#buscar_raza").val("");
        const idEspecie = $(this).val();
        const $razaSelect = $("#raza");

        if (!idEspecie) {
            $razaSelect.html('<option value="">Seleccione raza</option>');
            return;
        }

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "GET",
            data: {
                controller: "employeePet",
                action: "cargarRazasPorEspecie",
                id_especie: idEspecie
            },
            beforeSend: function () {
                $razaSelect.html('<option value="">Cargando...</option>');
            },
            success: function (response) {
                try {
                    if (response.success) {
                        $razaSelect.empty().append('<option value="">Seleccione raza</option>');

                        response.razas.forEach(r => {
                            $razaSelect.append(
                                `<option value="${r.ID_MASCOTA_RAZA_PK}">${r.NOMBRE_RAZA}</option>`
                            );
                        });

                    } else {
                        Swal.fire("Error", "No se pudieron cargar las razas.", "error");
                    }
                } catch (e) {
                    console.error(e);
                    Swal.fire("Error", "Fallo al procesar la respuesta del servidor.", "error");
                }
            },
            error: function () {
                Swal.fire("Error", "No se pudo conectar al servidor.", "error");
            }
        });
    });


    // ==============================
    // BUSCAR RAZAS POR TEXTO (DENTRO DE LA ESPECIE)
    // ==============================
    $(document).on("keyup", "#buscar_raza", function () {
        const texto = $(this).val();
        const idEspecie = $("#especie").val();
        const $razaSelect = $("#raza");

        if (!idEspecie) return;

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "GET",
            data: {
                controller: "employeePet",
                action: "buscarRazasPorEspecie",
                id_especie: idEspecie,
                q: texto
            },
            beforeSend: function () {
                $razaSelect.html('<option value="">Cargando búsqueda...</option>');
            },
            success: function (response) {
                try {
                    if (response.success) {
                        $razaSelect.empty().append('<option value="">Seleccione raza</option>');

                        response.razas.forEach(r => {
                            $razaSelect.append(
                                `<option value="${r.ID_MASCOTA_RAZA_PK}">${r.NOMBRE_RAZA}</option>`
                            );
                        });

                    } else {
                        Swal.fire("Error", response.mensaje, "error");
                    }
                } catch (e) {
                    console.error(e);
                    Swal.fire("Error", "No se pudo procesar la búsqueda.", "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Error en la conexión con el servidor.", "error");
            }
        });
    });

    // ==============================
    // ENVÍO DEL FORMULARIO PARA REGISTRAR MASCOTA (CON ARCHIVOS)
    // ==============================
    $(document).on("submit", "#addPetForm", function (e) {
        e.preventDefault();

        const form = $(this)[0];
        const formData = new FormData(form);

        Swal.fire({
            title: "¿Agregar mascota?",
            text: "Confirma que deseas guardar esta mascota.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar",
            cancelButtonText: "Cancelar"
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: $(form).attr("action"),
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",

                    success: function (response) {
                        console.log("Respuesta agregar mascota:", response);

                        if (response.EXITO == 1) {

                            Swal.fire({
                                title: "¡Mascota agregada!",
                                text: response.MENSAJE,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {

                                // 🔥 Redirección automática al detalle del cliente
                                window.location.href =
                                    `${BASE_URL}/index.php?controller=employeeClient&action=details&codigo=${response.CODIGO_CLIENTE}`;
                            });

                        } else {
                            Swal.fire("Error", response.MENSAJE || "Error al registrar la mascota.", "error");
                        }
                    },

                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("ERROR AJAX agregar mascota:", {
                            status: jqXHR.status,
                            textStatus: textStatus,
                            errorThrown: errorThrown,
                            responseText: jqXHR.responseText
                        });

                        Swal.fire(
                            "Error",
                            "No se pudo enviar el formulario.\n\n" +
                            "Estado: " + textStatus + "\n" +
                            "Código: " + jqXHR.status,
                            "error"
                        );
                    }
                });
            }
        });
    });

    // ==============================
    // ENVÍO DEL FORMULARIO PARA EDITAR MASCOTA (CON ARCHIVOS)
    // ==============================
    $(document).on("submit", "#editPetForm", function (e) {
        e.preventDefault();

        const form = $(this)[0];
        const formData = new FormData(form);

        Swal.fire({
            title: "¿Actualizar mascota?",
            text: "Confirma que deseas guardar los cambios.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, actualizar",
            cancelButtonText: "Cancelar"
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: $(form).attr("action"),
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",

                    success: function (response) {
                        console.log("Respuesta editar mascota:", response);

                        if (response.EXITO == 1) {

                            Swal.fire({
                                title: "¡Mascota actualizada!",
                                text: response.MENSAJE,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {

                                // Si quieres redirigir a los detalles de la mascota:
                                window.location.href =
                                    `${BASE_URL}/index.php?controller=employeePet&action=details&codigo=${response.CODIGO_MASCOTA}`;
                            });

                        } else {
                            Swal.fire("Error", response.MENSAJE || "No se pudo actualizar la mascota.", "error");
                        }
                    },

                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("ERROR AJAX editar mascota:", {
                            status: jqXHR.status,
                            textStatus: textStatus,
                            errorThrown: errorThrown,
                            responseText: jqXHR.responseText
                        });

                        Swal.fire(
                            "Error",
                            "No se pudo enviar el formulario.\n\n" +
                            "Estado: " + textStatus + "\n" +
                            "Código: " + jqXHR.status,
                            "error"
                        );
                    }
                });
            }
        });
    });

    // editar mascota - cargar razas al cargar la página
    $(document).ready(function () {

        const especieId = $("#especie").val();
        const razaActual = $("#raza_actual").val();

        if (especieId) {
            cargarRazasParaEditar(especieId, razaActual);
        }

    });

    // Función para cargar razas al editar mascota
    function cargarRazasParaEditar(idEspecie, razaSeleccionada) {

        const $razaSelect = $("#raza");

        $.ajax({
            url: `${BASE_URL}/index.php`,
            method: "GET",
            data: {
                controller: "employeePet",
                action: "cargarRazasPorEspecie",
                id_especie: idEspecie
            },
            beforeSend: function () {
                $razaSelect.html('<option value="">Cargando...</option>');
            },
            success: function (response) {
                try {
                    if (response.success) {
                        $razaSelect.empty().append('<option value="">Seleccione raza</option>');

                        response.razas.forEach(r => {
                            $razaSelect.append(
                                `<option value="${r.ID_MASCOTA_RAZA_PK}" ${r.ID_MASCOTA_RAZA_PK == razaSeleccionada ? 'selected' : ''}>
                                ${r.NOMBRE_RAZA}
                            </option>`
                            );
                        });

                    } else {
                        Swal.fire("Error", "No se pudieron cargar las razas.", "error");
                    }
                } catch (e) {
                    console.error(e);
                    Swal.fire("Error", "Fallo al procesar la respuesta del servidor.", "error");
                }
            },
            error: function () {
                Swal.fire("Error", "No se pudo conectar al servidor.", "error");
            }
        });
    }

    // ================================================================
    // Vincular Cliente Veterinaria → Usuario Tienda
    // ================================================================
    $(document).on("click", "#btnVincularCuenta", function () {

        // Validar si está permitido mostrar el botón
        if (!window.Huellitas || !window.Huellitas.mostrarVinculacion) {
            console.warn("🔗 Vinculación no disponible o no permitida.");
            return;
        }

        Swal.fire({
            title: "¿Vincular tus datos veterinarios?",
            text: "Esto migrará tus mascotas y tu información de cliente veterinario hacia tu cuenta actual.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, vincular",
            cancelButtonText: "Cancelar"
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: window.Huellitas.baseUrl + "/index.php?controller=auth&action=vincularCliente",
                    method: "POST",
                    data: {
                        codigoUsuario: window.Huellitas.codigoUsuario
                    },
                    dataType: "json",

                    success: function (response) {

                        if (response.success) {
                            Swal.fire({
                                title: "¡Vinculación Exitosa!",
                                text: response.message,
                                icon: "success"
                            }).then(() => {
                                location.reload();
                            });

                        } else {
                            Swal.fire({
                                title: "Error",
                                text: response.message || "No se pudo completar la vinculación.",
                                icon: "error"
                            });
                        }
                    },

                    error: function () {
                        Swal.fire("Error", "Error de comunicación con el servidor.", "error");
                    }
                });
            }

        });

    });

    // ============================================
    // GESTIÓN DE CITAS
    // ============================================

    const CTRL = window.APPOINTMENT_CONTROLLER ?? "employeeAppointment";

    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            height: 700,
            selectable: false,
            editable: false,
            navLinks: true,

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            events: {
                url: `${BASE_URL}/index.php?controller=${CTRL}&action=api`,
                method: "GET",
                failure: () => alert("Error al cargar las citas.")
            },

            /* ===========================================
               🔥 COLORES SEGÚN FECHA
            ============================================ */
            eventDidMount: function (info) {
                const hoy = new Date();
                const inicio = new Date(info.event.start);

                hoy.setHours(0, 0, 0, 0);
                inicio.setHours(0, 0, 0, 0);

                const diffMs = inicio - hoy;
                const diffDias = diffMs / (1000 * 60 * 60 * 24);

                let bg = "";
                let textColor = "#ffffff";
                let icon = "";

                if (diffDias < 0) {
                    // ⚪ La cita ya pasó
                    bg = "#999999";
                    textColor = "#ffffff";
                    icon = "⚪";
                } else if (diffDias === 0) {
                    // 🔴 La cita es hoy
                    bg = "#E63946";
                    icon = "🔴";
                } else if (diffDias <= 1) {
                    // 🟡 La cita es mañana
                    bg = "#FFB703";
                    textColor = "#000000";
                    icon = "🟡";
                } else if (diffDias <= 10) {
                    // 🔵 La cita es en los próximos 10 días
                    bg = "#219EBC";
                    icon = "🔵";
                } else {
                    bg = "#38A169";
                    icon = "🟢";
                }

                // Aplicar icono al título
                const titleEl = info.el.querySelector(".fc-event-title");
                if (titleEl) {
                    titleEl.innerHTML = `${icon} ${info.event.title}`;
                }

                // 🔥 Fuerza los estilos sobre cualquier color default de Fullcalendar:
                info.el.style.setProperty("background-color", bg, "important");
                info.el.style.setProperty("color", textColor, "important");
                info.el.style.setProperty("border", "none", "important");
                info.el.style.setProperty("border-radius", "6px", "important");
                info.el.style.setProperty("padding", "4px", "important");
            },



            eventClick: function (info) {
                const data = info.event.extendedProps;

                const cliente = data.CLIENTE_NOMBRE || "Sin nombre";
                const mascotas = data.MASCOTAS || "Ninguna";
                const inicio = info.event.start.toLocaleString();
                const fin = info.event.end.toLocaleString();

                let plantilla = document.querySelector("#plantillaCitaDetalle").innerHTML;
                let wrapper = document.createElement("div");
                wrapper.innerHTML = plantilla;

                wrapper.querySelector(".cita-cliente").innerText = cliente;
                wrapper.querySelector(".cita-mascotas").innerText = mascotas;
                wrapper.querySelector(".cita-veterinario").innerText = data.veterinario;
                wrapper.querySelector(".cita-servicio").innerText = data.servicio;
                wrapper.querySelector(".cita-motivo").innerText = data.MOTIVO || "No especificado";
                wrapper.querySelector(".cita-inicio").innerText = inicio;
                wrapper.querySelector(".cita-fin").innerText = fin;

                Swal.fire({
                    title: `<strong style="color:#002557;"><i class="bi bi-calendar-event-fill"></i> Detalle de la Cita</strong>`,
                    html: wrapper.innerHTML,
                    width: 600,
                    confirmButtonText: "Cerrar",
                    confirmButtonColor: "#003780"
                });
            }
        });

        calendar.render();
    }





    $(document).ready(function () {

        // =====================================================
        // BUSCADOR GENERAL DE CLIENTES / USUARIOS
        // =====================================================
        $(document).on("keyup", "#buscadorGeneral", function () {

            let query = $(this).val().trim();

            if (query.length < 2) {
                $("#listaResultados").hide();
                return;
            }

            $.ajax({
                url: `${BASE_URL}/index.php?controller=${CTRL}&action=buscarCliente`,
                type: "GET",
                data: { q: query },
                dataType: "json",
                success: function (data) {

                    let html = "";

                    if (data.length === 0) {
                        html = `<div class="list-group-item text-center text-muted">Sin resultados</div>`;
                    } else {
                        data.forEach(item => {
                            html += `
                                <button type="button"
                                    class="list-group-item list-group-item-action seleccionar-cliente"
                                    data-tipo="${item.TIPO}"
                                    data-codigo-cliente="${item.TIPO === 'CLIENTE' ? item.CODIGO : ''}"
                                    data-codigo-usuario="${item.TIPO === 'USUARIO' ? item.CODIGO : ''}"

                                    data-nombre="${item.NOMBRE}"
                                    data-correo="${item.CORREO}"
                                    data-identificacion="${item.IDENTIFICACION ?? ''}"
                                    data-telefono="${item.TELEFONO ?? ''}"
                                    data-direccion="${item.DIRECCION ?? ''}">
                                    
                                    <strong>${item.NOMBRE}</strong>
                                    <br><small>${item.CORREO}</small>
                                    <br><small>Código: ${item.CODIGO}</small>
                                </button>
                            `;
                        });

                    }

                    $("#listaResultados").html(html).show();
                }
            });

        });


        // =====================================================
        // SELECCIONAR CLIENTE DESDE LISTA Y RELLENAR CAMPOS
        // =====================================================
        $(document).on("click", ".seleccionar-cliente", function () {

            let tipo = $(this).data("tipo");

            let codCliente = $(this).data("codigo-cliente");
            let codUsuario = $(this).data("codigo-usuario");

            if (tipo === "CLIENTE") {
                $("#codigoClienteSeleccionado").val(codCliente);
                $("#codigoUsuarioSeleccionado").val("");
            } else {
                $("#codigoUsuarioSeleccionado").val(codUsuario);
                $("#codigoClienteSeleccionado").val("");
            }

            // Rellenar los campos visibles
            $("#clienteNombreInput").val($(this).data("nombre"));
            $("#clienteCorreoInput").val($(this).data("correo"));
            $("#clienteIdentificacionInput").val($(this).data("identificacion"));
            $("#clienteTelefonoInput").val($(this).data("telefono"));
            $("#clienteDireccionInput").val($(this).data("direccion"));

            $("#datosClienteSeleccionado").show();
            $("#listaResultados").hide();

            // Cargar mascotas dependiendo si es cliente o usuario
            let codigoReal = tipo === "CLIENTE" ? codCliente : codUsuario;
            cargarMascotas(codigoReal);
        });



        /* =======================================================
        ACTIVAR / DESACTIVAR MODO MANUAL
        ======================================================= */
        $(document).on("change", "#chkClienteManual", function () {
            if ($(this).is(":checked")) {
                $("#clienteManualContainer").show();
                $("#datosClienteSeleccionado").hide();
                $("#contenedorMascotas").hide();
                // limpiar valores
                $("#codigoClienteSeleccionado").val("");
                $("#codigoUsuarioSeleccionado").val("");
                $(".chk-mascota").prop("checked", false);
                $("#listaMascotas").html("");
                $("#buscadorGeneral").val("");
            } else {
                $("#clienteManualContainer").hide();
            }
        });

        /* =======================================================
           CARGAR MASCOTAS
        ======================================================= */
        function cargarMascotas(codigoCliente) {
            $.ajax({
                url: `${BASE_URL}/index.php?controller=${CTRL}&action=obtenerMascotas`,
                type: "GET",
                data: { codigo: codigoCliente },
                dataType: "json",
                success: function (mascotas) {

                    if (!mascotas || mascotas.length === 0) {
                        $("#contenedorMascotas").hide();
                        return;
                    }

                    let html = ``;
                    mascotas.forEach(m => {
                        html += `
                    <div class="form-check mb-1">
                        <input class="form-check-input chk-mascota"
                               type="checkbox"
                               value="${m.CODIGO_MASCOTA}"
                               id="masc_${m.CODIGO_MASCOTA}">
                        <label class="form-check-label" for="masc_${m.CI}">
                            <strong>${m.NOMBRE_MASCOTA}</strong> – ${m.ESPECIE}
                        </label>
                    </div>
                `;
                    });

                    $("#listaMascotas").html(html);
                    $("#contenedorMascotas").show();
                }
            });
        }

        /* =======================================================
        SETEAR FECHA FIN AUTOMÁTICAMENTE (+30 MIN)
        ======================================================= */
        $("#fechaInicio").on("change", function () {
            let inicio = $(this).val();

            if (!inicio) return; // nada seleccionado

            let fechaInicio = new Date(inicio);

            // Sumar 30 minutos
            fechaInicio.setMinutes(fechaInicio.getMinutes() + 30);

            // Convertir a formato yyyy-MM-ddTHH:mm (datetime-local)
            let year = fechaInicio.getFullYear();
            let month = String(fechaInicio.getMonth() + 1).padStart(2, '0');
            let day = String(fechaInicio.getDate()).padStart(2, '0');
            let hours = String(fechaInicio.getHours()).padStart(2, '0');
            let minutes = String(fechaInicio.getMinutes()).padStart(2, '0');

            let finFormateado = `${year}-${month}-${day}T${hours}:${minutes}`;

            $("#fechaFin").val(finFormateado);
        });



        /* =======================================================
           AGENDAR CITA
        ======================================================= */
        $("#btnEnviarCita").on("click", function () {

            let mascotasSeleccionadas = [];
            $(".chk-mascota:checked").each(function () {
                mascotasSeleccionadas.push($(this).val());
            });

            let data = {
                id_vet: $("#idVeterinario").val(),
                id_servicio: $("#idServicio").val(),
                start: $("#fechaInicio").val(),
                end: $("#fechaFin").val(),
                motivo: $("#motivo").val().trim(),
                json_mascotas: JSON.stringify(mascotasSeleccionadas)
            };

            /* ==============================
               CLIENTE SELECCIONADO O MANUAL
            =============================== */
            if ($("#chkClienteManual").is(":checked")) {

                data.codigo_cliente = null;
                data.codigo_usuario = null;

                data.cliente_manual = JSON.stringify({
                    nombre: $("#clienteManualNombre").val(),
                    correo: $("#clienteManualCorreo").val(),
                    telefono: $("#clienteManualTelefono").val(),
                    identificacion: $("#clienteManualIdentificacion").val(),
                    mascota: $("#clienteManualMascota").val()
                });

            } else {
                data.codigo_cliente = $("#codigoClienteSeleccionado").val();
                data.codigo_usuario = $("#codigoUsuarioSeleccionado").val();
            }


            /* ============ VALIDACIONES ============ */
            // Validar campos obligatorios
            if (!data.id_vet || !data.id_servicio || !data.start || !data.end) {
                Swal.fire({
                    icon: "warning",
                    title: "Datos incompletos",
                    text: "Debe seleccionar veterinario, servicio y fechas.",
                });
                return;
            }
            // Validar que se haya seleccionado un cliente o modo manual
            if (
                !$("#chkClienteManual").is(":checked") &&
                !data.codigo_cliente &&
                !data.codigo_usuario
            ) {
                Swal.fire({
                    icon: "warning",
                    title: "Seleccione un cliente",
                    text: "Debe seleccionar un cliente o activar el modo manual.",
                });
                return;
            }

            // Validar que la fecha fin sea posterior
            if (new Date(data.end) <= new Date(data.start)) {
                Swal.fire({
                    icon: "warning",
                    title: "Horario inválido",
                    text: "La fecha/hora de fin debe ser mayor.",
                });
                return;
            }

            /* ============================
               VALIDAR DURACIÓN MÍNIMA 30min
            ============================= */
            let inicio = new Date(data.start);
            let fin = new Date(data.end);

            let diffMinutos = (fin - inicio) / 1000 / 60;

            if (diffMinutos < 30) {
                Swal.fire({
                    icon: "warning",
                    title: "Duración insuficiente",
                    text: "La cita debe durar al menos 30 minutos.",
                });
                return;
            }

            /* ================================
            VALIDAR CAMPOS DE CLIENTE MANUAL
            ================================ */
            if ($("#chkClienteManual").is(":checked")) {

                let nombreManual = $("#clienteManualNombre").val().trim();
                let telefonoManual = $("#clienteManualTelefono").val().trim();
                let mascotaManual = $("#clienteManualMascota").val().trim();

                if (nombreManual === "" || telefonoManual === "" || mascotaManual === "") {
                    Swal.fire({
                        icon: "warning",
                        title: "Datos incompletos",
                        html: `
                Para clientes <strong>no registrados</strong><br>
                debe ingresar: <br><br>
                ✔ Nombre del cliente<br>
                ✔ Teléfono del cliente<br>
                ✔ Nombre de la mascota
            `,
                        confirmButtonColor: "#003780"
                    });
                    return;
                }

                // Validación extra: teléfono numérico y longitud
                if (!/^[0-9]{8}$/.test(telefonoManual)) {
                    Swal.fire({
                        icon: "warning",
                        title: "Teléfono inválido",
                        text: "El teléfono debe tener 8 dígitos numéricos.",
                        confirmButtonColor: "#003780"
                    });
                    return;
                }
            }



            /* ============ ENVIAR ============ */

            Swal.fire({
                title: "Agendando cita...",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: `${BASE_URL}/index.php?controller=${CTRL}&action=store`,
                type: "POST",
                data: data,
                dataType: "json",

                success: function (response) {
                    Swal.close();

                    if (response.EXITO === 1) {
                        Swal.fire({
                            icon: "success",
                            title: "Cita creada",
                            text: response.MENSAJE
                        }).then(() => {
                            location.href =
                                `${BASE_URL}/index.php?controller=${CTRL}&action=index`;
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.MENSAJE
                        });
                    }
                },

                error: function () {
                    Swal.close();
                    Swal.fire({
                        icon: "error",
                        title: "Error de servidor",
                        text: "Ocurrió un error inesperado."
                    });
                }
            });
        });
    });

    // ============================================
    // VER DETALLE HISTORIAL MÉDICO (AJAX)
    // ============================================
    $(document).on("click", ".ver-historial-btn", function () {
        let codigo = $(this).data("code");

        $.ajax({
            url: `${BASE_URL}/index.php?controller=pets&action=ajaxGetHistory&code=${codigo}`,
            method: "GET",
            dataType: "json",
            beforeSend: function () {
                $("#historial-detalle").html("<p>Cargando...</p>");
            },
            success: function (data) {
                if (data.error) {
                    $("#historial-detalle").html(`<p>Error: ${data.error}</p>`);
                    return;
                }

                $("#historial-detalle").html(`
                <div class="my-pets-info-medical-history-info-content-left">
                    <div><h5><strong>Temperatura</strong></h5><div class="pet-data-item"><span>${data.TEMPERATURA ?? "Sin Registro"} °C</span></div></div>
                    <div><h5><strong>Sonidos Pulmonares</strong></h5><div class="pet-data-item"><span>${data.SONIDOS_PULMONARES ?? "Sin Registro"}</span></div></div>
                    <div><h5><strong>Piel</strong></h5><div class="pet-data-item"><span>${data.PIEL ?? "Sin Registro"}</span></div></div>
                    <div><h5><strong>Frecuencia Cardiaca</strong></h5><div class="pet-data-item"><span>${data.FRECUENCIA_CARDIACA ?? "Sin Registro"} lpm</span></div></div>
                </div>

                <div class="my-pets-info-medical-history-info-content-right">
                    <div><h5><strong>Peso</strong></h5><div class="pet-data-item"><span>${data.PESO ?? "Sin Registro"} kg</span></div></div>
                    <div><h5><strong>Mucosa</strong></h5><div class="pet-data-item"><span>${data.MUCOSA ?? "Sin Registro"}</span></div></div>
                    <div><h5><strong>Condición Corporal</strong></h5><div class="pet-data-item"><span>${data.CONDICION_CORPORAL ?? "Sin Registro"}</span></div></div>
                    <div><h5><strong>Frecuencia Respiratoria</strong></h5><div class="pet-data-item"><span>${data.FRECUENCIA_RESPIRATORIA ?? "Sin Registro"} rpm</span></div></div>
                </div>
            `);
            },
            error: function () {
                $("#historial-detalle").html("<p>Error al cargar el historial.</p>");
            }
        });
    });


    // ============================================
    // VER DETALLE CITA EN MODAL
    // ============================================
    $(document).on("click", ".btn-detalle-cita", function (e) {
        e.preventDefault();

        $("#det-fecha").text($(this).data("fecha"));
        $("#det-servicio").text($(this).data("servicio"));
        $("#det-veterinario").text($(this).data("veterinario"));

        $("#det-cliente").text($(this).data("cliente"));
        $("#det-correo").text("📧 " + $(this).data("correo-cliente"));
        $("#det-telefono").text("📞 " + $(this).data("telefono"));
        $("#det-identificacion").text("🆔 " + $(this).data("identificacion"));

        $("#det-mascota").text($(this).data("mascota"));
        $("#det-motivo").text($(this).data("motivo"));

        let modal = new bootstrap.Modal(document.getElementById("modalDetalleCita"));
        modal.show();
    });


});

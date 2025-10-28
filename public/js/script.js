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



    /// --- FILTROS DE PRODUCTOS (Categoría / Marca) ---
    $(".filter-category, .filter-brand").on("change", function () {
        // Obtener los filtros seleccionados
        const selectedCategories = $(".filter-category:checked").map(function () {
            return $(this).val();
        }).get();

        const selectedBrands = $(".filter-brand:checked").map(function () {
            return $(this).val();
        }).get();

        console.log("Categorías:", selectedCategories);
        console.log("Marcas:", selectedBrands);

        // Enviar al backend mediante el router
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
                $(".cards-list-main-catalog").html("<p>Cargando productos...</p>");
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
    })


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
                url: "/../app/controllers/admin/catalogController.php",
                method: "GET",
                data: { action: "getCantones", idProvincia },
                dataType: "json",
                beforeSend: function () {
                    $("#canton").html("<option>Cargando cantones...</option>");
                    $("#distrito").html("<option>Seleccione un cantón primero</option>");
                },
                success: function (cantones) {
                    console.log("Cantones cargados:", cantones); // debug
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
                url: "/../app/controllers/admin/catalogController.php",
                method: "GET",
                data: { action: "getDistritos", idCanton },
                dataType: "json",
                beforeSend: function () {
                    $("#distrito").html("<option>Cargando distritos...</option>");
                },
                success: function (distritos) {
                    console.log("Distritos cargados:", distritos); // debug
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



});

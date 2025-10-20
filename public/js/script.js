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



    // --- FILTROS DE PRODUCTOS (Categoría / Marca) ---
    $(".filter-category, .filter-brand").on("change", function () {
        // Obtener los filtros seleccionados
        const selectedCategories = $(".filter-category:checked").map(function () {
            return $(this).val();
        }).get();

        const selectedBrands = $(".filter-brand:checked").map(function () {
            return $(this).val();
        }).get();
        console.log(selectedCategories)
        // Enviar al backend
        $.ajax({
            url: "/huellitasdigital/app/controllers/client/productController.php?action=filterProducts",
            method: "POST",
            data: {
                categories: selectedCategories,
                brands: selectedBrands
            },
            beforeSend: function () {
                $(".cards-list-main-catalog").html("<p>Cargando productos...</p>");
            },
            success: function (response) {
                $(".cards-list-main-catalog").html(response);
            },
            error: function () {
                $(".cards-list-main-catalog").html("<p>Error al cargar los productos.</p>");
            }
        });
    });

    // --- Aplicar automáticamente el filtro si viene una categoría seleccionada ---
    $(document).ready(function () {
        const selectedCategory = $(".filter-category:checked").map(function () {
            return $(this).val();
        }).get();

        if (selectedCategory.length > 0) {
            // Simular el cambio para activar el filtro automáticamente
            $(".filter-category:first").trigger("change");
        }
    });

    // --- BUSCADOR EN TIEMPO REAL ---
    $("#header-search").on("keyup", function () {
        const query = $(this).val().trim();

        if (query.length >= 2) {
            $.ajax({
                url: "/huellitasdigital/app/controllers/client/productController.php",
                method: "GET",
                data: {
                    action: "searchProducts",
                    query: query
                },
                dataType: "json",
                success: function (productos) {
                    mostrarResultadosBusqueda(productos);
                },
                error: function () {
                    console.error("Error en la búsqueda AJAX");
                }
            });
        } else {
            mostrarResultadosBusqueda([]); // limpia resultados si el input se borra
        }
    });

    function mostrarResultadosBusqueda(productos) {
        let $contenedor = $("#resultados-busqueda");

        // Si no existe el contenedor, se crea dinámicamente dentro del div .header-search
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

            // ✅ Al hacer clic en un resultado, redirige a la página de detalle (opcional)
            item.on("click", function () {
                window.location.href = "/huellitasdigital/app/views/client/products/productDetail.php?action=productsDetails&id=" + p.ID_PRODUCTO_PK;
            });

            $contenedor.append(item);
        });
    }

    // --- Cerrar el contenedor si se hace clic fuera ---
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
                url: "/huellitasdigital/app/controllers/admin/catalogController.php",
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
                url: "/huellitasdigital/app/controllers/admin/catalogController.php",
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
    function cargarNotificaciones() {
        $.ajax({
            url: "/huellitasdigital/app/controllers/admin/notificationController.php",
            method: "GET",
            data: { action: "getNotifications" },
            dataType: "json",
            success: function (data) {
                const $list = $(".notification-list");
                $list.empty();

                if (!data || data.length === 0) {
                    $list.html("<p style='padding:10px;'>Sin notificaciones nuevas</p>");
                    return;
                }

                data.forEach(n => {
                    const item = $(`
                        <div class="notification-item" data-url="${n.URL_REDIRECCION || '#'}">
                            <strong>${n.TITULO_NOTIFICACION}</strong><br>
                            <small>${n.MENSAJE_NOTIFICACION}</small>
                            <div><small>${new Date(n.FECHA_CREACION).toLocaleString()}</small></div>
                        </div>
                    `);

                    item.on("click", function () {
                        const url = $(this).data("url");
                        if (url && url !== "#") window.location.href = url;
                    });

                    $list.append(item);
                });
            },
            error: function (err) {
                console.error("Error al cargar notificaciones", err);
            }
        });
    }

    // Marcar todas como leídas
    $("#markAsRead").on("click", function () {
        $.ajax({
            url: "/huellitasdigital/app/controllers/admin/notificationController.php",
            method: "POST",
            data: { action: "markAsRead" },
            success: function () {
                $(".notification-list").html("<p style='padding:10px;'>Sin notificaciones nuevas</p>");
            }
        });
    });

    // === 🔄 FUNCIÓN PARA ACTUALIZAR CONTADOR ===
    function actualizarContadorNotificaciones() {
        $.ajax({
            url: "/huellitasdigital/app/controllers/admin/notificationController.php",
            method: "GET",
            data: { action: "getUnreadCount" },
            dataType: "json",
            success: function (data) {
                const count = parseInt(data.total) || 0;
                const $badge = $("#notification-count");

                if (count > 0) {
                    $badge.text(count);
                    $badge.show();
                } else {
                    $badge.hide();
                }
            },
            error: function (err) {
                console.error("Error al obtener el contador de notificaciones", err);
            }
        });
    }

    // === Actualizar cada 60 segundos automáticamente ===
    setInterval(actualizarContadorNotificaciones, 60000);

    // === Disminuir contador al marcar todas como leídas ===
    $("#markAsRead").on("click", function () {
        $.ajax({
            url: "/huellitasdigital/app/controllers/admin/notificationController.php",
            method: "POST",
            data: { action: "markAsRead" },
            success: function () {
                $(".notification-list").html("<p style='padding:10px;'>Sin notificaciones nuevas</p>");
                $("#notification-count").hide(); // ocultar contador
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
                product: { url: "/huellitasdigital/app/controllers/admin/productController.php", action: "search" },
                brand: { url: "/huellitasdigital/app/controllers/admin/productController.php", action: "searchBrand" },
                category: { url: "/huellitasdigital/app/controllers/admin/productController.php", action: "searchCategory" },
                user: { url: "/huellitasdigital/app/controllers/admin/userController.php", action: "search" },
                role: { url: "/huellitasdigital/app/controllers/admin/roleController.php", action: "search" },
                supplier: { url: "/huellitasdigital/app/controllers/admin/supplierController.php", action: "search" }
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
                data: { action: config.action, query: query },
                success: function (response) {
                    $(".admin-mgmt-table").html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error al realizar la búsqueda:", error);
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
        var controllerMap = {
            product: { url: "/huellitasdigital/app/controllers/admin/productController.php", action: "search" },
            brand: { url: "/huellitasdigital/app/controllers/admin/productController.php", action: "searchBrand" },
            category: { url: "/huellitasdigital/app/controllers/admin/productController.php", action: "searchCategory" },
            user: { url: "/huellitasdigital/app/controllers/admin/userController.php", action: "search" },
            role: { url: "/huellitasdigital/app/controllers/admin/roleController.php", action: "search" },
            supplier: { url: "/huellitasdigital/app/controllers/admin/supplierController.php", action: "search" }
        };

        var config = controllerMap[target];
        if (!config) return;

        $.ajax({
            url: config.url,
            type: "GET",
            data: { action: config.action, query: query, page: page },
            beforeSend: function () {
                $(".admin-mgmt-table").html("<div style='padding:10px;text-align:center;'>Cargando página...</div>");
            },
            success: function (response) {
                $(".admin-mgmt-table").html(response);
                $("html, body").animate({ scrollTop: $(".admin-mgmt-table").offset().top - 100 }, 300);
            },
            error: function () {
                alert("Error al cambiar de página");
            }
        });
    });




});

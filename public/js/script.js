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





});

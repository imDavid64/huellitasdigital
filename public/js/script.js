$(function () {
    // --- Ventanas Login / Register / Reset ---
    $("#btnLogin").on("click", () => $("#display-login").css("display", "flex"));
    $("#btnRegister").on("click", () => $("#display-register").css("display", "flex"));
    $("#btnResetPass").on("click", () => {
        $("#display-login").hide();
        $("#display-resetPass").css("display", "flex");
    });

    $("#btnCloseXLogin, #btnCloseLogin").on("click", () => $("#display-login").hide());
    $("#btnCloseXRegister, #btnCloseRegister").on("click", () => $("#display-register").hide());
    $("#btnCloseXResetPass, #btnCloseResetPass").on("click", () => $("#display-resetPass").hide());

    $("#btnLoginAddCart").on("click", () => $("#display-login").css("display", "flex"));

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


});

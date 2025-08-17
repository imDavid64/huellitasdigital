$(function () {

    //--------------Acciones de botones registro y login--------------
    $("#btnLogin").on("click", function () {
        $("#display-login").css("display", "flex");
    });

    $("#btnRegister").on("click", function () {
        $("#display-register").css("display", "flex");
    });

    $("#btnCloseXLogin").on("click", function () {
        $("#display-login").css("display", "none");
    });

    $("#btnCloseLogin").on("click", function () {
        $("#display-login").css("display", "none");
    });

    $("#btnCloseXRegister").on("click", function () {
        $("#display-register").css("display", "none");
    });

    $("#btnCloseRegister").on("click", function () {
        $("#display-register").css("display", "none");
    });

    //Abrir o cerrar el menu del usuario
    $("#header-user-img").on("click", function (e) {
        e.stopPropagation();
        $("#header-user-menu").toggle();
    });

    // Ocultar el menú si se hace clic fuera de él
    $(document).on("click", function () {
        $("#header-user-menu").css("display", "none");
    });

    // Prevenir que el menú se cierre si se hace clic dentro del mismo
    $("#header-user-menu").on("click", function (e) {
        e.stopPropagation();
    });

    //Rorar elemento "rotate-sortBy-icon"
    let rotacion = 0;
    let esRotado = false;

    $("#btn-filter-sortBy").on("click", function (e) {
        e.stopPropagation(); // Evita que se cierre al hacer clic en el botón
        esRotado = !esRotado;

        // Rotar el ícono
        $("#rotate-sortBy-icon").css("transform", esRotado ? "rotate(180deg)" : "rotate(0deg)");

        // Mostrar u ocultar el menú
        $("#dropdown-menu").toggle(esRotado);
    });

    // Cerrar el menú al hacer clic fuera
    $(document).on("click", function () {
        esRotado = false;
        $("#rotate-sortBy-icon").css("transform", "rotate(0deg)");
        $("#dropdown-menu").hide();
    });










});
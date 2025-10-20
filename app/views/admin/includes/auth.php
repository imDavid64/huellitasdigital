<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /huellitasdigital/index.php');
    exit;
}

// Función para verificar rol
function checkRole($rolesPermitidos)
{
    if (!in_array($_SESSION['user_role'], $rolesPermitidos)) {
        // Si el rol no está permitido, redirigir o mostrar error
        header('Location: /huellitasdigital/app/views/error403.php'); // Página de acceso denegado
        exit;
    }
}

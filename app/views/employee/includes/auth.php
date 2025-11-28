<?php


if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
    exit;
}

// Función para verificar rol
function checkRole($rolesPermitidos)
{
    if (!in_array($_SESSION['user_role'], $rolesPermitidos)) {
        // Si el rol no está permitido, redirigir o mostrar error
        header("Location: " . BASE_URL . "/index.php?controller=home&action=error403"); // Página de acceso denegado
        exit;
    }
}

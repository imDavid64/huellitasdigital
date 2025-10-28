<?php
// Detectar entorno automáticamente
$base_url = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false)
    ? '/huellitasdigital'
    : '';
?>
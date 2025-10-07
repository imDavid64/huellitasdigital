<?php
include_once __DIR__ . "../conexionDB.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuarioId = intval($_POST['user_id']); // lo obtienes a partir del correo o token
    $nuevaContrasena = $_POST['new_password'];

    // Llamar al procedimiento almacenado
    $stmt = $conn->prepare("CALL HUELLITAS_RECUPERAR_CONTRASENNA_SP(?, ?)");
    if (!$stmt) {
    die("Error al preparar el SP: " . $conn->error);
}
    $stmt->bind_param("is", $usuarioId, $nuevaContrasena);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            echo $row['MENSAJE'];
            header("Location: /huellitasdigital/index.php?message=pass_changed");
        }
    } else {
        echo "❌ Error ejecutando SP: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
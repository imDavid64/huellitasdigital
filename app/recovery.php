<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require_once __DIR__ . "../models/conexionDB.php";

$db = new ConexionDatabase();
$conn = $db->connectDB();
$email = $_POST['resetPass-user-email'];

// ✅ 1. PREPARAR LA CONSULTA para evitar inyección SQL
$query = "SELECT * FROM HUELLITAS_USUARIOS_TB WHERE USUARIO_CORREO = ? AND ID_ESTADO_FK = 1";
$stmt = $conn->prepare($query);

// ✅ 2. VINCULAR EL PARÁMETRO (el email del usuario)
// "s" significa que la variable es un string
$stmt->bind_param("s", $email);

// ✅ 3. EJECUTAR LA CONSULTA
$stmt->execute();
$result = $stmt->get_result(); // Obtener los resultados
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'huellitasdigital.recovery@gmail.com';
        $mail->Password = 'dkhn wfhw fghe vhng'; // Considera usar variables de entorno para esto
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        //$mail->SMTPDebug = 2; // Descomenta solo para depurar

        //Recipients
        $mail->setFrom('huellitasdigital.recovery@gmail.com', 'Huellitas Digital Recovery');
        
        // ✅ 4. CORRECCIÓN PRINCIPAL APLICADA AQUÍ
        $mail->addAddress($email, $row['USUARIO_NOMBRE']); 

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body = 'Hola, para recuperar tu contraseña, haz clic en el siguiente enlace: <a href="http://localhost/huellitasdigital/app/views/client/extras/change-pass.php?id=' . $row['ID_USUARIO_PK'] . '">Restablecer Contraseña</a>';

        $mail->send();
        header("Location: /huellitasdigital/index.php?message=ok");
        
    } catch (Exception $e) {
        // Para depurar, podrías guardar el error en un log: error_log("Mailer Error: " . $mail->ErrorInfo);
        header("Location: /huellitasdigital/index.php?message=error");
    }
} else {
    header("Location: /huellitasdigital/index.php?message=not_found");
}

// ✅ 5. CERRAR EL STATEMENT Y LA CONEXIÓN
$stmt->close();
$conn->close();
?>
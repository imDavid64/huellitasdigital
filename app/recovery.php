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
$query = "SELECT * FROM HUELLITAS_USUARIOS_TB WHERE USUARIO_CORREO = '$email' AND ID_ESTADO_FK = 1";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'huellitasdigital.recovery@gmail.com';                     //SMTP username
        $mail->Password = 'dkhn wfhw fghe vhng';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPDebug  = 2;  // 🔍 Activa debug para ver exactamente por qué falla

        //Recipients
        $mail->setFrom('huellitasdigital.recovery@gmail.com', 'Huellitas Digital Rocovery');
        $mail->addAddress('davidamador0999@gmail.com', 'David');     //Add a recipient            //Name is optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body = 'Hola, para recuperar tu contraseña, haz clic en el siguiente enlace: <a href="localhost/huellitasdigital/app/views/client/extras/change-pass.php?id=' . $row['ID_USUARIO_PK'] . '">Restablecer Contraseña</a>';

        $mail->send();
        header("Location: /huellitasdigital/index.php?message=ok");
        
    } catch (Exception $e) {
        header("Location: /huellitasdigital/index.php?message=error");
    }
} else {
    header("Location: /huellitasdigital/index.php?message=not_found");
}
?>
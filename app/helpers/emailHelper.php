<?php
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../config/bootstrap.php";

class EmailHelper
{
    public static function enviarCorreoVerificacion(string $email, string $nombre, string $token): bool
    {
        if (empty($_ENV['SMTP_USER']) || empty($_ENV['SMTP_PASS'])) {
            error_log('⚠️ Configuración SMTP ausente (.env).');
            return false;
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($_ENV['SMTP_USER'], 'Huellitas Digital');
            $mail->addAddress($email, $nombre);
            $mail->addReplyTo($_ENV['SMTP_USER'], 'Soporte Huellitas Digital');

            $url = BASE_URL . '/index.php?controller=auth&action=verificarCuenta&token=' . urlencode($token);
            $mail->isHTML(true);
            $mail->Subject = 'Verificación de cuenta - Huellitas Digital';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; color: #333;'>
                    <h2>¡Bienvenido a Huellitas Digital, " . htmlspecialchars($nombre) . "!</h2>
                    <p>Haz clic en el siguiente botón para <b>verificar tu cuenta</b>:</p>
                    <p style='text-align:center; margin:20px 0;'>
                        <a href='" . htmlspecialchars($url) . "'
                        style='background:#007bff;color:white;padding:10px 20px;border-radius:5px;text-decoration:none;'>
                        Verificar cuenta
                        </a>
                    </p>
                    <p>Este enlace expirará en 24 horas.</p>
                </div>";

            if (($_ENV['APP_ENV'] ?? '') === 'local') {
                $mail->SMTPDebug = 2;
                $mail->Debugoutput = 'error_log';
            }

            return $mail->send();

        } catch (Exception $e) {
            error_log('❌ Error al enviar correo de verificación: ' . $mail->ErrorInfo);
            return false;
        } finally {
            if (method_exists($mail, 'smtpClose')) {
                $mail->smtpClose();
            }
        }
    }

    public static function enviarCorreoRecuperacion(string $email, string $nombre, string $token): bool
    {
        if (empty($_ENV['SMTP_USER']) || empty($_ENV['SMTP_PASS'])) {
            error_log('⚠️ Configuración SMTP ausente (.env).');
            return false;
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($_ENV['SMTP_USER'], 'Huellitas Digital');
            $mail->addAddress($email, $nombre);
            $mail->addReplyTo($_ENV['SMTP_USER'], 'Soporte Huellitas Digital');

            $url = BASE_URL . '/index.php?controller=auth&action=resetForm&token=' . urlencode($token);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña - Huellitas Digital';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; color:#333;'>
                    <h2>Hola, " . htmlspecialchars($nombre) . " 🐾</h2>
                    <p>Recibimos una solicitud para restablecer tu contraseña.</p>
                    <p style='text-align:center; margin:20px 0;'>
                        <a href='" . htmlspecialchars($url) . "'
                        style='background:#007bff;color:white;padding:10px 20px;border-radius:5px;text-decoration:none;'>
                        Restablecer contraseña
                        </a>
                    </p>
                    <p>Este enlace expirará en <b>15 minutos</b>.</p>
                </div>";

            if (($_ENV['APP_ENV'] ?? '') === 'local') {
                $mail->SMTPDebug = 2;
                $mail->Debugoutput = 'error_log';
            }

            return $mail->send();

        } catch (Exception $e) {
            error_log('❌ Error correo recuperación: ' . $mail->ErrorInfo);
            return false;
        } finally {
            if (method_exists($mail, 'smtpClose')) {
                $mail->smtpClose();
            }
        }
    }

    public static function enviarFacturaCompra(string $email, string $nombre, string $pdfPath): bool
    {
        if (empty($_ENV['SMTP_USER']) || empty($_ENV['SMTP_PASS'])) {
            error_log('⚠️ Configuración SMTP ausente (.env).');
            return false;
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($_ENV['SMTP_USER'], 'Huellitas Digital');
            $mail->addAddress($email, $nombre);
            $mail->addReplyTo($_ENV['SMTP_USER'], 'Soporte Huellitas Digital');

            // Asunto y cuerpo
            $mail->isHTML(true);
            $mail->Subject = 'Factura de tu compra en Huellitas Digital 🐾';
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; color: #333;'>
                <h2>¡Gracias por tu compra, " . htmlspecialchars($nombre) . "!</h2>
                <p>Adjuntamos la factura electrónica de tu pedido.</p>
                <p>Si tienes alguna duda, contáctanos en <b>drahuellitas@gmail.com</b>.</p>
                <p style='margin-top:20px;'>🐾 Con cariño, el equipo de Huellitas Digital.</p>
            </div>";

            // Adjuntar PDF
            if (file_exists($pdfPath)) {
                $mail->addAttachment($pdfPath, basename($pdfPath));
            } else {
                error_log("⚠️ No se encontró el archivo PDF: $pdfPath");
            }

            return $mail->send();
        } catch (Exception $e) {
            error_log('❌ Error al enviar factura: ' . $mail->ErrorInfo);
            return false;
        } finally {
            if (method_exists($mail, 'smtpClose')) {
                $mail->smtpClose();
            }
        }
    }


}
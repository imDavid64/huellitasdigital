<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../app/Helpers/EmailHelper.php';

use App\Helpers\EmailHelper;

// Citas de mañana
$stmt = $db->query("CALL HUELLITAS_OBTENER_CITAS_MANANA_SP()");
while ($row = $stmt->fetch_assoc()) {
    EmailHelper::enviarRecordatorioCita($row);
}
$stmt->close();
$db->next_result();

// Citas dentro de 1 hora
$stmt2 = $db->query("CALL HUELLITAS_OBTENER_CITAS_EN_1_HORA_SP()");
while ($row = $stmt2->fetch_assoc()) {
    EmailHelper::enviarRecordatorioCita($row);
}
$stmt2->close();
$db->next_result();

// Notificaciones de mañana
$db->query("CALL HUELLITAS_GENERAR_NOTIF_CITAS_MANANA_SP()");
$db->next_result();

// Notificaciones de 1 hora
$db->query("CALL HUELLITAS_GENERAR_NOTIF_CITAS_EN_1_HORA_SP()");
$db->next_result();


echo "Recordatorios enviados OK";

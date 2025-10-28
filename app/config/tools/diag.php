<?php
require_once __DIR__ . '/../config/bootstrap.php';

$keys = [
  'APP_ENV', 'DB_HOST', 'DB_USER', 'DB_NAME',
  'FIREBASE_CREDENTIALS', 'FIREBASE_BUCKET', 'SMTP_USER'
];

echo "<h3>Variables definidas</h3><ul>";
foreach ($keys as $k) {
  $val = getenv($k);
  // No imprimas valores completos sensibles; solo si existen y tipo
  if ($k === 'FIREBASE_CREDENTIALS') {
    echo "<li>$k: " . ($val && is_readable($val) ? "OK (legible)" : "NO") . "</li>";
  } else {
    echo "<li>$k: " . ($val ? "OK" : "NO") . "</li>";
  }
}
echo "</ul>";

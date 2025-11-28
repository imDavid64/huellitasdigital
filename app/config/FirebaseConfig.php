<?php
namespace App\Config;

use Kreait\Firebase\Factory;
use Dotenv\Dotenv;
class FirebaseConfig
{
    private $storage;

    public function __construct()
    {
        // Cargar variables del .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $saPath = $_ENV['FIREBASE_CREDENTIALS'] ?? null;
        $bucket = $_ENV['FIREBASE_BUCKET'] ?? null;

        if (!$saPath || !is_readable($saPath)) {
            error_log("FIREBASE_CREDENTIALS no definida o ilegible: " . ($saPath ?: 'NULL'));
            throw new \RuntimeException("Config de Firebase inválida");
        }
        if (!$bucket) {
            error_log("FIREBASE_BUCKET no definida");
            throw new \RuntimeException("Bucket de Firebase no configurado");
        }

        $factory = (new Factory)
            ->withServiceAccount($saPath)
            ->withDefaultStorageBucket($bucket);

        $this->storage = $factory->createStorage();
    }

    private function sanitizeExtension(string $filename): string
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $permitidas)) {
            throw new \RuntimeException("Formato no permitido");
        }
        return $ext;
    }

    public function uploadProductImage($localFilePath, $fileName)
    {
        $bucket = $this->storage->getBucket();
        $firebasePath = 'productos/' . $fileName;

        // Subir archivo
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebasePath]
        );

        // Devolver URL pública
        return "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/" .
            rawurlencode($firebasePath) . "?alt=media";
    }

    public function uploadBrandImage($localFilePath, $fileName)
    {
        $bucket = $this->storage->getBucket();
        $firebasePath = 'productos/marcas/' . $fileName;

        // Subir archivo
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebasePath]
        );

        // Devolver URL pública
        return "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/" .
            rawurlencode($firebasePath) . "?alt=media";
    }


    public function uploadSliderBannerImage($localFilePath, $fileName)
    {
        $bucket = $this->storage->getBucket();
        $firebasePath = 'sliderBanner/' . $fileName;

        // Subir archivo
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebasePath]
        );

        // Devolver URL pública
        return "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/" .
            rawurlencode($firebasePath) . "?alt=media";
    }

    public function uploadServiceImage($localFilePath, $fileName)
    {
        $bucket = $this->storage->getBucket();
        $firebasePath = 'servicios/' . $fileName;

        // Subir archivo
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebasePath]
        );

        // Devolver URL pública
        return "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/" .
            rawurlencode($firebasePath) . "?alt=media";
    }

    public function uploadPaymentReceipt($localFilePath, $fileName)
    {
        $bucket = $this->storage->getBucket();
        $firebasePath = 'comprobantes/' . $fileName;

        // Subir archivo
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebasePath]
        );

        // Devolver URL pública
        return "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/" .
            rawurlencode($firebasePath) . "?alt=media";
    }

    public function uploadUserImage($localFilePath, $fileName)
    {
        $bucket = $this->storage->getBucket();
        $firebasePath = 'fotosPerfil/' . $fileName;

        // Subir archivo
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebasePath]
        );

        // Devolver URL pública
        return "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/" .
            rawurlencode($firebasePath) . "?alt=media";
    }

    public function uploadInvoicePdf($localFilePath, $userId, $orderCode)
    {
        $bucket = $this->storage->getBucket();

        // Carpeta organizada por usuario y código de pedido
        $firebasePath = "facturas/usuario_{$userId}/factura_{$orderCode}.pdf";

        // Subir el archivo al bucket
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebasePath]
        );

        // URL pública o autenticada según tus reglas
        return "https://firebasestorage.googleapis.com/v0/b/" .
            $_ENV['FIREBASE_BUCKET'] .
            "/o/" . rawurlencode($firebasePath) . "?alt=media";
    }

    public function uploadPetImage($localFilePath, $fileName)
    {
        $bucket = $this->storage->getBucket();
        $firebasePath = 'mascotas/' . $fileName;

        // Subir archivo
        $bucket->upload(
            fopen($localFilePath, 'r'),
            ['name' => $firebasePath]
        );

        // Devolver URL pública
        return "https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.firebasestorage.app/o/" .
            rawurlencode($firebasePath) . "?alt=media";
    }

    public function deleteImage($imageUrl)
    {
        try {
            if (empty($imageUrl)) {
                error_log("❌ deleteImage: URL vacía");
                return false;
            }

            // 🔹 Extraer la ruta interna del bucket
            $path = '';

            // Ejemplo: https://firebasestorage.googleapis.com/v0/b/huellitasdigital-443e0.appspot.com/o/productos%2Fmiimagen.jpg?alt=media
            if (preg_match('/\/o\/([^?]+)/', $imageUrl, $matches)) {
                $path = urldecode($matches[1]); // Decodifica productos%2Fmiimagen.jpg → productos/miimagen.jpg
            } else {
                // Intento alternativo: extraer desde la parte de la ruta URL
                $parsedPath = parse_url($imageUrl, PHP_URL_PATH);
                if ($parsedPath) {
                    $decoded = urldecode(basename($parsedPath));
                    $path = "productos/" . $decoded;
                }
            }

            if (empty($path)) {
                error_log("❌ deleteImage: No se pudo extraer la ruta de -> $imageUrl");
                return false;
            }

            // 🔹 Obtener el bucket y el objeto
            $bucket = $this->storage->getBucket();
            $object = $bucket->object($path);

            if (!$object->exists()) {
                error_log("⚠️ deleteImage: El archivo no existe en Firebase -> $path");
                return false;
            }

            // 🔹 Eliminar el archivo
            $object->delete();
            error_log("✅ deleteImage: Archivo eliminado correctamente -> $path");
            return true;

        } catch (\Exception $e) {
            error_log("❌ deleteImage: Error eliminando archivo -> " . $e->getMessage());
            return false;
        }
    }

}
?>
<?php
namespace App\Controllers\Client;

use App\Models\Client\UserModel;
use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;
use App\Models\Client\PetsModel;
use App\Config\FirebaseConfig;

require_once __DIR__ . '/../../config/bootstrap.php';

class PetsController
{
    private UserModel $usuarioModel;
    private ProductModel $productModel;
    private ServiceModel $serviceModel;
    private PetsModel $petsModel;

    public function __construct()
    {
        $this->usuarioModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->serviceModel = new ServiceModel();
        $this->petsModel = new PetsModel();

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Debe iniciar sesión para acceder a esta sección.";
            header("Location: " . BASE_URL . "/index.php?controller=auth&action=index");
            exit;
        }
    }

    public function index()
    {
        $codigoUsuario = $_SESSION['user_code'];
        $idUsuario = $_SESSION['user_id'];

        // Obtener usuario completo
        $usuario = $this->usuarioModel->getUsuarioById($idUsuario);
        $correoUsuario = $usuario['USUARIO_CORREO'] ?? null;
        $estadoActivo = isset($usuario['ID_ESTADO_FK']) && $usuario['ID_ESTADO_FK'] == 1;

        // Verificar si existe cliente veterinario con el mismo correo
        $clienteVetExiste = false;
        $yaVinculado = false;

        if ($correoUsuario) {

            // 1. Verificar si existe cliente veterinario
            $clienteVetExiste = $this->usuarioModel->clienteVeterinarioExiste($correoUsuario);

            // 2. Verificar si el usuario ya está vinculado
            $yaVinculado = !empty($usuario['ID_CLIENTE_VINCULADO_FK']);
        }

        // Obtener mascotas
        $mascotas = [];
        if ($codigoUsuario) {
            $mascotas = $this->petsModel->getPetsByUserCode($codigoUsuario);
        }

        $categories = $this->productModel->getAllActiveCategories();
        $services = $this->serviceModel->getAllActiveServices();

        // Enviar variables a la vista
        require VIEW_PATH . '/client/myPets/home.php';
    }


    public function details(): void
    {
        $codigoMascota = $_GET['codigo'] ?? '';

        $mascota = $this->petsModel->obtenerMascotaPorCodigo($codigoMascota);
        $historiales = $this->petsModel->listarHistorialesResumen($codigoMascota);
        $categories = $this->productModel->getAllActiveCategories();
        $services = $this->serviceModel->getAllActiveServices();

        require VIEW_PATH . '/client/myPets/pet-details.php';
    }

    public function ajaxGetHistory()
    {
        header("Content-Type: application/json");

        $codigoHistorial = $_GET['code'] ?? null;

        if (!$codigoHistorial) {
            echo json_encode(["error" => "Código no proporcionado"]);
            return;
        }

        $historial = $this->petsModel->getMedicalHistoryByCode($codigoHistorial);

        echo json_encode($historial ?: ["error" => "No encontrado"]);
    }

    public function updatePetImage()
    {
        header("Content-Type: application/json");

        if (!isset($_POST['codigo']) || !isset($_FILES['imagenMascota'])) {
            echo json_encode(["success" => false, "error" => "Datos incompletos."]);
            return;
        }

        $codigoMascota = $_POST['codigo'] ?? '';
        $imagen = $_FILES['imagenMascota'];

        // VALIDAR QUE EL ARCHIVO ES UNA IMAGEN REAL
        $mime = mime_content_type($imagen['tmp_name']);
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

        if (!in_array($mime, $allowed)) {
            echo json_encode(["success" => false, "error" => "El archivo no es una imagen válida."]);
            return;
        }

        // Validación adicional usando getimagesize()
        if (!@getimagesize($imagen['tmp_name'])) {
            echo json_encode(["success" => false, "error" => "El archivo no es una imagen real."]);
            return;
        }

        if ($imagen['size'] > 5 * 1024 * 1024) { // 5MB máximo
            echo json_encode(["success" => false, "error" => "La imagen supera el tamaño máximo permitido (5MB)."]);
            return;
        }

        $ext = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowedExt)) {
            echo json_encode(["success" => false, "error" => "Formato de imagen no permitido."]);
            return;
        }



        try {
            if ($imagen['error'] !== 0) {
                echo json_encode(["success" => false, "error" => "Error al cargar archivo"]);
                return;
            }

            $firebase = new FirebaseConfig();

            // 1️⃣ OBTENER IMAGEN ACTUAL
            $mascota = $this->petsModel->obtenerMascotaPorCodigo($codigoMascota);
            $oldImageUrl = $mascota['MASCOTA_IMAGEN_URL'] ?? null;

            // 2️⃣ BORRAR IMAGEN ANTERIOR (si existe)
            if (!empty($oldImageUrl)) {
                $firebase->deleteImage($oldImageUrl);
            }

            // 3️⃣ SUBIR LA NUEVA IMAGEN A FIREBASE
            $fileName = "MASCOTA_" . $codigoMascota . "_" . time() . "." . pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $tempFile = $imagen['tmp_name'];

            $urlImagen = $firebase->uploadPetImage($tempFile, $fileName);

            // 4️⃣ GUARDAR URL NUEVA EN BD
            $ok = $this->petsModel->actualizarImagenMascota($codigoMascota, $urlImagen);

            if ($ok) {
                echo json_encode(["success" => true, "newUrl" => $urlImagen]);
            } else {
                echo json_encode(["success" => false, "error" => "No se pudo actualizar en BD"]);
            }

        } catch (\Throwable $e) {
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }
}
<?php
namespace App\Controllers\Client;

use App\Models\Client\UserModel;
use App\Models\Client\ProductModel;
use App\Models\Client\ServiceModel;
use App\Models\Client\PetsModel;

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
        $categories = $this->productModel->getAllActiveCategories();
        $services = $this->serviceModel->getAllActiveServices();

        require VIEW_PATH . '/client/myPets/pet-details.php';
    }
}
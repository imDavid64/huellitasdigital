<?php
namespace App\Controllers\Employee;

use App\Models\Admin\CatalogModel;
use App\Models\Employee\ClientModel;
use App\Models\Employee\PetModel;
use App\Config\FirebaseConfig;

class EmployeePetController
{
    private ClientModel $clientModel;
    private PetModel $petModel;
    private CatalogModel $catalogModel;
    private FirebaseConfig $firebase;

    public function __construct()
    {
        // ✅ Solo empleados o administradores
        if (
            !isset($_SESSION['user_role']) ||
            ($_SESSION['user_role'] !== 'EMPLEADO' && $_SESSION['user_role'] !== 'ADMINISTRADOR')
        ) {
            header("Location: " . BASE_URL . "/index.php?controller=home&action=error403");
            exit;
        }

        $this->clientModel = new ClientModel();
        $this->catalogModel = new CatalogModel();
        $this->petModel = new PetModel();
        $this->firebase = new FirebaseConfig();
    }

    public function details()
    {
        $codigo = $_GET['codigo'] ?? '';

        if (empty($codigo)) {
            $_SESSION['error'] = "❌ Código de mascota no proporcionado.";
            header("Location: " . BASE_URL . "/index.php?controller=employeePet&action=index");
            exit;
        }

        $mascota = $this->petModel->obtenerMascotaPorCodigo($codigo);
        $historiales = $this->petModel->obtenerHistorialesMedicos($codigo);

        require VIEW_PATH . "/employee/pet-mgmt/pet-details.php";
    }


    public function create()
    {
        // Puede llegar ?cliente= o ?usuario=
        $codigoCliente = $_GET['cliente'] ?? null;
        $codigoUsuario = $_GET['usuario'] ?? null;

        if (!$codigoCliente && !$codigoUsuario) {
            die("Código de cliente o usuario no proporcionado.");
        }

        // Definimos el tipo de dueño
        $tipoPropietario = $codigoCliente ? 'CLIENTE' : 'USUARIO';

        $estados = $this->catalogModel->getActiveInactiveStates();
        $especies = $this->petModel->obtenerEspecies();
        $razas = [];

        require VIEW_PATH . "/employee/pet-mgmt/add-pet.php";
    }

    public function store()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['EXITO' => 0, 'MENSAJE' => 'Método no permitido']);
            return;
        }

        $estadoId = intval($_POST['estado_id'] ?? 1);
        $especieId = intval($_POST['especie_id'] ?? 0);
        $razaId = intval($_POST['raza_id'] ?? 0);

        $codigoUsuario = trim($_POST['codigo_usuario'] ?? "");
        $codigoCliente = trim($_POST['codigo_cliente'] ?? "");

        $nombre = trim($_POST['nombre_mascota'] ?? '');
        $fechaNacimiento = $_POST['fecha_nacimiento'] ?? null;
        $genero = trim($_POST['genero'] ?? '');
        $creadoPor = $_SESSION['user_name'] ?? 'Empleado';
        error_log("AGREGAR MASCOTA - COD_USUARIO: {$codigoUsuario} | COD_CLIENTE: {$codigoCliente}");

        $imagenUrl = null;

        if (!empty($_FILES['imagen_file']['tmp_name'])) {

            // 🔍 DEBUG: ver datos del archivo
            error_log('IMAGEN FILE PET: ' . print_r($_FILES['imagen_file'], true));

            // Verificar si hubo error de upload
            if ($_FILES['imagen_file']['error'] !== UPLOAD_ERR_OK) {
                error_log('❌ Error al subir imagen de mascota. Código: ' . $_FILES['imagen_file']['error']);
            } else {
                $file = $_FILES['imagen_file']['tmp_name'];
                $fileName = uniqid("pet_") . "_" . $_FILES['imagen_file']['name'];

                try {
                    $imagenUrl = $this->firebase->uploadPetImage($file, $fileName);
                    error_log("✅ URL IMAGEN MASCOTA GENERADA: " . $imagenUrl);
                } catch (\Throwable $e) {
                    error_log("❌ Excepción en uploadPetImage: " . $e->getMessage());
                }
            }
        } else {
            error_log('⚠️ No se recibió archivo en imagen_file o tmp_name viene vacío');
        }

        $resultado = $this->petModel->agregarMascota(
            $estadoId,
            $especieId,
            $razaId,
            $codigoUsuario,
            $codigoCliente,
            $nombre,
            $fechaNacimiento,
            $genero,
            $imagenUrl,
            $creadoPor
        );

        $resultado["CODIGO_CLIENTE"] = $codigoCliente ?: $codigoUsuario;
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);

    }



    public function edit()
    {
        $codigo = $_GET['codigo'] ?? '';

        if (empty($codigo)) {
            exit("❌ Código inválido.");
        }

        $mascota = $this->petModel->obtenerMascotaPorCodigo($codigo);
        $estados = $this->catalogModel->getActiveInactiveStates();
        $especies = $this->petModel->obtenerEspecies();
        $razas = [];

        require VIEW_PATH . "/employee/pet-mgmt/edit-pet.php";
    }

    public function update()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['EXITO' => 0, 'MENSAJE' => 'Método no permitido']);
            return;
        }

        $codigoMascota = trim($_POST['codigo_mascota'] ?? '');
        if (empty($codigoMascota)) {
            echo json_encode(['EXITO' => 0, 'MENSAJE' => 'Código de mascota no válido']);
            return;
        }

        $estadoId = intval($_POST['estado_id'] ?? 1);
        $especieId = intval($_POST['especie_id'] ?? 0);
        $razaId = intval($_POST['raza_id'] ?? 0);

        $nombre = trim($_POST['nombre_mascota'] ?? '');
        $fechaNacimiento = $_POST['fecha_nacimiento'] ?? null;
        $genero = trim($_POST['genero'] ?? '');
        $modificadoPor = $_SESSION['user_name'] ?? 'Empleado';
        $currentImage = $_POST['current_image_url'] ?? null;
        $imagenUrl = $currentImage;

        // Si sube una nueva imagen
        if (!empty($_FILES['imagen_file']['tmp_name'])) {
            $file = $_FILES['imagen_file']['tmp_name'];
            $fileName = uniqid("pet_") . "_" . $_FILES['imagen_file']['name'];

            $uploadedUrl = $this->firebase->uploadPetImage($file, $fileName);

            if ($uploadedUrl) {
                if (!empty($currentImage)) {
                    $this->firebase->deleteImage($currentImage);
                }
                $imagenUrl = $uploadedUrl;
            }
        }

        $resultado = $this->petModel->editarMascota(
            $codigoMascota,
            $estadoId,
            $especieId,
            $razaId,
            $nombre,
            $fechaNacimiento,
            $genero,
            $imagenUrl,
            $modificadoPor
        );

        $resultado["CODIGO_MASCOTA"] = $codigoMascota;
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }


    public function cargarRazasPorEspecie()
    {
        header('Content-Type: application/json');

        $idEspecie = intval($_GET['id_especie'] ?? 0);

        if ($idEspecie <= 0) {
            echo json_encode(['success' => false, 'mensaje' => 'Especie inválida']);
            return;
        }

        $this->petModel = new PetModel();
        $razas = $this->petModel->obtenerRazasPorEspecie($idEspecie);

        echo json_encode(['success' => true, 'razas' => $razas], JSON_UNESCAPED_UNICODE);
    }

    public function buscarRazasPorEspecie()
    {
        header('Content-Type: application/json');

        $idEspecie = intval($_GET['id_especie'] ?? 0);
        $busqueda = trim($_GET['q'] ?? '');

        if ($idEspecie <= 0) {
            echo json_encode(['success' => false, 'mensaje' => 'Especie inválida']);
            return;
        }

        $this->petModel = new PetModel();
        $razas = $this->petModel->buscarRazasPorEspecie($idEspecie, $busqueda);

        echo json_encode(['success' => true, 'razas' => $razas], JSON_UNESCAPED_UNICODE);
    }
}

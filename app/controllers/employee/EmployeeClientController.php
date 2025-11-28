<?php
namespace App\Controllers\Employee;

use App\Models\Admin\CatalogModel;
use App\Models\Employee\ClientModel;

class EmployeeClientController
{
    private ClientModel $clientModel;
    private CatalogModel $catalogModel;

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
    }

    public function index()
    {
        $query = '';
        $page = 1;
        $limit = 10;
        $offset = 0;

        $clientes = $this->clientModel->searchAllPaginated($query, $limit, $offset);
        $total = $this->clientModel->countAll($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/employee/client-mgmt/client-mgmt.php";
    }

    public function search()
    {
        $query = trim($_GET['query'] ?? '');
        $page = intval($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $clientes = $this->clientModel->searchAllPaginated($query, $limit, $offset);
        $total = $this->clientModel->countAll($query);
        $totalPages = ceil($total / $limit);

        require VIEW_PATH . "/employee/client-mgmt/partials/client-table.php";
    }


    public function create()
    {
        $catalogModel = new CatalogModel();
        // === Listas dinámicas ===
        $provincias = $catalogModel->getAllProvincias();
        $cantones = $catalogModel->getCantonesByProvincia($user['ID_DIRECCION_PROVINCIA_FK'] ?? null);
        $distritos = $catalogModel->getDistritosByCanton($user['ID_DIRECCION_CANTON_FK'] ?? null);

        $estados = $this->catalogModel->getActiveInactiveStates();
        require VIEW_PATH . "/employee/client-mgmt/add-client.php";
    }


    public function store()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['EXITO' => 0, 'MENSAJE' => 'Método no permitido']);
            exit;
        }

        $nombre = trim($_POST['cliente_nombre'] ?? '');
        $correo = trim($_POST['cliente_correo'] ?? '');
        $identificacion_raw = $_POST['cliente_identificacion'] ?? '';
        $telefono_raw = $_POST['telefono_id'] ?? '';

        $identificacion = ($identificacion_raw === '') ? null : preg_replace('/\D+/', '', $identificacion_raw);
        $telefono = ($telefono_raw === '') ? null : preg_replace('/\D+/', '', $telefono_raw);

        $provinciaId = intval($_POST['provincia'] ?? 0);
        $cantonId = intval($_POST['canton'] ?? 0);
        $distritoId = intval($_POST['distrito'] ?? 0);
        $senas = trim($_POST['senas'] ?? '');
        $observaciones = trim($_POST['cliente_observaciones'] ?? '');
        $estadoId = intval($_POST['estado_id'] ?? 1);
        $creadoPor = $_SESSION['user_name'] ?? 'Empleado desconocido';

        // ✅ Verificación de correo duplicado (clientes o usuarios)
        if ($this->clientModel->correoExistenteEnClientesOUsuarios($correo)) {
            echo json_encode(['EXITO' => 0, 'MENSAJE' => '⚠️ Ya existe un cliente o usuario con ese correo.']);
            exit;
        }


        // ✅ Crear dirección si aplica
        $direccionId = null;
        if ($provinciaId && $cantonId && $distritoId && !empty($senas)) {
            $direccionId = $this->clientModel->crearDireccion($provinciaId, $cantonId, $distritoId, $senas);
        }

        // ✅ Crear teléfono si aplica
        $telefonoId = null;
        if (!empty($telefono)) {
            $telefonoId = $this->clientModel->crearTelefono($telefono);
        }

        $resultado = $this->clientModel->agregarCliente(
            $nombre,
            $correo,
            $identificacion,
            $direccionId,
            $telefonoId,
            $observaciones,
            $estadoId,
            $creadoPor
        );

        echo json_encode($resultado);
        exit;
    }

    public function edit()
    {
        $codigo = $_GET['codigo'] ?? '';

        if (empty($codigo)) {
            exit("❌ Código inválido.");
        }

        $cliente = $this->clientModel->obtenerClientePorCodigo($codigo);

        if (!$cliente || empty($cliente['EXITO']) || $cliente['EXITO'] == 0) {
            exit("❌ No se encontró información del cliente.");
        }

        if (strtoupper($cliente['TIPO'] ?? '') === 'USUARIO') {
            exit("⚠️ No está permitido editar un usuario desde este módulo.");
        }

        // Listas desplegables
        $provincias = $this->catalogModel->getAllProvincias();
        $cantones = $this->catalogModel->getCantonesByProvincia($cliente['PROVINCIA'] ?? null);
        $distritos = $this->catalogModel->getDistritosByCanton($cliente['CANTON'] ?? null);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/employee/client-mgmt/edit-client.php";
    }

    public function update()
    {
        header('Content-Type: application/json');
        ob_clean();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['EXITO' => 0, 'MENSAJE' => 'Método no permitido']);
            exit;
        }

        $codigoCliente = trim($_POST['codigo_cliente'] ?? '');
        $nombre = trim($_POST['cliente_nombre'] ?? '');
        $identificacion = trim($_POST['cliente_identificacion'] ?? '');
        $telefonoRaw = $_POST['telefono_id'] ?? '';
        $provinciaId = intval($_POST['provincia'] ?? 0);
        $cantonId = intval($_POST['canton'] ?? 0);
        $distritoId = intval($_POST['distrito'] ?? 0);
        $senas = trim($_POST['senas'] ?? '');
        $observaciones = trim($_POST['cliente_observaciones'] ?? '');
        $estadoId = intval($_POST['estado_id'] ?? 1);

        $identificacion = ($identificacion === '') ? null : preg_replace('/\D+/', '', $identificacion);
        $telefono = ($telefonoRaw === '') ? null : preg_replace('/\D+/', '', $telefonoRaw);

        $direccionId = null;
        if ($provinciaId && $cantonId && $distritoId && !empty($senas)) {
            $direccionId = $this->clientModel->crearDireccion($provinciaId, $cantonId, $distritoId, $senas);
        }

        $telefonoId = null;
        if (!empty($telefono)) {
            $telefonoId = $this->clientModel->crearTelefono($telefono);
        }

        $resultado = $this->clientModel->actualizarCliente(
            $codigoCliente,
            $nombre,
            $identificacion,
            $direccionId,
            $telefonoId,
            $observaciones,
            $estadoId
        );

        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        exit;
    }


    public function details()
    {
        $codigo = $_GET['codigo'] ?? '';
        $tipo = $_GET['tipo'] ?? 'CLIENTE';

        if (empty($codigo)) {
            exit("❌ Código inválido.");
        }

        $resultado = $this->clientModel->obtenerDetalleCliente($codigo, $tipo);

        $cliente = $resultado['cliente'];
        $mascotas = $resultado['mascotas'];

        if (!$cliente) {
            exit("❌ No se encontró información del cliente o usuario.");
        }

        require VIEW_PATH . "/employee/client-mgmt/client-details.php";
    }


}

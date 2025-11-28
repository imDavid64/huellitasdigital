<?php
namespace App\Controllers\Employee;

use App\Models\Admin\CatalogModel;
use App\Models\Employee\ClientModel;
use App\Models\Employee\AppointmentModel;

class EmployeeAppointmentController
{
    private AppointmentModel $appointmentModel;
    private CatalogModel $catalogModel;
    private ClientModel $clientModel;

    public function __construct()
    {
        // Solo empleados o administradores


        $this->appointmentModel = new AppointmentModel();
        $this->catalogModel = new CatalogModel();
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        $citas = $this->appointmentModel->obtenerCitasFullCalendar();

        require VIEW_PATH . "/employee/appointment-mgmt/appointment-mgmt.php";
    }

    public function api()
    {
        header("Content-Type: application/json");

        $citas = $this->appointmentModel->obtenerCitasFullCalendar();

        echo json_encode($citas, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function create()
    {
        $servicios = $this->appointmentModel->getAllServices();
        $empleados = $this->appointmentModel->getAllEmployees();
        require VIEW_PATH . "/employee/appointment-mgmt/add-appointment.php";
    }

    public function store()
    {
        header("Content-Type: application/json");

        $clienteManual = isset($_POST['cliente_manual']) && !empty($_POST['cliente_manual'])
            ? $_POST['cliente_manual']
            : null;

        $data = [
            'id_vet' => $_POST['id_vet'] ?? null,
            'id_servicio' => $_POST['id_servicio'] ?? null,
            'codigo_cliente' => $_POST['codigo_cliente'] ?? null,
            'codigo_usuario' => $_POST['codigo_usuario'] ?? null,
            'start' => $_POST['start'] ?? null,
            'end' => $_POST['end'] ?? null,
            'motivo' => $_POST['motivo'] ?? '',
            'json_mascotas' => $_POST['json_mascotas'] ?? '[]',
            'cliente_manual' => $clienteManual
        ];

        $result = $this->appointmentModel->agendarCita($data);

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function obtenerMascotas()
    {
        header("Content-Type: application/json");

        $codigo = $_GET['codigo'] ?? null;

        if (!$codigo) {
            echo json_encode([]);
            exit;
        }

        $mascotas = $this->appointmentModel->obtenerMascotasPorCodigo($codigo);

        echo json_encode($mascotas, JSON_UNESCAPED_UNICODE);
        exit;
    }



    public function buscarCliente()
    {
        header("Content-Type: application/json");

        $term = $_GET['q'] ?? '';

        $clientes = $this->clientModel->searchAllPaginated($term, 10, 0);

        echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
        exit;
    }


}

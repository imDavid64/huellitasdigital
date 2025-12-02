<?php
namespace App\Controllers\Employee;

use App\Models\Admin\CatalogModel;
use App\Models\Employee\PetModel;
use App\Models\Employee\MedicalHistoryModel;

class EmployeeMedicalHistoryController
{
    private PetModel $petModel;
    private MedicalHistoryModel $medicalHistoryModel;
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

        $this->petModel = new PetModel();
        $this->medicalHistoryModel = new MedicalHistoryModel();
        $this->catalogModel = new CatalogModel();
    }

    public function details()
    {
        $codigo = $_GET['codigo'] ?? '';
        $codigoMascota = $_GET['codigo_mascota'] ?? '';

        if (empty($codigo)) {
            $_SESSION['error'] = "❌ Código de historial médico no proporcionado.";
            header("Location: " . BASE_URL . "/index.php?controller=employeePet&action=index");
            exit;
        }

        $mascota = $this->petModel->obtenerMascotaPorCodigo($codigoMascota);
        $historial = $this->medicalHistoryModel->getMedicalHistoryByCode($codigo);
        require VIEW_PATH . "/employee/medicalHistory-mgmt/medicalHistory-details.php";
    }

    public function create()
    {
        $codigoMascota = $_GET['codigo'] ?? '';

        if (empty($codigoMascota)) {
            exit("❌ Código de mascota no proporcionado.");
        }

        $mascota = $this->petModel->obtenerMascotaPorCodigo($codigoMascota);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/employee/medicalHistory-mgmt/add-medicalHistory.php";
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit("❌ Método no permitido.");
        }

        // Recibir valores obligatorios
        $codigoMascota = $_POST['id_mascota'] ?? null;
        $idEstado = $_POST['id_estado'] ?? null;

        if (!$codigoMascota || !$idEstado) {
            exit("❌ Datos requeridos faltantes.");
        }

        // Convertidor de vacío a null
        $safe = fn($val) => ($val === '' ? null : $val);

        // ================================================
        // MAPEAR TODO EL FORMULARIO AL ARREGLO DE SP
        // ================================================

        $data = [
            'codigo_mascota' => $codigoMascota,
            'id_estado' => $idEstado,

            'historia_clinica' => $safe($_POST['historia_clinica']),
            'anamnesis' => $safe($_POST['anamnesis']),

            'peso' => $safe($_POST['peso']),
            'temperatura' => $safe($_POST['temperatura']),
            'frecuencia_cardiaca' => $safe($_POST['frecuencia_cardiaca']),
            'frecuencia_respiratoria' => $safe($_POST['frecuencia_respiratoria']),

            'sonidos_pulmonares' => $safe($_POST['sonidos_pulmonares']),
            'condicion_corporal' => $safe($_POST['condicion_corporal']),
            'reflejo_deglutorio' => $safe($_POST['reflejo_deglutorio']),
            'reflejo_tusigeno' => $safe($_POST['reflejo_tusigeno']),
            'linfonodos' => $safe($_POST['linfonodos']),
            'palpacion_abdominal' => $safe($_POST['palpacion_abdominal']),
            'piel' => $safe($_POST['piel']),
            'mucosa' => $safe($_POST['mucosa']),
            'pulso' => $safe($_POST['pulso']),
            'estado_mental' => $safe($_POST['estado_mental']),

            'lista_diagnostico_presuntivo' => $safe($_POST['diagnostico_presuntivo']),
            'lista_depurada' => $safe($_POST['lista_depurada']),
            'examenes' => $safe($_POST['examenes']),
            'diagnostico_final' => $safe($_POST['diagnostico_final']),

            'historial_diagnostico' => null,
            'historial_tratamiento' => null,
            'historial_notas' => null,
        ];


        // Ejecutar el procedimiento SP
        $this->medicalHistoryModel->addMedicalHistory($data);

        // Redireccionar al expediente
        header("Location: " . BASE_URL . "/index.php?controller=employeePet&action=details&codigo={$codigoMascota}&msg=historial_ok");
        exit();
    }

    public function edit()
    {
        $codigo = $_GET['codigo'] ?? '';
        $codigoMascota = $_GET['codigo_mascota'] ?? '';

        if (empty($codigo)) {
            exit("❌ Código de historial no proporcionado.");
        }

        $mascota = $this->petModel->obtenerMascotaPorCodigo($codigoMascota);
        $historial = $this->medicalHistoryModel->getMedicalHistoryByCode($codigo);
        $estados = $this->catalogModel->getActiveInactiveStates();

        require VIEW_PATH . "/employee/medicalHistory-mgmt/edit-medicalHistory.php";
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit("❌ Método no permitido.");
        }

        $codigoHistorial = $_POST['codigo_historial'] ?? null;
        $codigoMascota = $_POST['codigo_mascota'] ?? null;

        if (!$codigoHistorial || !$codigoMascota) {
            exit("❌ Código de historial o mascota faltante.");
        }

        $safe = fn($v) => ($v === "" ? null : $v);

        // Mapear datos al SP
        $data = [
            'codigo_historial' => $codigoHistorial,
            'id_estado' => $_POST['id_estado'],

            'historia_clinica' => $safe($_POST['historia_clinica']),
            'anamnesis' => $safe($_POST['anamnesis']),

            'peso' => $safe($_POST['peso']),
            'temperatura' => $safe($_POST['temperatura']),
            'frecuencia_cardiaca' => $safe($_POST['frecuencia_cardiaca']),
            'frecuencia_respiratoria' => $safe($_POST['frecuencia_respiratoria']),

            'sonidos_pulmonares' => $safe($_POST['sonidos_pulmonares']),
            'condicion_corporal' => $safe($_POST['condicion_corporal']),
            'reflejo_deglutorio' => $safe($_POST['reflejo_deglutorio']),
            'reflejo_tusigeno' => $safe($_POST['reflejo_tusigeno']),
            'linfonodos' => $safe($_POST['linfonodos']),
            'palpacion_abdominal' => $safe($_POST['palpacion_abdominal']),
            'piel' => $safe($_POST['piel']),
            'mucosa' => $safe($_POST['mucosa']),
            'pulso' => $safe($_POST['pulso']),
            'estado_mental' => $safe($_POST['estado_mental']),

            'diagnostico_presuntivo' => $safe($_POST['diagnostico_presuntivo']),
            'lista_depurada' => $safe($_POST['lista_depurada']),
            'examenes' => $safe($_POST['examenes']),
            'diagnostico_final' => $safe($_POST['diagnostico_final'])
        ];

        // Ejecutar SP
        $this->medicalHistoryModel->updateMedicalHistory($data);

        // Redirigir con mensaje
        header(
            "Location: " . BASE_URL .
            "/index.php?controller=employeeMedicalHistory&action=details" .
            "&codigo={$codigoHistorial}&codigo_mascota={$codigoMascota}&msg=edit_ok"
        );
        exit();
    }


}

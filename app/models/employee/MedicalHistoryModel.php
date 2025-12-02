<?php
namespace App\Models\Employee;

use App\Models\BaseModel;
use mysqli_sql_exception;

class MedicalHistoryModel extends BaseModel
{
    public function addMedicalHistory(array $data)
    {
        try {
            $stmt = $this->conn->prepare("
            CALL HUELLITAS_AGREGAR_HISTORIAL_MEDICO_SP(
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ");

            if (!$stmt) {
                throw new mysqli_sql_exception("Error preparando SP: " . $this->conn->error);
            }
            $stmt->bind_param(
                "sissddiisssssssssssssssss",

                $data['codigo_mascota'],
                $data['id_estado'],

                $data['historia_clinica'],
                $data['anamnesis'],

                $data['peso'],
                $data['temperatura'],
                $data['frecuencia_cardiaca'],
                $data['frecuencia_respiratoria'],

                $data['sonidos_pulmonares'],
                $data['condicion_corporal'],
                $data['reflejo_deglutorio'],
                $data['reflejo_tusigeno'],
                $data['linfonodos'],
                $data['palpacion_abdominal'],
                $data['piel'],
                $data['mucosa'],
                $data['pulso'],
                $data['estado_mental'],

                $data['lista_diagnostico_presuntivo'],
                $data['lista_depurada'],
                $data['examenes'],
                $data['diagnostico_final'],

                $data['historial_diagnostico'],
                $data['historial_tratamiento'],
                $data['historial_notas']
            );

            $stmt->execute();
            $stmt->close();

            // Limpiar resultados del SP
            while ($this->conn->more_results()) {
                $this->conn->next_result();
            }

            return true;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMedicalHistoryByCode($codigoHistorial)
    {
        try {
            $stmt = $this->conn->prepare("
                CALL HUELLITAS_OBTENER_HISTORIAL_COMPLETO_SP(?)
            ");

            if (!$stmt) {
                throw new mysqli_sql_exception(
                    "Error preparando SP: " . $this->conn->error
                );
            }

            // Parámetros pueden ser NULL
            $stmt->bind_param(
                "s",
                $codigoHistorial
            );

            $stmt->execute();

            $result = $stmt->get_result();
            $historial = $result->fetch_assoc(); // solo devuelve 1 registro

            $stmt->close();

            // Limpiar resultsets adicionales
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $historial ?: null;

        } catch (\Throwable $e) {
            error_log("Error en obtenerHistorialCompleto: " . $e->getMessage());
            return null;
        }
    }

    public function updateMedicalHistory(array $data)
    {
        try {
            $stmt = $this->conn->prepare("
            CALL HUELLITAS_ACTUALIZAR_HISTORIAL_MEDICO_SP(
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ");

            if (!$stmt) {
                throw new mysqli_sql_exception("Error preparando SP: " . $this->conn->error);
            }

            $stmt->bind_param(
                "sissddiissssssssssssss",

                $data['codigo_historial'],
                $data['id_estado'],

                $data['historia_clinica'],
                $data['anamnesis'],

                $data['peso'],
                $data['temperatura'],
                $data['frecuencia_cardiaca'],
                $data['frecuencia_respiratoria'],

                $data['sonidos_pulmonares'],
                $data['condicion_corporal'],
                $data['reflejo_deglutorio'],
                $data['reflejo_tusigeno'],
                $data['linfonodos'],
                $data['palpacion_abdominal'],
                $data['piel'],
                $data['mucosa'],
                $data['pulso'],
                $data['estado_mental'],

                $data['diagnostico_presuntivo'],
                $data['lista_depurada'],
                $data['examenes'],
                $data['diagnostico_final']
            );

            $stmt->execute();

            if ($stmt->errno) {
                throw new mysqli_sql_exception("Error ejecutando SP: " . $stmt->error);
            }

            $stmt->close();
            return true;

        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }



}
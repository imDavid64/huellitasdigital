<?php
namespace App\Models\Employee;

use App\Models\BaseModel;

class AppointmentModel extends BaseModel
{
    public function agendarCita($data)
    {
        try {
            // Normalizar NULLs
            $codigoCliente = !empty($data['codigo_cliente']) ? $data['codigo_cliente'] : null;
            $codigoUsuario = !empty($data['codigo_usuario']) ? $data['codigo_usuario'] : null;

            $jsonMascotas = $data['json_mascotas'] ?? '[]';
            $clienteManual = $data['cliente_manual'] ?? null;

            $stmt = $this->conn->prepare(
                "CALL HUELLITAS_AGENDAR_CITA_SP(
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                    @OUT_ID_CITA, @OUT_MENSAJE
                )"
            );

            $stmt->bind_param(
                "iisssssss",
                $data['id_vet'],
                $data['id_servicio'],
                $codigoCliente,
                $codigoUsuario,
                $data['start'],
                $data['end'],
                $data['motivo'],
                $jsonMascotas,
                $clienteManual
            );

            $stmt->execute();
            $stmt->close();

            // Limpia resultsets previos
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            // Obtener OUT parameters
            $result = $this->conn->query("SELECT @OUT_ID_CITA AS ID_CITA, @OUT_MENSAJE AS MENSAJE");
            $row = $result->fetch_assoc();

            return [
                'EXITO' => ($row['ID_CITA'] !== null) ? 1 : 0,
                'ID_CITA' => $row['ID_CITA'],
                'MENSAJE' => $row['MENSAJE']
            ];

        } catch (\Throwable $e) {
            error_log("Error agendarCita: " . $e->getMessage());
            return ['EXITO' => 0, 'MENSAJE' => '❌ Error al agendar la cita (Model).'];
        }
    }

    public function obtenerCitasFullCalendar()
    {
        try {
            $rs = $this->conn->query("CALL HUELLITAS_LISTAR_CITAS_FULLCALENDAR_SP(NULL,NULL,NULL,NULL)");
            $events = $rs->fetch_all(MYSQLI_ASSOC);

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $events;

        } catch (\Throwable $e) {
            error_log("Error obtenerCitasFullCalendar: " . $e->getMessage());
            return [];
        }
    }

    public function searchAllPaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_TODOS_CLIENTES_USUARIOS_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $clientes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $clientes;
    }

    public function getAllServices()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_SERVICIOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $data;
    }

    public function getServiceById($id_servicio)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_SERVICIO_POR_ID_SP(?)");
        $stmt->bind_param("i", $id_servicio);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $data;
    }

    public function getAllEmployees()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_EMPLEADOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $data;
    }

    public function obtenerMascotasPorCodigo($codigo)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_MASCOTAS_SP(?)");
            $stmt->bind_param("s", $codigo);
            $stmt->execute();

            $result = $stmt->get_result();
            $mascotas = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $mascotas;

        } catch (\Throwable $e) {
            error_log("Error obtenerMascotasPorCodigo: " . $e->getMessage());
            return [];
        }
    }

    public function cancelarCita($idCita)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_CANCELAR_CITA_SP(?, @OUT_MENSAJE)");
            $stmt->bind_param("i", $idCita);
            $stmt->execute();
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            $result = $this->conn->query("SELECT @OUT_MENSAJE AS MENSAJE");
            $row = $result->fetch_assoc();

            return [
                'EXITO' => 1,
                'MENSAJE' => $row['MENSAJE'] ?? "Cita cancelada correctamente"
            ];

        } catch (\Throwable $e) {
            error_log("Error cancelarCita: " . $e->getMessage());
            return ['EXITO' => 0, 'MENSAJE' => 'Error al cancelar la cita'];
        }
    }




}
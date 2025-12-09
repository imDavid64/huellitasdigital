<?php
namespace App\Models\Employee;

use App\Models\BaseModel;
use mysqli_sql_exception;

class ClientModel extends BaseModel
{
    public function agregarCliente($nombre, $correo, $identificacion, $direccionId, $telefonoId, $observaciones, $estadoId, $creadoPor)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_AGREGAR_CLIENTE_SP(?, ?, ?, ?, ?, ?, ?, ?)");

            if (empty($direccionId))
                $direccionId = null;
            if (empty($telefonoId))
                $telefonoId = null;

            $stmt->bind_param(
                "sssiisis",
                $nombre,
                $correo,
                $identificacion,
                $direccionId,
                $telefonoId,
                $observaciones,
                $estadoId,
                $creadoPor
            );

            $stmt->execute();

            $stmt->store_result();

            // Initialize variables to avoid "use of unassigned variable" warnings
            $id_cliente = null;
            $exito = null;
            $mensaje = null;

            $stmt->bind_result($id_cliente, $exito, $mensaje);
            $stmt->fetch();

            $result = [
                'ID_CLIENTE' => $id_cliente,
                'EXITO' => $exito,
                'MENSAJE' => $mensaje
            ];

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $result;
        } catch (\Throwable $e) {
            error_log("Error en agregarCliente: " . $e->getMessage());
            return ['EXITO' => 0, 'MENSAJE' => '❌ Error interno.'];
        }
    }

    public function actualizarCliente($codigoCliente, $nombre, $identificacion, $direccionId, $telefonoId, $observaciones, $estadoId)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_CLIENTE_SP(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssiiis",
                $codigoCliente,
                $nombre,
                $identificacion,
                $direccionId,
                $telefonoId,
                $observaciones,
                $estadoId
            );

            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return [
                'EXITO' => $result['EXITO'] ?? 0,
                'MENSAJE' => $result['MENSAJE'] ?? '❌ Error desconocido.'
            ];
        } catch (\Throwable $e) {
            error_log("Error en actualizarCliente: " . $e->getMessage());
            return ['EXITO' => 0, 'MENSAJE' => '❌ Error interno al actualizar el cliente.'];
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


    public function countAll($query)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_CONTAR_TODOS_CLIENTES_USUARIOS_SP(?)");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result['TOTAL'] ?? 0;
    }


    public function crearDireccion($provinciaId, $cantonId, $distritoId, $senas)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_CREAR_DIRECCION_SP(?, ?, ?, ?, @direccionId)");
        $stmt->bind_param("iiis", $provinciaId, $cantonId, $distritoId, $senas);
        $stmt->execute();
        $stmt->close();

        // Obtener el valor devuelto por el OUT
        $result = $this->conn->query("SELECT @direccionId AS direccionId");
        $row = $result->fetch_assoc();

        return $row['direccionId'];
    }


    public function crearTelefono($telefono)
    {
        $stmt = $this->conn->prepare(
            "CALL HUELLITAS_CREAR_TELEFONO_SP(?, @telefonoId)"
        );
        $stmt->bind_param("i", $telefono);
        $stmt->execute();
        $stmt->close();

        // Obtener el ID insertado
        $result = $this->conn->query("SELECT @telefonoId AS telefonoId");
        $row = $result->fetch_assoc();

        return $row['telefonoId'];
    }


    public function correoExistenteEnClientesOUsuarios($correo)
    {

        // Initialize counters to avoid "use of unassigned variable" warnings
        $countClientes = 0;
        $countUsuarios = 0;

        // Buscar en clientes
        $stmt1 = $this->conn->prepare("SELECT COUNT(*) FROM huellitas_clientes_tb WHERE cliente_correo = ?");
        $stmt1->bind_param("s", $correo);
        $stmt1->execute();
        $stmt1->bind_result($countClientes);
        $stmt1->fetch();
        $stmt1->close();

        // Buscar en usuarios
        $stmt2 = $this->conn->prepare("SELECT COUNT(*) FROM huellitas_usuarios_tb WHERE usuario_correo = ?");
        $stmt2->bind_param("s", $correo);
        $stmt2->execute();
        $stmt2->bind_result($countUsuarios);
        $stmt2->fetch();
        $stmt2->close();

        return ($countClientes > 0 || $countUsuarios > 0);
    }

    public function obtenerDetalleCliente($codigo, $tipo)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_DETALLE_CLIENTE_POR_CODIGO_SP(?, ?)");
            $stmt->bind_param("ss", $codigo, $tipo);
            $stmt->execute();

            // Primer resultado: información del cliente o usuario
            $resultCliente = $stmt->get_result();
            $cliente = $resultCliente->fetch_assoc();

            // Segundo resultado: lista de mascotas
            $stmt->next_result();
            $resultMascotas = $stmt->get_result();
            $mascotas = $resultMascotas->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return [
                'cliente' => $cliente,
                'mascotas' => $mascotas
            ];
        } catch (\Throwable $e) {
            error_log("Error en obtenerDetalleCliente: " . $e->getMessage());
            return [
                'cliente' => null,
                'mascotas' => [],
                'error' => '❌ Error interno al obtener los detalles del cliente.'
            ];
        }
    }

    public function obtenerClientePorCodigo($codigo)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_CLIENTE_POR_CODIGO_SP(?)");
            $stmt->bind_param("s", $codigo);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result;
        } catch (\Throwable $e) {
            error_log("Error en obtenerClientePorCodigo: " . $e->getMessage());
            return null;
        }
    }





}
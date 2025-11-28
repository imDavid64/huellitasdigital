<?php
namespace App\Models\Employee;

use App\Models\BaseModel;

class PetModel extends BaseModel
{
    public function agregarMascota(
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
    ) {
        try {
            $sql = "CALL HUELLITAS_AGREGAR_MASCOTA_SP(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new \Exception("Error en prepare: " . $this->conn->error);
            }

            // Sanitizar / castear
            $codigoUsuario = (string) $codigoUsuario;
            $codigoCliente = (string) $codigoCliente;
            $nombre = (string) $nombre;
            $fechaNacimiento = $fechaNacimiento ?: null; // puede ser null
            $genero = (string) $genero;
            $imagenUrl = (string) $imagenUrl;
            $creadoPor = (string) $creadoPor;

            if (
                !$stmt->bind_param(
                    "iiisssssss",
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
                )
            ) {
                throw new \Exception("Error en bind_param: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Error en execute: " . $stmt->error);
            }

            $result = $stmt->get_result();

            $row = $result ? $result->fetch_assoc() : null;

            $stmt->close();

            // Limpiar posibles resultsets extra
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            if (!$row) {
                return [
                    'EXITO' => 0,
                    'MENSAJE' => 'El procedimiento no devolvió resultados.'
                ];
            }

            return [
                'ID_MASCOTA' => $row['ID_MASCOTA'] ?? null,
                'CODIGO_MASCOTA' => $row['CODIGO_MASCOTA'] ?? null,
                'EXITO' => (int) ($row['EXITO'] ?? 0),
                'MENSAJE' => $row['MENSAJE'] ?? ''
            ];

        } catch (\Throwable $e) {
            error_log("Error en agregarMascota: " . $e->getMessage());

            return [
                'EXITO' => 0,
                'MENSAJE' => '❌ Error interno al agregar la mascota. (' . $e->getMessage() . ')'
            ];
        }
    }

    public function editarMascota(
        $codigoMascota,
        $estadoId,
        $especieId,
        $razaId,
        $nombre,
        $fechaNacimiento,
        $genero,
        $imagenUrl,
        $modificadoPor
    ) {
        try {
            $sql = "CALL HUELLITAS_EDITAR_MASCOTA_SP(?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new \Exception("Error en prepare: " . $this->conn->error);
            }

            // Sanitizar / castear
            $codigoMascota = (string) $codigoMascota;
            $nombre = (string) $nombre;
            $fechaNacimiento = $fechaNacimiento ?: null;
            $genero = (string) $genero;
            $imagenUrl = (string) $imagenUrl;
            $modificadoPor = (string) $modificadoPor;

            if (
                !$stmt->bind_param(
                    "siissssss",
                    $codigoMascota,
                    $estadoId,
                    $especieId,
                    $razaId,
                    $nombre,
                    $fechaNacimiento,
                    $genero,
                    $imagenUrl,
                    $modificadoPor
                )
            ) {
                throw new \Exception("Error en bind_param: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new \Exception("Error en execute: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $row = $result ? $result->fetch_assoc() : null;

            $stmt->close();

            // Limpiar resultsets adicionales para evitar errores de "commands out of sync"
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            if (!$row) {
                return [
                    'EXITO' => 0,
                    'MENSAJE' => 'El procedimiento no devolvió resultados.'
                ];
            }

            return [
                'ID_MASCOTA' => $row['ID_MASCOTA'] ?? null,
                'CODIGO_MASCOTA' => $row['CODIGO_MASCOTA'] ?? null,
                'EXITO' => (int) ($row['EXITO'] ?? 0),
                'MENSAJE' => $row['MENSAJE'] ?? ''
            ];

        } catch (\Throwable $e) {
            error_log("Error en editarMascota: " . $e->getMessage());

            return [
                'EXITO' => 0,
                'MENSAJE' => '❌ Error interno al editar la mascota. (' . $e->getMessage() . ')'
            ];
        }
    }


    public function obtenerMascotaPorCodigo($codigoMascota)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_MASCOTA_POR_CODIGO_SP(?)");
            $stmt->bind_param("s", $codigoMascota);
            $stmt->execute();

            $result = $stmt->get_result();
            $mascota = $result->fetch_assoc();

            $stmt->close();

            // Limpieza por si el SP genera más resultsets
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $mascota ?: null;

        } catch (\Throwable $e) {
            error_log("Error en obtenerMascotaPorCodigo: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerHistorialesMedicos($codigoMascota)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_HISTORIALES_MASCOTA_CODIGO_SP(?)");
            $stmt->bind_param("s", $codigoMascota);
            $stmt->execute();

            $result = $stmt->get_result();
            $historiales = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            // Limpieza de posibles resultsets adicionales
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $historiales;

        } catch (\Throwable $e) {
            error_log("Error en obtenerHistorialesMedicos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerEspecies()
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_ESPECIES_SP()");
            $stmt->execute();
            $result = $stmt->get_result();
            $especies = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $especies;

        } catch (\Throwable $e) {
            error_log("Error en obtenerEspecies: " . $e->getMessage());
            return [];
        }
    }


    public function obtenerRazasPorEspecie($idEspecie)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_RAZAS_POR_ESPECIE_SP(?)");
            $stmt->bind_param("i", $idEspecie);
            $stmt->execute();

            $result = $stmt->get_result();
            $razas = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $razas;

        } catch (\Throwable $e) {
            error_log("Error en obtenerRazasPorEspecie: " . $e->getMessage());
            return [];
        }
    }

    public function buscarRazasPorEspecie($idEspecie, $busqueda)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_RAZAS_POR_ESPECIE_SP(?, ?)");
            $stmt->bind_param("is", $idEspecie, $busqueda);
            $stmt->execute();

            $result = $stmt->get_result();
            $razas = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            while ($this->conn->more_results() && $this->conn->next_result()) {
            }

            return $razas;

        } catch (\Throwable $e) {
            error_log("Error en buscarRazasPorEspecie: " . $e->getMessage());
            return [];
        }
    }




}
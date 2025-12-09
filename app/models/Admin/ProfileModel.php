<?php
namespace App\Models\Admin;

use App\Models\BaseModel;
use RuntimeException;

class ProfileModel extends BaseModel
{
    // ==================================================
    // OBTENER USUARIO POR ID
    // ==================================================
    public function getUsuarioById($idUsuario)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_USUARIO_POR_ID_SP(?)");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Limpieza
        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $user;
    }

    // ==================================================
    // ACTUALIZAR PERFIL DE USUARIO
    // ==================================================
    public function updatePerfilUsuario(
        $id_usuario,
        $nombre,
        $identificacion,
        $cuenta_bancaria,
        $imagen_url,
        $id_provincia,
        $id_canton,
        $id_distrito,
        $senas,
        $telefono
    ) {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_PERFIL_USUARIO_SP(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new RuntimeException("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "isissiiisi",
            $id_usuario,
            $nombre,
            $identificacion,
            $cuenta_bancaria,
            $imagen_url,
            $id_provincia,
            $id_canton,
            $id_distrito,
            $senas,
            $telefono
        );

        try {
            $stmt->execute();

            // Drenar posibles resultados (SELECTs dentro del SP)
            do {
                if ($res = $stmt->get_result()) {
                    $res->free();
                }
            } while ($stmt->more_results() && $stmt->next_result());

            $stmt->close();
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }
            return true;

        } catch (\Throwable $e) {
            $stmt->close();
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }
            $_SESSION['error'] = '❌ Error al actualizar el perfil: ' . $e->getMessage();
            return false;
        }
    }

}
?>
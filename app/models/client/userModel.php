<?php
namespace App\Models\Client;

use App\Models\BaseModel;
use RuntimeException;

class UserModel extends BaseModel
{
    // ==================================================
    // VALIDAR LOGIN
    // ==================================================
    public function validarLogin($email, $password)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_VALIDAR_LOGIN_SP(?, ?)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Limpieza total
        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $user;
    }

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

    // ==================================================
    // EMAIL EXISTE
    // ==================================================
    public function emailExiste($email)
    {
        $stmt = $this->conn->prepare("SELECT 1 FROM HUELLITAS_USUARIOS_TB WHERE USUARIO_CORREO = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;

        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $exists;
    }

    // ==================================================
    // REGISTRAR USUARIO
    // ==================================================
    public function registrarUsuario($nombre, $email, $identificacion, $password)
    {
        $sql = "INSERT INTO HUELLITAS_USUARIOS_TB 
            (ID_ESTADO_FK, ID_ROL_USUARIO_FK, USUARIO_NOMBRE, USUARIO_CORREO, USUARIO_CONTRASENNA, USUARIO_IDENTIFICACION)
            VALUES (2, 1, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            $_SESSION['error'] = '❌ Error al preparar la consulta: ' . $this->conn->error;
            return false;
        }

        $stmt->bind_param("sssi", $nombre, $email, $password, $identificacion);

        try {
            $stmt->execute();
            $newId = $this->conn->insert_id;
            $stmt->close();
            return $newId;
        } catch (\Throwable $e) {
            $stmt->close();
            $_SESSION['error'] = '❌ Error al registrar usuario: ' . $e->getMessage();
            return false;
        }
    }

    // ==================================================
    // CREAR TOKEN (usa HUELLITAS_CREAR_TOKEN_SP)
    // ==================================================
    public function crearToken($idUsuario, $tipo, $duracionMin = 1440, $ip = null, $dispositivo = null)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_CREAR_TOKEN_SP(?, ?, ?, ?, ?, @p_token)");
        $stmt->bind_param("isiss", $idUsuario, $tipo, $duracionMin, $ip, $dispositivo);
        $stmt->execute();

        // Recuperar token de salida
        $result = $this->conn->query("SELECT @p_token AS token");
        $token = $result->fetch_assoc()['token'] ?? null;

        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $token;
    }

    // ==================================================
    // MARCAR TOKEN COMO USADO
    // ==================================================
    public function marcarTokenUsado($token)
    {
        $stmt = $this->conn->prepare("UPDATE HUELLITAS_TOKENS_TB SET USADO = TRUE WHERE TOKEN_VALOR = ?");
        $stmt->bind_param("s", $token);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }


    // ==================================================
    // VALIDAR TOKEN (usa HUELLITAS_VALIDAR_TOKEN_SP)
    // ==================================================
    public function validarToken($token, $tipo = 'VERIFICACION')
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_VALIDAR_TOKEN_SP(?, ?)");
        $stmt->bind_param("ss", $token, $tipo);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;

        if ($result)
            $result->free();
        $stmt->close();

        // Limpiar cualquier resultado pendiente
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $row['ID_USUARIO_FK'] ?? null;
    }

    // ==================================================
    // ACTIVAR CUENTA DE USUARIO
    // ==================================================
    public function activarCuenta($idUsuario)
    {
        $sql = "UPDATE HUELLITAS_USUARIOS_TB
            SET ID_ESTADO_FK = 1  -- 1 = Activo
            WHERE ID_USUARIO_PK = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $idUsuario);
        $ok = $stmt->execute();
        $stmt->close();

        // Drenar posibles resultados pendientes (por seguridad)
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $ok;
    }



    // ==================================================
    // IDENTIFICACION EXISTE
    // ==================================================
    public function identificacionExiste($identificacion)
    {
        $stmt = $this->conn->prepare("SELECT 1 FROM HUELLITAS_USUARIOS_TB WHERE USUARIO_IDENTIFICACION=?");
        $stmt->bind_param("i", $identificacion);
        $stmt->execute();

        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;

        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $exists;
    }

    // ==================================================
    // OBTENER USUARIO POR EMAIL
    // ==================================================
    public function getUsuarioByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM HUELLITAS_USUARIOS_TB WHERE USUARIO_CORREO = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $result->free();
        $stmt->close();
        return $row;
    }

    // ==================================================
    // REESTABLECER CONTRASEÑA USANDO TOKEN
    // ==================================================
    public function resetPasswordByToken($token, $newPassword)
    {
        try {
            $stmt = $this->conn->prepare("CALL HUELLITAS_REESTABLECER_CONTRASENNA_SP(?, ?)");
            $stmt->bind_param("ss", $token, $newPassword);
            $stmt->execute();
            $stmt->close();
            while ($this->conn->more_results() && $this->conn->next_result()) {
            }
            return true;
        } catch (\Throwable $e) {
            error_log('❌ Error en resetPasswordByToken: ' . $e->getMessage());
            return false;
        }
    }

}

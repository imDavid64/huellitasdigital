<?php
class UsuarioModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function validarLogin($email, $password)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_VALIDAR_LOGIN_SP(?, ?)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getUsuarioById($idUsuario)
    {
        $sql = "CALL HUELLITAS_GET_USUARIO_BY_ID_SP(?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        $this->conn->next_result();

        return $user;
    }

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
            die("Error en prepare: " . $this->conn->error);
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

        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
}

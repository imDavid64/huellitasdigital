<?php

class SupplierModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Función para obtener todos los proveedores
    public function getAllSuppliers()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PROVEEDORES_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para obtener un proveedor por su ID
    public function getSupplierById($id)
    {
        $query = "
        SELECT 
            P.ID_PROVEEDOR_PK,
            P.NOMBRE_CONTACTO,
            P.PROVEEDOR_NOMBRE,
            P.PROVEEDOR_CORREO,
            P.ID_ESTADO_FK,
            T.TELEFONO_CONTACTO,
            D.DIRECCION_SENNAS
        FROM HUELLITAS_PROVEEDORES_TB P
        LEFT JOIN HUELLITAS_TELEFONO_CONTACTO_TB T 
            ON P.ID_TELEFONO_CONTACTO_FK = T.ID_TELEFONO_CONTACTO_PK
        LEFT JOIN HUELLITAS_DIRECCION_TB D 
            ON P.ID_DIRECCION_FK = D.ID_DIRECCION_PK
        WHERE P.ID_PROVEEDOR_PK = ?
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    // Función para agregar un nuevo proveedor
    public function addSupplier($nombre, $contacto, $correo, $estado, $telefono)
    {
        $sql = "CALL HUELLITAS_AGREGAR_PROVEEDOR_SP(?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("sssii", $nombre, $contacto, $correo, $estado, $telefono);

        return $stmt->execute();
    }

    public function updateSupplier($id, $nombre, $contacto, $correo, $estado, $telefono, $direccion)
    {
        $sql = "CALL HUELLITAS_ACTUALIZAR_PROVEEDOR_SP(?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            return false;
        }

        // id(int), nombre(string), contacto(string), correo(string), estado(int), telefono(int), direccion(string)
        $stmt->bind_param("isssiis", $id, $nombre, $contacto, $correo, $estado, $telefono, $direccion);

        return $stmt->execute();
    }
}

?>
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
            P.NOMBRE_REPRESENTANTE,
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

    public function searchSupplierPaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_PROVEEDORES_ADMIN_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countSuppliers($query)
    {
        $stmt = $this->conn->prepare("
        SELECT COUNT(*) AS total
        FROM HUELLITAS_PROVEEDORES_TB p
        INNER JOIN HUELLITAS_ESTADO_TB e ON p.ID_ESTADO_FK = e.ID_ESTADO_PK
        LEFT JOIN HUELLITAS_DIRECCION_TB d ON p.ID_DIRECCION_FK = d.ID_DIRECCION_PK
        LEFT JOIN HUELLITAS_DIRECCION_PROVINCIA_TB prov ON d.ID_DIRECCION_PROVINCIA_FK = prov.ID_DIRECCION_PROVINCIA_PK
        LEFT JOIN HUELLITAS_DIRECCION_CANTON_TB cant ON d.ID_DIRECCION_CANTON_FK = cant.ID_DIRECCION_CANTON_PK
        LEFT JOIN HUELLITAS_DIRECCION_DISTRITO_TB dist ON d.ID_DIRECCION_DISTRITO_FK = dist.ID_DIRECCION_DISTRITO_PK
        WHERE 
            p.PROVEEDOR_NOMBRE LIKE CONCAT('%', ?, '%')
            OR p.PROVEEDOR_CORREO LIKE CONCAT('%', ?, '%')
            OR p.NOMBRE_REPRESENTANTE LIKE CONCAT('%', ?, '%')
            OR p.PROVEEDOR_DESCRIPCION_PRODUCTOS LIKE CONCAT('%', ?, '%')
            OR e.ESTADO_DESCRIPCION LIKE CONCAT('%', ?, '%')
            OR prov.NOMBRE_PROVINCIA LIKE CONCAT('%', ?, '%')
            OR cant.NOMBRE_CANTON LIKE CONCAT('%', ?, '%')
            OR dist.NOMBRE_DISTRITO LIKE CONCAT('%', ?, '%')
    ");
        $stmt->bind_param("ssssssss", $query, $query, $query, $query, $query, $query, $query, $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }


}

?>
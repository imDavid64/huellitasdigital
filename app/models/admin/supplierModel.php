<?php
namespace App\Models\Admin;

use App\Models\BaseModel;
class SupplierModel extends BaseModel
{
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
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_PROVEEDOR_POR_ID_SP(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Función para obtener todos los proveedores activos
    public function getActiveProviders()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PROVEEDORES_ACTIVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $proveedores = $result->fetch_all(MYSQLI_ASSOC);
        // Limpiar buffers
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $proveedores;
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


    // Contar total de proveedores para paginación
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
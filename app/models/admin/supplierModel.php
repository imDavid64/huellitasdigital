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
        $stmt = $this->conn->prepare("CALL HUELLITAS_CONTAR_PROVEEDORES_SP(?)");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result['total'] ?? 0;
    }

}

?>
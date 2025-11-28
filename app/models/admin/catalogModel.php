<?php
namespace App\Models\Admin;

use App\Models\BaseModel;

class CatalogModel extends BaseModel
{
    public function getAllRoles()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_ROLES_ACTIVOS_SP");
        $stmt->execute();
        $result = $stmt->get_result();
        $roles = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $roles;
    }

    public function getAllOrderStates()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_ESTADOS_PEDIDO_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $estados = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $estados;
    }

    public function getAllPaymentStates()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_ESTADOS_PAGO_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $estados = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $estados;
    }

    public function getAllPaymentProofStates()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_ESTADOS_COMPROBANTE_PAGO_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $estados = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $estados;
    }

    public function getAllStates()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_ESTADOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $estados = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $estados;
    }

    public function getActiveInactiveStates()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_ESTADO_ACTIVO_INACTIVO_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $estados = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $estados;
    }


    public function getActiveProviders()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PROVEEDORES_ACTIVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $proveedores = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $proveedores;
    }

    public function getActiveCategories()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_CATEGORIAS_ACTIVAS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $categorias = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $categorias;
    }

    public function getActiveBrands()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_MARCAS_ACTIVAS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $brands = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $brands;
    }

    public function getAllEsNuevo()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_NUEVO_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->free_result();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $data;
    }


    public function getAllProvincias()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PROVINCIAS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $provincias = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $provincias;
    }

    public function getAllCantones()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_CANTONES_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $cantones = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $cantones;
    }

    public function getAllDistritos()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_DISTRITOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $distritos = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $distritos;
    }

    public function getCantonesByProvincia($idProvincia)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_CANTONES_POR_PROVINCIA_SP(?)");
        $stmt->bind_param("i", $idProvincia);
        $stmt->execute();
        $result = $stmt->get_result();
        $cantones = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }
        return $cantones;
    }

    public function getDistritosByCanton($idCanton)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_DISTRITOS_POR_CANTON_SP(?)");
        $stmt->bind_param("i", $idCanton);
        $stmt->execute();
        $result = $stmt->get_result();
        $distritos = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
        }

        return $distritos;
    }

}
?>
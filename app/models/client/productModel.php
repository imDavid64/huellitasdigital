<?php
namespace App\Models\Client;

use App\Models\BaseModel;

class ProductModel extends BaseModel
{
    //Obtener todos los productos
    public function getAllProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Obtener todos los productos "Activos"
    public function getAllActiveProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_ACTIVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Obtener todos los productos "Activos" y "Nuevos"
    public function getAllNewActiveProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_ACTIVOS_NUEVOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllFoodProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_ALIMENTOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllMedicationsProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_MEDICAMENTOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllAccessoriesProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_ACCESORIOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllActiveCategories()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_CATEGORIAS_ACTIVAS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Metodo o Función para el filtrado de productos
    public function getFilteredProducts($categories = [], $brands = [])
    {
        $categoriaList = !empty($categories) ? implode(",", $categories) : null;
        $marcaList = !empty($brands) ? implode(",", $brands) : null;

        $sql = "CALL HUELLITAS_FILTRAR_PRODUCTOS_SP(?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $categoriaList, $marcaList);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();
        return $data;
    }

    //Metodo o Función para las busquedas de productos
    public function searchActiveProducts($search)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_BUSCADOS_ACTIVOS_SP(?)");
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id_product)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_PRODUCTO_ACTIVO_POR_ID_SP(?)");
        $stmt->bind_param("i", $id_product);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        $stmt->close();
        return $producto;
    }

    public function getCommentsByProductId($id_product)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_COMENTARIOS_ACTIVOS_POR_PRODUCTO_SP(?)");
        $stmt->bind_param("i", $id_product);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addComment($productId, $userId, $comment, $rating)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_AGREGAR_COMENTARIO_SP(?, ?, ?, ?)");
        $stmt->bind_param("iiss", $productId, $userId, $comment, $rating);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateComment($commentId, $userId, $comment, $rating)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ACTUALIZAR_COMENTARIO_SP(?, ?, ?, ?)");
        $stmt->bind_param("iiss", $commentId, $userId, $comment, $rating);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteComment($commentId, $userId)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_ELIMINAR_COMENTARIO_SP(?, ?)");
        $stmt->bind_param("ii", $commentId, $userId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getProductRating($id_product)
    {
        $stmt = $this->conn->prepare("SELECT * FROM huellitas_producto_rating_vw WHERE producto_id = ?");
        $stmt->bind_param("i", $id_product);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
<?php
class ProductModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

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

    public function getAllNewAllActiveCategories()
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
        $sql = "SELECT * FROM HUELLITAS_PRODUCTOS_TB WHERE ID_ESTADO_FK = 1";
        $types = "";
        $params = [];

        // --- Filtro por Categorías ---
        if (!empty($categories)) {
            $placeholders = implode(',', array_fill(0, count($categories), '?'));
            $sql .= " AND ID_CATEGORIA_FK IN ($placeholders)";
            $types .= str_repeat('i', count($categories)); // tipos integer
            $params = array_merge($params, $categories);
        }

        // --- Filtro por Marcas ---
        if (!empty($brands)) {
            $placeholders = implode(',', array_fill(0, count($brands), '?'));
            $sql .= " AND ID_MARCA_FK IN ($placeholders)";
            $types .= str_repeat('i', count($brands));
            $params = array_merge($params, $brands);
        }

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
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

}
?>
<?php
class ProductModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Dentro de la clase ProductModel en productModel.php

    public function updateProduct($id, $id_proveedor, $id_estado, $id_categoria, $id_marca, $id_nuevo, $nombre, $descripcion, $precio, $stock, $imagen_url)
    {
        $query = "CALL HUELLITAS_ACTUALIZAR_PRODUCTO_SP(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("❌ Error en prepare: " . $this->conn->error);
        }

        // Tipos corregidos: 6 enteros, nombre y descripcion strings, precio double, stock int, imagen string
        $stmt->bind_param(
            "iiiiiissdis",
            $id,
            $id_proveedor,
            $id_estado,
            $id_categoria,
            $id_marca,
            $id_nuevo,
            $nombre,
            $descripcion,
            $precio,
            $stock,
            $imagen_url
        );

        $result = $stmt->execute();
        if (!$result) {
            throw new Exception("❌ Error al ejecutar el procedimiento: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }


    public function getProductById($id_producto)
    {
        $stmt = $this->conn->prepare("SELECT * FROM HUELLITAS_PRODUCTOS_TB WHERE ID_PRODUCTO_PK = ?");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        $stmt->close();
        return $producto;
    }

    public function getAllProducts()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_LISTAR_PRODUCTOS_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addProduct($id_proveedor, $id_estado, $id_categoria, $id_marca, $id_nuevo, $nombre, $descripcion, $precio, $stock, $imagen_url)
    {
        $sql = "CALL HUELLITAS_AGREGAR_PRODUCTO_SP(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param(
            "iiiiissdis",
            $id_proveedor,
            $id_estado,
            $id_categoria,
            $id_marca,
            $id_nuevo,
            $nombre,
            $descripcion,
            $precio,
            $stock,
            $imagen_url
        );

        $result = $stmt->execute();

        if (!$result) {
            throw new Exception("Error al ejecutar el procedimiento almacenado: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    public function addCategory($nombreCategoria, $estado)
    {
        $sql = "CALL HUELLITAS_AGREGAR_CATEGORIA_SP(?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("is", $estado, $nombreCategoria);

        $result = $stmt->execute();

        if (!$result) {
            throw new Exception("Error al ejecutar el procedimiento almacenado: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    public function getCategoryById($id_categoria)
    {
        $stmt = $this->conn->prepare("SELECT * FROM HUELLITAS_PRODUCTOS_CATEGORIA_TB WHERE ID_CATEGORIA_PK = ?");
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $categoria = $result->fetch_assoc();
        $stmt->close();
        return $categoria;
    }

    public function updateCategory($id_categoria, $estado, $nombreCategoria)
    {
        $query = "CALL HUELLITAS_ACTUALIZAR_CATEGORIA_SP(?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("❌ Error en prepare: " . $this->conn->error);
        }

        $stmt->bind_param(
            "iis",
            $id_categoria,
            $estado,
            $nombreCategoria
        );

        $result = $stmt->execute();
        if (!$result) {
            throw new Exception("❌ Error al ejecutar el procedimiento: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    function addBrand($nombre, $estado, $imagen_url)
    {
        $sql = "CALL HUELLITAS_AGREGAR_MARCA_SP(?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("sis", $nombre, $estado, $imagen_url);

        $result = $stmt->execute();

        if (!$result) {
            throw new Exception("Error al ejecutar el procedimiento almacenado: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    function getBrandById($id_marca)
    {
        $stmt = $this->conn->prepare("SELECT * FROM HUELLITAS_MARCAS_TB WHERE ID_MARCA_PK = ?");
        $stmt->bind_param("i", $id_marca);
        $stmt->execute();
        $result = $stmt->get_result();
        $marca = $result->fetch_assoc();
        $stmt->close();
        return $marca;
    }

    function updateBrand($id_marca, $nombre, $estado, $imagen_url)
    {
        $query = "CALL HUELLITAS_ACTUALIZAR_MARCA_SP(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("❌ Error en prepare: " . $this->conn->error);
        }

        $stmt->bind_param(
            "isis",
            $id_marca,
            $nombre,
            $estado,
            $imagen_url
        );

        $result = $stmt->execute();
        if (!$result) {
            throw new Exception("❌ Error al ejecutar el procedimiento: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }


    public function searchProducts($query)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_PRODUCTOS_ADMIN_SP(?)");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchCategory($query)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_CATEGORIAS_ADMIN_SP(?)");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // =======================
    // 🔍 BÚSQUEDAS Y PAGINACIÓN
    // =======================
    public function searchProductsPaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_PRODUCTOS_ADMIN_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countProducts($query)
    {
        $stmt = $this->conn->prepare("
        SELECT COUNT(*) AS total 
        FROM HUELLITAS_PRODUCTOS_TB p
        INNER JOIN HUELLITAS_PRODUCTOS_CATEGORIA_TB c ON p.ID_CATEGORIA_FK = c.ID_CATEGORIA_PK
        INNER JOIN HUELLITAS_PROVEEDORES_TB pr ON p.ID_PROVEEDOR_FK = pr.ID_PROVEEDOR_PK
        WHERE 
            p.PRODUCTO_NOMBRE LIKE CONCAT('%', ?, '%')
            OR c.DESCRIPCION_CATEGORIA LIKE CONCAT('%', ?, '%')
            OR pr.PROVEEDOR_NOMBRE LIKE CONCAT('%', ?, '%')
    ");
        $stmt->bind_param("sss", $query, $query, $query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    // =======================
    // 🧩 CATEGORÍAS CON PAGINACIÓN
    // =======================

    public function searchCategoryPaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_CATEGORIAS_ADMIN_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countCategories($query)
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) AS total
            FROM HUELLITAS_PRODUCTOS_CATEGORIA_TB c
            INNER JOIN HUELLITAS_ESTADO_TB e ON c.ID_ESTADO_FK = e.ID_ESTADO_PK
            WHERE c.DESCRIPCION_CATEGORIA LIKE CONCAT('%', ?, '%')
               OR e.ESTADO_DESCRIPCION LIKE CONCAT('%', ?, '%')
        ");
        $stmt->bind_param("ss", $query, $query);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // =======================
    // 🏷️ MARCAS CON PAGINACIÓN
    // =======================

    public function searchBrandPaginated($query, $limit, $offset)
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_BUSCAR_MARCAS_ADMIN_SP(?, ?, ?)");
        $stmt->bind_param("sii", $query, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countBrands($query)
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) AS total
            FROM HUELLITAS_MARCAS_TB m
            INNER JOIN HUELLITAS_ESTADO_TB e ON m.ID_ESTADO_FK = e.ID_ESTADO_PK
            WHERE m.NOMBRE_MARCA LIKE CONCAT('%', ?, '%')
               OR e.ESTADO_DESCRIPCION LIKE CONCAT('%', ?, '%')
        ");
        $stmt->bind_param("ss", $query, $query);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'] ?? 0;
    }


}
?>
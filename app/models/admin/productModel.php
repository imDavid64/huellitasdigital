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

}
?>
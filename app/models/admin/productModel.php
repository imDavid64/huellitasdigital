<?php
class ProductModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Dentro de la clase ProductModel en productModel.php

    public function updateProduct($id, $id_proveedor, $id_estado, $nombre, $descripcion, $categoria, $precio, $stock, $imagen_url)
    {
        $query = "UPDATE HUELLITAS_PRODUCTOS_TB SET
                ID_PROVEEDOR_FK = ?,
                ID_ESTADO_FK = ?,
                PRODUCTO_NOMBRE = ?,
                PRODUCTO_DESCRIPCION = ?,
                CATEGORIA = ?,
                PRODUCTO_PRECIO_UNITARIO = ?,
                PRODUCTO_STOCK = ?,
                IMAGEN_URL = ?
              WHERE ID_PRODUCTO_PK = ?";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("❌ Error en prepare: " . $this->conn->error);
        }

        // Tipos de datos: i (int), i, s (string), s, s, d (double), i, s, i
        $stmt->bind_param("iisssdisi", $id_proveedor, $id_estado, $nombre, $descripcion, $categoria, $precio, $stock, $imagen_url, $id);

        $result = $stmt->execute();
        if (!$result) {
            throw new Exception("❌ Error al ejecutar la actualización: " . $stmt->error);
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

    public function addProduct($id_proveedor, $id_estado, $nombre, $descripcion, $precio, $stock, $imagen_url)
    {
        // ⬇️ SE CORRIGIERON LOS NOMBRES DE LAS COLUMNAS AQUÍ ⬇️
        $sql = "INSERT INTO HUELLITAS_PRODUCTOS_TB
            (ID_PROVEEDOR_FK, ID_ESTADO_FK, PRODUCTO_NOMBRE, PRODUCTO_DESCRIPCION, PRODUCTO_PRECIO_UNITARIO, PRODUCTO_STOCK, IMAGEN_URL)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar consulta: " . $this->conn->error);
        }

        // El bind_param ya era correcto (iissdis), no necesita cambios.
        $stmt->bind_param("iissdis", $id_proveedor, $id_estado, $nombre, $descripcion, $precio, $stock, $imagen_url);

        $result = $stmt->execute();

        // 💡 Consejo: Agrega esta verificación para obtener el error específico de MySQL
        if (!$result) {
            throw new Exception("Error al ejecutar consulta: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }
}
?>
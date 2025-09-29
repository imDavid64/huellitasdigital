<?php
class ProveedorModel {

    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listar(){
        $sql = "SELECT * FROM proveedores ORDER BY id DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $contacto, $telefono, $correo){
        $stmt = $this->pdo->prepare("INSERT INTO proveedores (nombre, contacto, telefono, correo) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $contacto, $telefono, $correo]);
    }

    public function actualizar($id, $nombre, $contacto, $telefono, $correo){
        $stmt = $this->pdo->prepare("UPDATE proveedores SET nombre = ?, contacto = ?, telefono = ?, correo = ? WHERE id = ?");
        return $stmt->execute([$nombre, $contacto, $telefono, $correo, $id]);
    }

    public function cambiarEstado($id, $estado){
        $stmt = $this->pdo->prepare("UPDATE proveedores SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }
}
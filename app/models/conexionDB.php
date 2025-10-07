<?php
class ConexionDatabase {
    private $host = "localhost";
    private $user = "root";
    private $pass = "admin";
    private $dbname = "proyecto";

    public function connectDB() {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Para caracteres especiales
        $conn->set_charset("utf8");

        echo "Se conectó correctamente a la base de datos.<br>";
        return $conn;
    }
}
?>

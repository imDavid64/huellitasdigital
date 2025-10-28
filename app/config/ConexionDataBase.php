<?php
// app/config/conexionDB.php

declare(strict_types=1);

namespace App\Config;

use mysqli;

final class ConexionDatabase
{
    private string $host;
    private string $user;
    private string $pass;
    private string $dbname;

    public function __construct()
    {
        // ✅ Las variables ya están cargadas por bootstrap.php
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->user = $_ENV['DB_USER'] ?? '';
        $this->pass = $_ENV['DB_PASS'] ?? '';
        $this->dbname = $_ENV['DB_NAME'] ?? '';
    }

    public function connectDB(): mysqli
    {
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = @new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($conn->connect_error) {
            error_log("❌ Error de conexión MySQL: " . $conn->connect_error);
            echo "<pre>Host: {$this->host}\nUser: {$this->user}\nDB: {$this->dbname}</pre>";
            http_response_code(500);
            exit("Error al conectar a la base de datos.");
        }

        $conn->set_charset('utf8mb4');
        return $conn;
    }
}

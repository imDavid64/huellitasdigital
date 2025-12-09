<?php
// app/models/BaseModel.php
namespace App\Models;

use App\Config\ConexionDataBase;

class BaseModel
{
    protected $conn;

    public function __construct()
    {
        $db = new ConexionDataBase();
        $this->conn = $db->connectDB();
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->conn->set_charset('utf8mb4');
    }

    public function beginTx()
    {
        $this->conn->begin_transaction();
    }
    public function commit()
    {
        $this->conn->commit();
    }
    public function rollback()
    {
        $this->conn->rollback();
    }
}

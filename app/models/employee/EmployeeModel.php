<?php
namespace App\Models\Employee;

use App\Models\BaseModel;

class EmployeeModel extends BaseModel
{

    public function getAllAppointments()
    {
        $stmt = $this->conn->prepare("CALL HUELLITAS_OBTENER_CITAS_FULL_SP()");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        while ($this->conn->more_results() && $this->conn->next_result()) {
            ;
        }
        return $data;
    }
}
<?php
require_once dirname(__DIR__) . '/classes/Model.php';

class Admin extends Model
{
    public function populateDBHasRan(): bool
    {
        $stmt = $this->db->prepare("
            SELECT populate_script_ran FROM assignment_related
        ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['value'] === '1';
    }

    public function markPopulateDBAsRan(): void
    {
        $stmt = $this->db->prepare("
            UPDATE assignment_related
            SET populate_script_ran = '1'
        ");
        $stmt->execute();
    }
}
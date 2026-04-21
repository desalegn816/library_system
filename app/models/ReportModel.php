<?php
require_once 'BaseModel.php';

class ReportModel extends BaseModel {
    public function __construct() {
        parent::__construct('reports');
    }

    public function getPendingReports() {
        $stmt = $this->pdo->query("SELECT * FROM reports WHERE status = 'pending'");
        return $stmt->fetchAll();
    }
}
?>
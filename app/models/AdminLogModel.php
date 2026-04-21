<?php
require_once 'BaseModel.php';

class AdminLogModel extends BaseModel {
    public function __construct() {
        parent::__construct('admin_logs');
    }

    public function logAction($adminId, $action, $details) {
        $this->insert(['admin_id' => $adminId, 'action' => $action, 'details' => $details]);
    }
}
?>
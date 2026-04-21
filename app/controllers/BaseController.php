<?php
class BaseController {
    protected $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    protected function render($view, $data = []) {
        extract($data);
        ob_start();
        require_once "app/views/$view.php";
        $content = ob_get_clean();
        require_once 'app/views/layout.php';
    }

    protected function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}
?>
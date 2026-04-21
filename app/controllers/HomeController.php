<?php
require_once 'BaseController.php';

class HomeController extends BaseController {
    public function index() {
        if (!isLoggedIn()) {
            $this->redirect('index.php?page=auth');
        }
        $this->render('home/index');
    }
}
?>
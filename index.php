<?php
session_start();
require_once 'app/config/database.php';
require_once 'includes/functions.php';

// Simple router
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'auth':
        require_once 'app/controllers/AuthController.php';
        $controller = new AuthController();
        break;
    case 'profile':
        require_once 'app/controllers/ProfileController.php';
        $controller = new ProfileController();
        break;
    case 'match':
        require_once 'app/controllers/MatchController.php';
        $controller = new MatchController();
        break;
    case 'chat':
        require_once 'app/controllers/ChatController.php';
        $controller = new ChatController();
        break;
    case 'admin':
        require_once 'app/controllers/AdminController.php';
        $controller = new AdminController();
        break;
    default:
        require_once 'app/controllers/HomeController.php';
        $controller = new HomeController();
        break;
}

if (isset($controller) && method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "Page not found";
}
?>
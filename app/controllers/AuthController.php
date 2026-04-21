<?php
require_once 'BaseController.php';
require_once 'app/models/UserModel.php';

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function index() {
        if (isLoggedIn()) {
            $this->redirect('index.php?page=home');
        }
        $this->render('auth/login');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRFToken($_POST['csrf_token'])) {
                $error = 'Invalid request';
                $this->render('auth/login', ['error' => $error]);
                return;
            }
            $email = sanitize($_POST['email']);
            $password = $_POST['password'];
            $remember = isset($_POST['remember']);

            $user = $this->userModel->findByEmail($email);
            if ($user && verifyPassword($password, $user['password_hash']) && $user['is_verified']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $this->userModel->updateLastLogin($user['id']);
                if ($remember) {
                    setcookie('user_id', $user['id'], time() + 3600*24*30, '/', '', true, true);
                }
                $this->redirect('index.php?page=home');
            } else {
                $error = 'Invalid credentials or unverified account';
                $this->render('auth/login', ['error' => $error]);
            }
        } else {
            $this->render('auth/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email']);
            $password = $_POST['password'];

            if (!isValidUniversityEmail($email)) {
                $error = 'Invalid university email';
                $this->render('auth/register', ['error' => $error]);
                return;
            }

            if ($this->userModel->findByEmail($email)) {
                $error = 'Email already exists';
                $this->render('auth/register', ['error' => $error]);
                return;
            }

            $token = generateToken();
            $this->userModel->insert([
                'email' => $email,
                'password_hash' => hashPassword($password),
                'verification_token' => $token
            ]);

            // Send verification email (simulate)
            // mail($email, 'Verify', "Click: index.php?page=auth&action=verify&token=$token");

            $success = 'Registration successful. Check email for verification.';
            $this->render('auth/register', ['success' => $success]);
        } else {
            $this->render('auth/register');
        }
    }

    public function verify() {
        $token = $_GET['token'];
        if ($this->userModel->verifyUser($token)) {
            $success = 'Account verified. You can now login.';
            $this->render('auth/login', ['success' => $success]);
        } else {
            $error = 'Invalid token';
            $this->render('auth/login', ['error' => $error]);
        }
    }

    public function logout() {
        session_destroy();
        setcookie('user_id', '', time() - 3600);
        $this->redirect('index.php?page=auth');
    }
}
?>
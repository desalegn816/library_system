<?php
// Common functions

// Password hashing
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Email validation for university
function isValidUniversityEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && strpos($email, '@wcu.edu.et') !== false;
}

// Generate verification token
function generateToken() {
    return bin2hex(random_bytes(32));
}

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current user
function getCurrentUser() {
    return $_SESSION['user_id'] ?? null;
}

// Redirect
function redirect($url) {
    header("Location: $url");
    exit;
}

// CSRF token
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Basic encryption for messages (simple, not production-grade)
function encryptMessage($message, $key = 'simplekey') {
    return base64_encode(openssl_encrypt($message, 'aes-128-cbc', $key, 0, '1234567890123456'));
}

function decryptMessage($encrypted, $key = 'simplekey') {
    return openssl_decrypt(base64_decode($encrypted), 'aes-128-cbc', $key, 0, '1234567890123456');
}

// Localization
$lang = $_COOKIE['lang'] ?? 'en';
$translations = [
    'en' => [
        'welcome' => 'Welcome',
        'login' => 'Login',
        'register' => 'Register',
        'home' => 'Home',
        'profile' => 'Profile',
        'swipe' => 'Swipe',
        'chat' => 'Chat',
        'admin' => 'Admin',
        'logout' => 'Logout',
        'edit' => 'Edit',
        'save' => 'Save',
        'create' => 'Create',
        'matches' => 'Matches',
        'no_profile' => 'No profile yet',
        'edit_profile' => 'Edit Profile',
        'admin_dashboard' => 'Admin Dashboard',
        'users' => 'Users',
        'reports' => 'Reports'
    ],
    'am' => [
        'welcome' => 'እንኳን ደህና መጡ',
        'login' => 'ግባ',
        'register' => 'ተመዝገብ',
        'home' => 'ቤት',
        'profile' => 'መገለጫ',
        'swipe' => 'ስዋይፕ',
        'chat' => 'ውይይት',
        'admin' => 'አስተያየት',
        'logout' => 'ውጣ',
        'edit' => 'አርትዕ',
        'save' => 'አስቀምጥ',
        'create' => 'ፍጠር',
        'matches' => 'ተያያዦች',
        'no_profile' => 'መገለጫ አልተለመደም',
        'edit_profile' => 'መገለጫ አርትዕ',
        'admin_dashboard' => 'አስተያየት ዳሽቦርድ',
        'users' => 'ተጠቃሚዎች',
        'reports' => 'ሪፖርቶች'
    ]
];

function t($key) {
    global $lang, $translations;
    return $translations[$lang][$key] ?? $key;
}
?>
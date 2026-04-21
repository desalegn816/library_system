<?php
require_once 'BaseModel.php';

class UserModel extends BaseModel {
    public function __construct() {
        parent::__construct('users');
    }

    public function findByEmail($email) {
        return $this->findBy('email', $email);
    }

    public function verifyUser($token) {
        $stmt = $this->pdo->prepare("UPDATE users SET is_verified = TRUE, verification_token = NULL WHERE verification_token = ?");
        return $stmt->execute([$token]);
    }

    public function updateLastLogin($id) {
        $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
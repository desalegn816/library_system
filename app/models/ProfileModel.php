<?php
require_once 'BaseModel.php';

class ProfileModel extends BaseModel {
    public function __construct() {
        parent::__construct('profiles');
    }

    public function findByUserId($userId) {
        return $this->findBy('user_id', $userId);
    }

    public function updateProfile($userId, $data) {
        $stmt = $this->pdo->prepare("UPDATE profiles SET name=?, age=?, gender=?, department=?, interests=?, profile_image=?, visibility=? WHERE user_id=?");
        $stmt->execute([$data['name'], $data['age'], $data['gender'], $data['department'], json_encode($data['interests']), $data['profile_image'], $data['visibility'], $userId]);
    }

    public function calculateCompletion($userId) {
        $profile = $this->findByUserId($userId);
        $fields = ['name', 'age', 'gender', 'department', 'interests', 'profile_image'];
        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($profile[$field])) $completed++;
        }
        $percentage = ($completed / count($fields)) * 100;
        $stmt = $this->pdo->prepare("UPDATE profiles SET completion_percentage = ? WHERE user_id = ?");
        $stmt->execute([$percentage, $userId]);
        return $percentage;
    }
}
?>
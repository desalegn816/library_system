<?php
require_once 'BaseModel.php';

class MatchModel extends BaseModel {
    public function __construct() {
        parent::__construct('likes');
    }

    public function addLike($from, $to, $type) {
        // Check if already exists
        $stmt = $this->pdo->prepare("SELECT id FROM likes WHERE from_user_id = ? AND to_user_id = ?");
        $stmt->execute([$from, $to]);
        if ($stmt->fetch()) {
            // Update
            $stmt = $this->pdo->prepare("UPDATE likes SET type = ? WHERE from_user_id = ? AND to_user_id = ?");
            $stmt->execute([$type, $from, $to]);
        } else {
            $this->insert(['from_user_id' => $from, 'to_user_id' => $to, 'type' => $type]);
        }
        $this->checkMatch($from, $to);
    }

    private function checkMatch($user1, $user2) {
        // Check mutual like
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM likes WHERE ((from_user_id = ? AND to_user_id = ? AND type = 'like') OR (from_user_id = ? AND to_user_id = ? AND type = 'like'))");
        $stmt->execute([$user1, $user2, $user2, $user1]);
        if ($stmt->fetch()['count'] == 2) {
            // Mutual match
            $score = $this->calculateMatchScore($user1, $user2);
            $stmt = $this->pdo->prepare("INSERT INTO matches (user1_id, user2_id, match_score) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE match_score = ?");
            $stmt->execute([min($user1, $user2), max($user1, $user2), $score, $score]);
        }
    }

    private function calculateMatchScore($user1, $user2) {
        // Simple score based on interests and department
        $profileModel = new ProfileModel();
        $p1 = $profileModel->findByUserId($user1);
        $p2 = $profileModel->findByUserId($user2);
        $score = 0;
        if ($p1['department'] == $p2['department']) $score += 20;
        $interests1 = json_decode($p1['interests'] ?? '[]', true);
        $interests2 = json_decode($p2['interests'] ?? '[]', true);
        $common = array_intersect($interests1, $interests2);
        $score += count($common) * 10;
        // Age difference
        $ageDiff = abs($p1['age'] - $p2['age']);
        if ($ageDiff <= 2) $score += 30;
        elseif ($ageDiff <= 5) $score += 20;
        return min($score, 100);
    }

    public function getPotentialMatches($userId) {
        // Get users not liked/disliked yet
        $stmt = $this->pdo->prepare("SELECT u.id, p.* FROM users u JOIN profiles p ON u.id = p.user_id WHERE u.id != ? AND u.is_verified = 1 AND u.id NOT IN (SELECT to_user_id FROM likes WHERE from_user_id = ?)");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll();
    }

    public function getMatches($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM matches WHERE user1_id = ? OR user2_id = ?");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll();
    }
}
?>
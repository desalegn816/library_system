<?php
require_once 'BaseModel.php';

class MessageModel extends BaseModel {
    public function __construct() {
        parent::__construct('messages');
    }

    public function getConversation($user1, $user2) {
        $stmt = $this->pdo->prepare("SELECT id, from_user_id, message, timestamp, is_read FROM messages WHERE (from_user_id = ? AND to_user_id = ?) OR (from_user_id = ? AND to_user_id = ?) ORDER BY timestamp ASC");
        $stmt->execute([$user1, $user2, $user2, $user1]);
        return $stmt->fetchAll();
    }

    public function sendMessage($from, $to, $message) {
        $this->insert(['from_user_id' => $from, 'to_user_id' => $to, 'message' => $message]);
    }

    public function markAsRead($messageId) {
        $stmt = $this->pdo->prepare("UPDATE messages SET is_read = TRUE WHERE id = ?");
        $stmt->execute([$messageId]);
    }

    public function getUnreadCount($userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM messages WHERE to_user_id = ? AND is_read = FALSE");
        $stmt->execute([$userId]);
        return $stmt->fetch()['count'];
    }
}
?>
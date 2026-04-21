<div class="chat-container">
    <h2><?php echo t('chat'); ?></h2>
    <div class="chat-list">
        <?php foreach ($matches as $match): ?>
            <div class="chat-item" onclick="openChat(<?php echo $match['user1_id'] == getCurrentUser() ? $match['user2_id'] : $match['user1_id']; ?>)">
                User <?php echo $match['user1_id'] == getCurrentUser() ? $match['user2_id'] : $match['user1_id']; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="chat-window" style="display:none;">
        <div id="messages"></div>
        <input type="text" id="message-input" placeholder="Type message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>
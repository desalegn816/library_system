<div class="matches-container">
    <h2><?php echo t('matches'); ?></h2>
    <div class="matches-grid">
        <?php foreach ($matches as $match): ?>
            <div class="match-card-3d">
                <h3>Match with User <?php echo $match['user1_id'] == getCurrentUser() ? $match['user2_id'] : $match['user1_id']; ?></h3>
                <p>Score: <?php echo $match['match_score']; ?>%</p>
                <a href="index.php?page=chat&with=<?php echo $match['user1_id'] == getCurrentUser() ? $match['user2_id'] : $match['user1_id']; ?>" class="btn-3d">Chat</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="swipe-container">
    <h2><?php echo t('swipe'); ?></h2>
    <div id="swipe-cards">
        <?php foreach ($potentials as $user): ?>
            <div class="card-3d swipe-card" data-user="<?php echo $user['user_id']; ?>">
                <img src="public/images/<?php echo $user['profile_image'] ?: 'default.png'; ?>" alt="Profile">
                <h3><?php echo $user['name']; ?></h3>
                <p><?php echo $user['age']; ?>, <?php echo $user['department']; ?></p>
                <div class="actions">
                    <button class="dislike-btn" onclick="likeUser(<?php echo $user['user_id']; ?>, 'dislike')">❌</button>
                    <button class="like-btn" onclick="likeUser(<?php echo $user['user_id']; ?>, 'like')">❤️</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
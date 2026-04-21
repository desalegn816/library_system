<div class="profile-container">
    <h2><?php echo t('profile'); ?></h2>
    <?php if ($profile): ?>
        <div class="profile-card-3d">
            <img src="public/images/<?php echo $profile['profile_image'] ?: 'default.png'; ?>" alt="Profile">
            <h3><?php echo $profile['name']; ?></h3>
            <p>Age: <?php echo $profile['age']; ?></p>
            <p>Department: <?php echo $profile['department']; ?></p>
            <p>Completion: <?php echo $profile['completion_percentage']; ?>%</p>
        </div>
        <a href="index.php?page=profile&action=edit" class="btn-3d"><?php echo t('edit'); ?></a>
    <?php else: ?>
        <p><?php echo t('no_profile'); ?></p>
        <a href="index.php?page=profile&action=edit" class="btn-3d"><?php echo t('create'); ?></a>
    <?php endif; ?>
</div>
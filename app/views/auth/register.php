<div class="auth-container">
    <h2><?php echo t('register'); ?></h2>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    <form action="index.php?page=auth&action=register" method="post" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
        <input type="email" name="email" placeholder="University Email (@wcu.edu.et)" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-3d"><?php echo t('register'); ?></button>
    </form>
    <p><a href="index.php?page=auth"><?php echo t('login'); ?></a></p>
</div>
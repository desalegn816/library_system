<div class="auth-container">
    <h2><?php echo t('login'); ?></h2>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    <form action="index.php?page=auth&action=login" method="post" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
        <input type="email" name="email" placeholder="University Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label><input type="checkbox" name="remember"> Remember me</label>
        <button type="submit" class="btn-3d"><?php echo t('login'); ?></button>
    </form>
    <p><a href="index.php?page=auth&action=register"><?php echo t('register'); ?></a></p>
</div>
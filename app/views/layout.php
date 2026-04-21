<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachemo Dating</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php?page=home"><?php echo t('home'); ?></a>
            <a href="index.php?page=profile"><?php echo t('profile'); ?></a>
            <a href="index.php?page=match&action=swipe"><?php echo t('swipe'); ?></a>
            <a href="index.php?page=chat"><?php echo t('chat'); ?></a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="index.php?page=admin"><?php echo t('admin'); ?></a>
            <?php endif; ?>
            <a href="index.php?page=auth&action=logout"><?php echo t('logout'); ?></a>
            <select onchange="switchLang(this.value)">
                <option value="en" <?php echo $lang == 'en' ? 'selected' : ''; ?>>English</option>
                <option value="am" <?php echo $lang == 'am' ? 'selected' : ''; ?>>አማርኛ</option>
            </select>
        </nav>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <script src="public/js/app.js"></script>
</body>
</html>
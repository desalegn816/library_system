<div class="admin-container">
    <h2><?php echo t('admin_dashboard'); ?></h2>
    <h3><?php echo t('users'); ?></h3>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo $user['email']; ?> <button onclick="banUser(<?php echo $user['id']; ?>)">Ban</button></li>
        <?php endforeach; ?>
    </ul>
    <h3><?php echo t('reports'); ?></h3>
    <ul>
        <?php foreach ($reports as $report): ?>
            <li><?php echo $report['reason']; ?> <button onclick="resolveReport(<?php echo $report['id']; ?>)">Resolve</button></li>
        <?php endforeach; ?>
    </ul>
</div>
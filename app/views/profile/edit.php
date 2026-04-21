<div class="profile-edit-container">
    <h2><?php echo t('edit_profile'); ?></h2>
    <form action="index.php?page=profile&action=edit" method="post" enctype="multipart/form-data" class="profile-form">
        <input type="text" name="name" value="<?php echo $profile['name'] ?? ''; ?>" placeholder="Name" required>
        <input type="number" name="age" value="<?php echo $profile['age'] ?? ''; ?>" placeholder="Age" min="18" max="30" required>
        <select name="gender" required>
            <option value="male" <?php echo ($profile['gender'] ?? '') == 'male' ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($profile['gender'] ?? '') == 'female' ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?php echo ($profile['gender'] ?? '') == 'other' ? 'selected' : ''; ?>>Other</option>
        </select>
        <input type="text" name="department" value="<?php echo $profile['department'] ?? ''; ?>" placeholder="Department" required>
        <input type="text" name="interests" value="<?php echo implode(',', json_decode($profile['interests'] ?? '[]', true)); ?>" placeholder="Interests (comma separated)">
        <input type="file" name="profile_image" accept="image/*">
        <select name="visibility">
            <option value="public" <?php echo ($profile['visibility'] ?? 'public') == 'public' ? 'selected' : ''; ?>>Public</option>
            <option value="private" <?php echo ($profile['visibility'] ?? '') == 'private' ? 'selected' : ''; ?>>Private</option>
        </select>
        <button type="submit" class="btn-3d"><?php echo t('save'); ?></button>
    </form>
</div>
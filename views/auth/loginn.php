<?php ob_start(); ?>
<h2>Blog Posts</h2>
<ul>
    <?php foreach ($blogs as $blog): ?>
        <li>
            <a href="/blogs/<?= $blog['id'] ?>"><?= htmlspecialchars($blog['title']) ?></a>
        </li>
    <?php endforeach; ?>
</ul>
<a href="/blogs/create">Create New Blog</a>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/app.php'; ?>

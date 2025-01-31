<?php if ($flashMessage['message']): ?>
    <div class="p-2 rounded mb-2 <?= $flashMessage['type'] == 'success' ? 'bg-success' : 'bg-danger' ?> text-white"><?= $flashMessage['message'] ?></div>
<?php endif; ?>
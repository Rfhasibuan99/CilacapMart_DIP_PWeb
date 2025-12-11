<?= $this->extend('layout/admin_template'); ?>
<?= $this->section('content'); ?>
<h2 class="fw-bold mb-4">Inbox Live Chat</h2>

<?php foreach ($chats as $chat): ?>
    <?php 
        $unreadClass = $chat['unread'] ? 'bg-warning-light border-start border-warning border-5' : 'bg-white';
        $link = base_url('admin/chat/view/' . $chat['user_id']); // Link ke halaman chat spesifik
    ?>
    <a href="<?= $link; ?>" class="text-decoration-none text-dark">
        <div class="card p-3 mb-3 d-flex flex-row gap-3 align-items-center <?= $unreadClass; ?>">
            <img src="https://i.pravatar.cc/80?u=<?= $chat['user_id']; ?>" class="avatar" alt="">
            <div class="flex-grow-1">
                <div class="fw-bold fs-5 d-flex justify-content-between">
                    <span><?= esc($chat['user_name']); ?></span>
                    <small class="text-muted"><?= date('H:i', $chat['timestamp'] / 1000); ?></small>
                </div>
                <p class="mb-0 text-muted">
                    <?= esc(substr($chat['last_message'], 0, 70)); ?>...
                </p>
            </div>
        </div>
    </a>
<?php endforeach; ?>

<?php if (empty($chats)): ?>
    <div class="alert alert-info text-center">Belum ada percakapan chat yang masuk.</div>
<?php endif; ?>

<?= $this->endSection(); ?>
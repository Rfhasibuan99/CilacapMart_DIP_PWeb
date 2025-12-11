<?= $this->extend('layout/home'); ?>
<?= $this->section('content'); ?>
<div class="container py-4">

    <div class="mb-3 back-text" onclick="history.back()">
        ← Kembali
    </div>

    <h2 class="fw-bold mb-4">Pesan Masuk (Ganti Nama Jadi Chat)</h2>
    
    <?php
        $chats = [
            ['user_id' => 'user_1234', 'user_name' => 'Fulan Ahadi', 'last_message' => 'Barang saya kenapa belum dikirim?'],
            ['user_id' => 'user_5678', 'user_name' => 'Budi Santoso', 'last_message' => 'Apakah produk ini masih tersedia?'],
        ];
    ?>

    <?php foreach ($chats as $chat): ?>
    <div class="notif-card p-3 mb-3 d-flex gap-3 align-items-start">
       <a href="<?= base_url('chat') . '?id=' . $chat['user_id']; ?>" class="text-decoration-none w-100 d-flex gap-3">
             <img src="https://i.pravatar.cc/80" class="avatar" alt="">
             <div class="flex-grow-1">
                 <div class="notif-title"><?= $chat['user_name']; ?></div>
                 <p class="notif-text mb-0 text-dark text-truncate">
                     <?= $chat['last_message']; ?>
                 </p>
             </div>
        </a>
    </div>
    <?php endforeach; ?>

</div>
<?= $this->endSection(); ?>
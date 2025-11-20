<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
    <style>
        .notif-card {
            background: #E0F2FE;
            border-radius: 15px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .notif-title {
            color: #0096C7;
            font-weight: bold;
            font-size: 18px;
        }
        .notif-text {
            font-size: 15px;
            color: #333;
        }
        .back-text {
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
<div class="container py-4">

    <!-- Tombol Kembali -->
    <div class="mb-3 back-text" onclick="history.back()">
        ← Kembali
    </div>

    <h2 class="fw-bold mb-4">Notifikasi</h2>

    <!-- NOTIFIKASI 1 -->
    <div class="notif-card p-3 mb-3 d-flex gap-3 align-items-start">
        <img src="https://i.pravatar.cc/80" class="avatar" alt="">
        <div>
            <div class="notif-title"><a href= "/chat">Nama Toko</a></div>
            <p class="notif-text mb-0">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
        </div>
    </div>

    <!-- NOTIFIKASI 2 -->
    <div class="notif-card p-3 mb-3 d-flex gap-3 align-items-start">
        <img src="https://i.pravatar.cc/80" class="avatar" alt="">
        <div>
            <div class="notif-title"><a href= "/chat">Nama Toko</a></div>
            <p class="notif-text mb-0">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
        </div>
    </div>

    <!-- NOTIFIKASI 3 -->
    <div class="notif-card p-3 mb-3 d-flex gap-3 align-items-start">
        <img src="https://i.pravatar.cc/80" class="avatar" alt="">
        <div>
            <div class="notif-title"><a href= "/chat">Nama Toko</a></div>
            <p class="notif-text mb-0">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
        </div>
    </div>

    <!-- NOTIFIKASI 4 -->
    <div class="notif-card p-3 mb-3 d-flex gap-3 align-items-start">
        <img src="https://i.pravatar.cc/80" class="avatar" alt="">
        <div>
            <div class="notif-title"><a href= "/chat">Nama Toko</a></div>
            <p class="notif-text mb-0">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>
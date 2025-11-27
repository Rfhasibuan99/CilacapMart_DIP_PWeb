<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
/* ====== GLOBAL ======= */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #E0F2FE;
}

/* ====== NAVBAR ======= */
.main-nav {
    background-color: #0096C7 !important;
}

.input-group .btn {
    background-color: #0096C7;
    color: white;
}

/* ====== WRAPPER ======= */
.main-wrapper {
    display: flex;
    padding: 30px;
    gap: 30px;
}

/* ====== SIDEBAR ======= */
.sidebar {
    width: 250px;
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.profile i {
    font-size: 45px;
    color: #0096C7;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 12px 5px;
    border-radius: 10px;
}

.menu-item i {
    margin-right: 12px;
    font-size: 23px;
    color: #0096C7;
}

/* ====== CONTENT ======= */
.content {
    flex: 1;
    background: #E0F2FE;
    border-radius: 20px;
    padding: 20px;
    min-height: 520px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
/* Menu Item */
.menu-item {
    display: flex;
    align-items: center;
    font-size: 17px;
    padding: 12px 5px;
    border-radius: 12px;
    transition: 0.2s;
}

.menu-item a {
    color: #003049;
    text-decoration: none;
}

.menu-item i {
    margin-right: 12px;
    font-size: 23px;
    color: #0096C7;
}

/* Hover efek */
.menu-item:hover {
    background: #E0F2FE;
    transform: translateX(6px);
}
footer {
    background-color: #003366; /* BIRU TUA */
    padding: 25px 50px;
    color: #ffffff; /* TEKS PUTIH */
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

footer h6 {
    font-weight: 700;
    margin-bottom: 8px;
    color: #ffffff;
}

footer a {
    color: #ffffff;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}
</style>


<div class="main-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="profile">
                <img src="https://i.pravatar.cc/80" class="avatar" alt="">
            <div>
                <b><?= $user->username ?? 'Username'; ?></b><br>
                <a style="font-size: 13px; cursor:pointer;" href="/akun/ubah">Ubah Profil</a>
            </div>
        </div>

        <div class="menu">
            <div class="menu-item"><a href="/akun"><i class="bi bi-person"></i> Akun Saya</a></div>
            <div class="menu-item"><a href="/pesanan"><i class="bi bi-bag"></i> Pesanan Saya</a></div>
            <div class="menu-item"><a href="/notifikasi"><i class="bi bi-bell"></i> Notifikasi</a></div>
            <div class="menu-item"><a href="/"><i class="bi bi-coin" style="color:#f5c400;"></i> Point Saya</a></div>
            <div class="menu-item">
                <a href="/logout">
                    <i class="bi bi-box-arrow-right" style="color:red;"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">
        <h3><b>Akun Saya</b></h3>
        <br>

        <?php if ($user): ?>
        <div style="max-width:800px;">
            <div style="display:flex; gap:20px; align-items:flex-start;">
                
                <!-- Icon -->
                <div style="flex:0 0 120px; text-align:center;">
                    <img src="https://i.pravatar.cc/80" class="avatar" alt="">
                </div>

                <!-- Data User -->
                <div style="flex:1;">
                    <table style="width:100%; font-size:16px; border-collapse:collapse;">
                        <tr>
                            <th style="width:160px;">Nama Pengguna</th>
                            <td>: <?= esc($user->username) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: <?= esc($user->email) ?></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>: <?= esc($user->role) ?></td>
                        </tr>
                        <tr>
                            <th>Terdaftar</th>
                            <td>: <?= $user->created_at ? date('d/m/Y', strtotime($user->created_at)) : '-' ?></td>
                        </tr>
                    </table>

                    <div style="margin-top:18px;">
                        <a href="/akun/ubah" style="font-size:13px;">Ubah Profil</a>
                        <a href="/forgot" class="btn-detail" style="background:#6c757d;">Ubah Password</a>
                    </div>
                </div>

            </div>
        </div>

        <?php else: ?>
            <p>Tidak ada data user ditemukan.</p>
        <?php endif; ?>
    </div>

</div>
<footer>
        <div>
            <h6>Layanan Pelanggan</h6>
            Bantuan<br>Lacak Pengiriman Penjual<br>Lacak Pesanan Pembeli<br>Hubungi Kami
        </div>
        <div>
            <h6>Jelajahi Cilacap Mart</h6>
            Tentang Kami<br>Seller Centre<br>Kontak Media
        </div>
        <div><h6>Pembayaran</h6></div>
        <div><h6>Pengiriman</h6></div>
    </footer>
<?= $this->endSection(); ?>

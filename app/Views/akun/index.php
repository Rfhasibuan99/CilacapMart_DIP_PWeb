<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #E8EFF7;
    }


    .main-nav {
        background-color: #003366 !important;
    }

    .input-group .btn {
        background-color: #003366;
        color: white;
    }

    .main-wrapper {
        display: flex;
        padding: 30px;
        gap: 30px;
    }


    .sidebar {
        width: 250px;
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
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

    .content {
        flex: 1;

        padding: 0;

        background: transparent;
        border-radius: 20px;
        min-height: 520px;
        overflow: hidden;
    }

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

    .menu-item:hover {
        background: #E0F2FE;
        transform: translateX(6px);
    }

    .profile-header {
        background-color: #0d47a1;
        color: white;
        padding: 20px;
        padding-top: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        padding-bottom: 60px;
    }

    .profile-header .top-bar {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        font-size: 20px;
    }

    .profile-header img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #BBDEFB;
        margin-bottom: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .profile-details-card {
        background-color: white;
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
        padding: 20px;
        margin-top: -40px;
        position: relative;
        box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.1);
    }

    .detail-field {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 10px;
        border-radius: 10px;
        margin-bottom: 15px;
        background-color: #f7f7f7;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: background-color 0.2s;
    }

    .detail-field:hover {
        background-color: #eeeeee;
    }

    .detail-field .label {
        font-weight: 500;
        color: #757575;
        flex-basis: 35%;
    }

    .detail-field .value {
        font-weight: 600;
        color: #212121;
        text-align: right;
        flex-basis: 65%;
    }

    .btn-edit {
        display: block;
        margin-top: 20px;
        text-align: center;
        text-decoration: none;
        background-color: #0096C7;
        color: white;
        padding: 10px;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .btn-edit:hover {
        background-color: #007aa1;
    }
</style>

<div class="main-wrapper">
    <div class="sidebar">
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <div>
                <b><?= esc($user['nama_pengguna'] ?? 'Nama Pengguna') ?></b><br>
                <a style="font-size: 13px; cursor:pointer;" href="/akun/ubah">Ubah Foto Profil</a>
            </div>
        </div>

        <div class="menu">
            <div class="menu-item"><a href="/akun"><i class="bi bi-person"></i> Akun Saya</a></div>
            <div class="menu-item"><a href="/pesanan"><i class="bi bi-bag"></i> Pesanan Saya</a></div>
            <div class="menu-item"><a href="/chat"><i class="bi bi-bell"></i> Notifikasi</a></div>
            <div class="menu-item"><a href="/keranjang"><i class="bi bi-cart" style="color:#f5c400;"></i> Keranjang Saya</a></div>
            <div class="menu-item">
                <a href="/logout">
                    <i class="bi bi-box-arrow-right" style="color:red;"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <?php if ($user): ?>
            <div class="profile-header">
                <div class="top-bar">
                    <a href="/" style="color:white;"><i class="bi bi-arrow-left"></i></a>
                    <span>Profil</span>
                    <span></span>
                </div>

                <img src="<?= base_url('img/' . ($user['gambar'] ?? 'default-profile.jpg')) ?>"
                    alt="Foto Profil"
                    onerror="this.onerror=null;this.src='https://via.placeholder.com/100x100/BBDEFB/0d47a1?text=U'">

                <h4><?= esc($user['nama_pengguna'] ?? 'Aurelia af') ?></h4>
            </div>

            <div class="profile-details-card">
                <div class="detail-field">
                    <span class="label">Nama</span>
                    <span class="value"><?= esc($user['nama_pengguna'] ?? '-') ?></span>
                </div>

                <div class="detail-field">
                    <span class="label">Email</span>
                    <span class="value"><?= esc($user['email'] ?? '-') ?></span>
                </div>

                <div class="detail-field">
                    <span class="label">No. Telp</span>
                    <span class="value"><?= esc($user['no_tlp'] ?? '-') ?></span>
                </div>

                <div class="detail-field">
                    <span class="label">Tanggal Lahir</span>
                    <span class="value"><?= esc($user['tgl_lahir'] ? date('d/m/Y', strtotime($user['tgl_lahir'])) : '-') ?></span>
                </div>

                <div class="detail-field">
                    <span class="label">Alamat</span>
                    <span class="value"><?= esc($user['alamat'] ?? '-') ?></span>
                </div>

                <a href="/akun/ubah" class="btn-edit">Ubah Profil</a>
            </div>
        <?php else: ?>
            <p style="padding:20px;">Tidak ada data user ditemukan.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>

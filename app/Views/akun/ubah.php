<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #E0F2FE;
    }

    .main-nav {
        background-color: #003366 !important;
    }

    .navbar-brand span {
        color: white !important;
        font-weight: 600;
    }

    .main-nav i {
        color: white !important;
    }

    .input-group .form-control {
        border-color: #0096C7;
    }

    .input-group .btn {
        background-color: #0096C7;
        color: white;
        border-color: #0096C7;
    }

    .input-group .btn:hover {
        background-color: #007aa1;
    }

    .main-wrapper {
        display: flex;
        padding: 30px;
        gap: 30px;
    }

    .sidebar {
        width: 250px;
        background: #ffffff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .profile i {
        font-size: 45px;
        color: #0096C7;
    }

    .profile a {
        color: #007aa1;
        text-decoration: underline;
    }

    .menu-item {
        display: flex;
        align-items: center;
        font-size: 17px;
        padding: 12px 5px;
        border-radius: 10px;
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
        transform: translateX(5px);
    }

    .yellow-icon {
        color: #f5c400 !important;
    }

    .logout-icon {
        color: red;
    }

    .content {
        flex: 1;
        background: #E0F2FE;
        border-radius: 20px;
        min-height: 520px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container {
        background: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #003049;
    }

    .form-group input[type="text"],
    .form-group input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .btn-primary {
        background-color: #0096C7;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #007aa1;
    }
</style>

<div class="main-wrapper">

    <div class="sidebar">
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <div>
                <b><?= esc($user['nama_pengguna']) ?></b><br>
                <a style="font-size: 13px; color: gray; cursor:pointer;" href="/akun/ubah">Ubah Profil</a>
            </div>
        </div>

        <div class="menu">
            <div class="menu-item"><a href="/akun"><i class="bi bi-person"></i> Akun Saya</a></div>
            <div class="menu-item"><a href="/pesanan"><i class="bi bi-bag"></i> Pesanan Saya</a></div>
            <div class="menu-item"><a href="/notifikasi"><i class="bi bi-bell"></i> Notifikasi</a></div>
            <div class="menu-item"><a href="/"><i class="bi bi-coin yellow-icon"></i> Point Saya</a></div>
            <div class="menu-item">
                <a href="/logout" style="text-decoration:none; color:inherit;">
                    <i class="bi bi-box-arrow-right logout-icon"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <h3><b>Ubah Profil</b></h3>
        <br>

        <div class="form-container">
            <form action="/akun/update" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="nama_pengguna">Nama Lengkap</label>
                    <input type="text" id="nama_pengguna" name="nama_pengguna" value="<?= esc($user['nama_pengguna']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="<?= esc($user['alamat']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="no_tlp">Nomor Telepon</label>
                    <input type="text" id="no_tlp" name="no_tlp" value="<?= esc($user['no_tlp']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <input type="text" id="jenis_kelamin" name="jenis_kelamin" value="<?= esc($user['jenis_kelamin']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="text" id="tgl_lahir" name="tgl_lahir" value="<?= esc($user['tgl_lahir']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Foto Profil</label>
                    <input type="file" name="gambar">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>

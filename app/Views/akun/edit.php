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

/* ====== LAYOUT WRAPPER ======= */
.main-wrapper {
    display: flex;
    padding: 30px;
    gap: 30px;
}

/* ====== SIDEBAR ======= */
.sidebar {
    width: 250px;
    background: #ffffff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
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

/* ====== MAIN CONTENT ======= */
.content {
    flex: 1;
    background: #E0F2FE;
    border-radius: 20px;
    min-height: 520px;
    padding: 20px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.form-container {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top main-nav">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="../../../../logo.png" alt="Cilacap Mart Logo" class="me-2" width="100px">
            <span>Cilacap Mart</span>
        </a>

        <form action="<?= site_url('/rio'); ?>" method="get" class="d-flex">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Masukkan Pencarian Barang" name="cari">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <?php if (session()->getFlashdata('pesan')): ?>
            <div class="alert alert-success ms-3 mb-0" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>

        <div class="d-flex align-items-center gap-3">
            <a href="/"><i class="bi bi-bag"></i></a>
            <a href="/keranjang"><i class="bi bi-cart fs-4"></i></a>
            <a href="/akun"><i class="bi bi-person-circle fs-4"></i></a>
        </div>
    </div>
</nav>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <div>
                <b><?= session()->get('username') ?? 'Username'; ?></b><br>
                <a style="font-size: 13px; color: gray; cursor:pointer;" href="/akun/edit">Ubah Profil</a>
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

    <!-- MAIN CONTENT AREA -->
    <div class="content">
        <h3><b>Ubah Profil</b></h3>
        <br>

        <div class="form-container">
            <form action="/akun/update" method="post">
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <input type="text" id="username" name="username" value="<?= session()->get('username') ?? ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= session()->get('email') ?? ''; ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>

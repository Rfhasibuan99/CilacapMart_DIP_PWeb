<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
/* ====== GLOBAL ======= */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #E0F2FE; /* Biru muda lembut */
}

/* ====== NAVBAR ======= */
.main-nav {
    background-color: #0096C7 !important; /* Biru utama */
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

/* ====== LAYOUT ======= */
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
    border-radius: 18px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.10);
}

/* Profile */
.profile i {
    font-size: 45px;
    color: #0096C7;
}

.profile a {
    color: #007aa1;
    text-decoration: underline;
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

/* Point Icon */
.yellow-icon {
    color: #f5c400 !important;
}

/* Logout Icon */
.logout-icon {
    color: red !important;
}

/* ====== MAIN CONTENT ======= */
.content {
    flex: 1;
    background: #E0F2FE;
    border-radius: 20px;
    padding: 20px;
    min-height: 520px;
}

/* BOX WRAPPER TABEL */
.pesanan-table {
    width: 100%;
    background: white;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
}

/* TABLE */
.pesanan-table table {
    width: 100%;
    font-size: 16px;
}

.pesanan-table th {
    background: #0096C7;
    color: white;
    padding: 12px;
    border-radius: 8px;
}

.pesanan-table td {
    padding: 12px;
    border-bottom: 1px solid #dce7ef;
}

/* STATUS BADGES */
.status-pending {
    color: #ff9800;
    font-weight: bold;
}

.status-diproses {
    color: #0096C7;
    font-weight: bold;
}

.status-dikirim {
    color: #28a745;
    font-weight: bold;
}

.status-selesai {
    color: #6c757d;
    font-weight: bold;
}

.status-dibatalkan {
    color: #dc3545;
    font-weight: bold;
}

/* BUTTON DETAIL */
.btn-detail {
    background: #0096C7;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
}

.btn-detail:hover {
    background: #007aa1;
}

/* ADMIN UPDATE SELECT */
select {
    padding: 6px;
    border-radius: 6px;
    border: 1px solid #0096C7;
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

       <div class="d-flex align-items-center gap-3">
            <a href="/pesanan"><i class="bi bi-bag"></i></a>
            <a href="/keranjang"><i class="bi bi-cart fs-4"></i></a>
            <a href="/akun"><i class="bi bi-person-circle fs-4"></i></a>
        </div>
    </div>
</nav>

<!-- LAYOUT -->
<div class="main-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <div>
                <b>Username</b><br>
                <a style="font-size: 13px; color: gray; cursor:pointer;">Ubah Profil</a>
            </div>
        </div>

        <div class="menu">
            <div class="menu-item"><a href="/akun"><i class="bi bi-person"></i> Akun Saya</a></div>
            <div class="menu-item"><a href="/pesanan"><i class="bi bi-bag"></i> Pesanan Saya</a></div>
            <div class="menu-item"><a href="/"><i class="bi bi-bell"></i> Notifikasi</a></div>
            <div class="menu-item"><a href="/"><i class="bi bi-coin yellow-icon"></i> Point Saya</a></div>
            <div class="menu-item">
                <a href="/logout" style="text-decoration:none; color:inherit;">
                    <i class="bi bi-box-arrow-right logout-icon"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">

        <h3><b>Daftar Pesanan</b></h3>
        <br>

        <div class="pesanan-table">

            <table>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

                <?php if (!empty($pesanan)) : ?>
                    <?php foreach ($pesanan as $item): ?>
                    <tr>
                        <td>#<?= $item['id_pesanan']; ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($item['tanggal_pesanan'])); ?></td>
                        <td>Rp <?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="status-<?= $item['status']; ?>">
                                <?= ucfirst($item['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="/pesanan/detail/<?= $item['id_pesanan']; ?>" class="btn-detail">Detail</a>
                            <?php if ($role === 'admin') : ?>
                                <form action="/pesanan/update-status/<?= $item['id_pesanan']; ?>" method="post" style="display: inline;">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?= $item['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="diproses" <?= $item['status'] == 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                                        <option value="dikirim" <?= $item['status'] == 'dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                                        <option value="selesai" <?= $item['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                        <option value="dibatalkan" <?= $item['status'] == 'dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                                    </select>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada pesanan</td>
                    </tr>
                <?php endif; ?>

            </table>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>
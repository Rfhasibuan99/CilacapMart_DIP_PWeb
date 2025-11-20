<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #ffffff;
    }

    /* HEADER */
    .header {
        width: 100%;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        background: white;
    }

    /* LAYOUT FLEX */
    .main-wrapper {
        display: flex;
        padding: 30px;
        gap: 30px;
    }

    /* SIDEBAR */
    .sidebar {
        width: 250px;
    }

    .profile {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    .profile i {
        font-size: 40px;
    }

    .menu-item {
        display: flex;
        align-items: center;
        font-size: 17px;
        padding: 10px 0;
        cursor: pointer;
    }

    .menu-item i {
        margin-right: 12px;
        font-size: 25px;
    }

    .yellow-icon {
        color: #f5c400;
        font-size: 27px;
    }

    /* MAIN CONTENT */
    .content {
        flex: 1;
        background: #dff0ff;
        border-radius: 20px;
        padding: 20px;
        min-height: 520px;
    }

    .logout-icon {
        color: #ff3333;
        font-size: 25px;
    }

    /* DETAIL CONTAINER */
    .detail-container {
        background: white;
        border-radius: 15px;
        padding: 20px;
    }

    .detail-header {
        border-bottom: 2px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-diproses {
        background: #cce5ff;
        color: #004085;
    }

    .status-dikirim {
        background: #d4edda;
        color: #155724;
    }

    .status-selesai {
        background: #e2e3e5;
        color: #383d41;
    }

    .status-dibatalkan {
        background: #f8d7da;
        color: #721c24;
    }

    .info-section {
        margin-bottom: 20px;
    }

    .info-section h5 {
        margin-bottom: 10px;
        color: #333;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .info-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }

    .info-item label {
        display: block;
        font-weight: bold;
        color: #666;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .info-item span {
        color: #333;
        font-size: 14px;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .detail-table th,
    .detail-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .detail-table th {
        background: #f8f9fa;
        font-weight: bold;
        color: #333;
    }

    .product-info {
        display: flex;
        align-items: center;
    }

    .product-info img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 15px;
    }

    .product-info div {
        flex: 1;
    }

    .product-info h6 {
        margin: 0;
        font-size: 14px;
    }

    .product-info p {
        margin: 5px 0 0 0;
        color: #666;
        font-size: 12px;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
    }

    .btn-back:hover {
        background: #5a6268;
        color: white;
    }

    .total-row {
        background: #f8f9fa;
        font-weight: bold;
    }
</style>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top main-nav">
    <div class="container-fluid px-4">

        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="../../../../logo.jpg" alt="Cilacap Mart Logo" class="me-2" width="100px">
            <span>Cilacap Mart</span>
        </a>

        <form action="<?= site_url('/rio'); ?>" method="get" class="d-flex">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Masukkan Pencarian Barang" name="cari">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-cart fs-4"></i>
            <i class="bi bi-person-circle fs-4"></i>
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
            <div class="menu-item"><i class="bi bi-person"></i> Akun Saya</div>
            <div class="menu-item"><i class="bi bi-bag"></i> Pesanan Saya</div>
            <div class="menu-item"><i class="bi bi-bell"></i> Notifikasi</div>
            <div class="menu-item"><i class="bi bi-coin yellow-icon"></i> Point Saya</div>
            <div class="menu-item">
                <a href="/logout" style="text-decoration:none; color:inherit;">
                    <i class="bi bi-box-arrow-right logout-icon"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="content">

        <h3><b>Detail Pesanan #<?= $pesanan['id_pesanan']; ?></b></h3>
        <br>

        <div class="detail-container">

            <!-- HEADER -->
            <div class="detail-header">
                <h4>Informasi Pesanan</h4>
                <span class="status-badge status-<?= $pesanan['status']; ?>">
                    <?= ucfirst($pesanan['status']); ?>
                </span>
            </div>

            <!-- INFO SECTION -->
            <div class="info-section">
                <div class="info-grid">
                    <div class="info-item">
                        <label>ID Pesanan</label>
                        <span>#<?= $pesanan['id_pesanan']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Pesanan</label>
                        <span><?= date('d/m/Y H:i', strtotime($pesanan['tanggal_pesanan'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Total Harga</label>
                        <span>Rp <?= number_format($pesanan['total_harga'], 0, ',', '.'); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Status</label>
                        <span class="status-<?= $pesanan['status']; ?>"><?= ucfirst($pesanan['status']); ?></span>
                    </div>
                </div>
            </div>

            <!-- ALAMAT PENGIRIMAN -->
            <?php if (!empty($pesanan['alamat_pengiriman'])) : ?>
            <div class="info-section">
                <h5>Alamat Pengiriman</h5>
                <div class="info-item">
                    <span><?= nl2br($pesanan['alamat_pengiriman']); ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- DETAIL BARANG -->
            <div class="info-section">
                <h5>Detail Barang</h5>
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $item): ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="/img/<?= $item['gambar'] ?? 'default.jpg'; ?>" alt="Product">
                                    <div>
                                        <h6><?= $item['nama_barang']; ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td>Rp <?= number_format($item['harga_barang'], 0, ',', '.'); ?></td>
                            <td><?= $item['jumlah']; ?></td>
                            <td>Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                            <td><strong>Rp <?= number_format($pesanan['total_harga'], 0, ',', '.'); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <a href="/pesanan" class="btn-back">← Kembali ke Daftar Pesanan</a>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>

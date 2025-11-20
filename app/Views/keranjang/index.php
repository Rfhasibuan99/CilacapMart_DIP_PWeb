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

    /* CART TABLE */
    .cart-table {
        width: 100%;
        background: white;
        border-radius: 15px;
        padding: 20px;
    }

    .cart-table table {
        width: 100%;
    }

    .cart-table th,
    .cart-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    .cart-img {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
    }

    .btn-hapus {
        background: #ff4d4d;
        color: white;
        border: none;
        padding: 5px 12px;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-checkout {
        margin-top: 20px;
        background: #008cff;
        color: white;
        padding: 12px;
        width: 200px;
        border-radius: 10px;
        border: none;
        float: right;
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

        <h3><b>Keranjang Belanja</b></h3>
        <br>

        <div class="cart-table">

            <table>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>

                <?php if (!empty($keranjang)) : ?>
                    <?php foreach ($keranjang as $item): ?>
                    <tr>
                        <td><img src="/img/<?= $item['gambar']; ?>" class="cart-img"></td>
                        <td><?= $item['nama_barang']; ?></td>
                        <td>Rp <?= number_format($item['harga_barang'], 0, ',', '.'); ?></td>
                        <td><?= $item['jumlah']; ?></td>
                        <td>Rp <?= number_format($item['harga_barang'] * $item['jumlah'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="/keranjang/hapus/<?= $item['id_keranjang']; ?>">
                                <button class="btn-hapus">Hapus</button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Keranjang masih kosong</td>
                    </tr>
                <?php endif; ?>

            </table>

        </div>

        <?php if (!empty($keranjang)) : ?>
            <a href="/pesanan/checkout">
                <button class="btn-checkout">Checkout</button>
            </a>
        <?php endif; ?>

    </div>

</div>

<?= $this->endSection(); ?>

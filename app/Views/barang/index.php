<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
    body {
        background-color: #F5F5F5;
        font-family: 'Arial', sans-serif;
    }

    .product-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        gap: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
    }

    .product-card img {
        width: 100%;
        max-width: 350px;
        height: 350px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .product-info h3 {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .price {
        color: #FF5722;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .old-price {
        text-decoration: line-through;
        color: #888;
        font-size: 16px;
    }

    .stock {
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }

    .desc-box {
        background: #f8f8f8;
        border-radius: 8px;
        padding: 12px;
        margin-top: 10px;
        border: 1px solid #e4e4e4;
    }

    .action-buttons button,
    .action-buttons a {
        padding: 10px 20px;
        border-radius: 10px;
    }

    .btn-beli {
        background-color: #FF9800;
        border: none;
        color: white;
    }

    .btn-beli:hover {
        background-color: #e68900;
    }

    .btn-cart {
        background-color: #0096C7;
        border: none;
        color: white;
    }

    .btn-cart:hover {
        background-color: #007AA1;
    }
</style>

<div class="mb-3 back-text" onclick="history.back()">
    <h4>← Kembali ke Dashboard</h4>
</div>
<div class="container pt-4">
    <h2 class="mb-4 fw-bold">Daftar Produk barang</h2>

    <?php if (in_groups('admin')): ?>
        <div class="text-end mb-3">
            <a href="/barang/tambah" class="btn btn-primary">Tambah Barang</a>
        </div>
    <?php endif; ?>

    <?php foreach ($barang as $b): ?>
        <div class="product-card">

            <!-- GAMBAR PRODUK -->
            <div>
                <img src="<?= base_url('img/' . $b['gambar']) ?>"
                    onerror="this.src='https://via.placeholder.com/350x350?text=No+Image'">
            </div>

            <!-- DETAIL PRODUK -->
            <div class="product-info">

                <h3><?= $b['nama_barang']; ?></h3>

                <div class="price">
                    Rp <?= number_format($b['harga_jual'], 0, ',', '.'); ?>
                </div>

                <?php if (in_groups('admin')): ?>
                    <div class="old-price">
                        Harga asli: Rp <?= number_format($b['harga_beli'], 0, ',', '.'); ?>
                    </div>
                <?php endif; ?>

                <div class="stock">
                    Stok: <strong><?= $b['stok']; ?></strong>
                </div>

                <div class="desc-box">
                    <?= $b['deskripsi']; ?>
                </div>

                <!-- BUTTON -->
                <div class="action-buttons mt-3 d-flex gap-3">

                    <form action="/keranjang/tambah" method="post" class="d-inline">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_barang" value="<?= $b['id_barang']; ?>">
                        <input type="hidden" name="jumlah" value="1">

                        <button type="submit" class="btn btn-success btn-sm">
                            + Keranjang
                        </button>
                    </form>


                    <a href="/pesanan/<?= $b['id_barang']; ?>" class="btn btn-beli">
                        Beli Sekarang
                    </a>

                    <?php if (in_groups('admin')): ?>
                        <a href="/barang/ubah/<?= $b['id_barang']; ?>" class="btn btn-warning text-white">
                            Ubah
                        </a>

                        <a href="/barang/hapus/<?= $b['id_barang']; ?>" class="btn btn-danger">
                            Hapus
                        </a>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>


<?= $this->endSection(); ?>
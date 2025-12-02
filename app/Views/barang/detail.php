<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: .2s;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.10);
    }

    .product-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .product-info {
        padding: 10px;
    }

    .product-name {
        font-size: 14px;
        font-weight: bold;
        min-height: 40px;
        color: #333;
    }

    .product-price {
        font-size: 16px;
        color: #f57224;
        /* warna oranye Shopee */
        font-weight: bold;
        margin-bottom: 6px;
    }

    .product-stock {
        font-size: 12px;
        color: #777;
    }

    .btn-beli {
        background: #f57224;
        color: white;
        border: none;
        padding: 8px;
        width: 100%;
        border-radius: 5px;
        font-weight: bold;
        margin-top: 8px;
        transition: .2s;
    }

    .btn-beli:hover {
        background: #d45a18;
    }

    .detail-container {
        display: flex;
        gap: 20px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .detail-container img {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 8px;
    }

    .detail-info {
        flex: 1;
    }
</style>
<div class="mb-3 back-text" onclick="history.back()">
    <h4>← Kembali ke Dashboard</h4>
</div>
<div class="container pt-4">
    <h2 class="mb-4 fw-bold">Detail Produk</h2>

    <div class="detail-container">

        <img src="<?= base_url('img/' . $barang['gambar']) ?>"
            onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">

        <div class="detail-info">

            <h3><?= $barang['nama_barang']; ?></h3>

            <h4 class="text-danger mt-2">
                Rp <?= number_format($barang['harga_jual'], 0, ',', '.'); ?>
            </h4>

            <p class="mt-2">
                <strong>Stok:</strong> <?= $barang['stok']; ?>
            </p>

            <p class="mt-3"><?= $barang['deskripsi']; ?></p>

            <form action="/keranjang/tambah" method="post">
    <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
    <input type="hidden" name="jumlah" value="1">
    <button type="submit" class="btn btn-warning mt-3">Beli Sekarang</button>
</form>


            <form action="/keranjang/tambah" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
                <input type="hidden" name="jumlah" value="1">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                </button>
            </form>

            <?php if (in_groups('admin')): ?>
                <div class="text-end mb-3">
                    <a href="/barang/ubah/<?= $barang['id_barang']; ?>" class="btn btn-primary">Ubah Barang</a>
                </div>
            <?php endif; ?>
            <?php if (in_groups('admin')): ?>
                <div class="text-end mb-3">
                    <a href="/barang/hapus/<?= $barang['id_barang']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus Barang</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>
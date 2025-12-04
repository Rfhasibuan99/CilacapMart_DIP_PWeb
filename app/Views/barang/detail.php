<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background-color: #F5F6F8; /* abu muda latar */
    }

    .back-text h4 {
        color: #003366;
        cursor: pointer;
        font-weight: 600;
    }

    .container h2,
    .detail-info h3 {
        color: #003366; /* biru navy */
    }

    .detail-container {
        display: flex;
        gap: 20px;
        background: #ffffff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e5e5;
    }

    .detail-container img {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }

    .detail-info h4 {
        color: #C0392B; /* warna merah harga pada desain */
        font-weight: bold;
    }

    .product-price {
        color: #C0392B;
    }

    /* tombol biru disamakan seperti desain */
    .btn-primary {
        background-color: #003366;
        border-color: #003366;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #002849;
        border-color: #002849;
    }

    /* tombol kuning tetap, tidak diubah */
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

            <h4 class="mt-2">
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

                <a type="submit" class="btn btn-primary mt-2">
                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
</a>
            </form>

            <?php if (in_groups('admin')): ?>
                <div class="text-end mb-3 mt-3">
                    <a href="/barang/ubah/<?= $barang['id_barang']; ?>" class="btn btn-primary">Ubah Barang</a>
                </div>
            <?php endif; ?>

            <?php if (in_groups('admin')): ?>
                <div class="text-end mb-3">
                    <a href="/barang/hapus/<?= $barang['id_barang']; ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                        Hapus Barang
                    </a>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>

<?= $this->endSection(); ?>

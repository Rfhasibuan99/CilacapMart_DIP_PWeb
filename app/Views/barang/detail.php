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

            <h4 class="mt-2 product-price">
                Rp <?= number_format($barang['harga_jual'], 0, ',', '.'); ?>
            </h4>

            <p class="mt-2">
                <strong>Stok:</strong> <?= $barang['stok']; ?>
            </p>

            <p class="mt-3"><?= $barang['deskripsi']; ?></p>

            <!-- FORM Beli Sekarang (Beli Langsung) -->
            <form action="<?= base_url('/checkout/beli-langsung') ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
                <input type="hidden" name="nama_barang" value="<?= $barang['nama_barang']; ?>">
                <input type="hidden" name="harga_jual" value="<?= $barang['harga_jual']; ?>">
                <input type="hidden" name="gambar" value="<?= $barang['gambar']; ?>">
                
                <div class="input-group" style="width: 150px;">
                    <span class="input-group-text">Qty</span>
                    <input type="number" name="jumlah" value="1" min="1" max="<?= $barang['stok']; ?>" class="form-control text-center">
                </div>

                <button type="submit" class="btn btn-warning mt-3">Beli Sekarang</button>
            </form>
            
            <!-- FORM Tambah ke Keranjang -->
            <form action="<?= base_url('/keranjang/tambah') ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
                <input type="hidden" name="nama_barang" value="<?= $barang['nama_barang']; ?>">
                <input type="hidden" name="harga_jual" value="<?= $barang['harga_jual']; ?>">
                <input type="hidden" name="gambar" value="<?= $barang['gambar']; ?>">
                <!-- Ambil jumlah dari form Beli Langsung jika ingin disamakan, atau set default 1 -->
                <input type="hidden" name="jumlah" value="1"> 
                
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                </button>
            </form>

            <?php if (in_groups('admin')): ?>
                <!-- ... Tombol Admin ... -->
            <?php endif; ?>

        </div>

    </div>
</div>

<?= $this->endSection(); ?>
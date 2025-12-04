<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<style>
    body {
        background-color: #E8EFF7 !important; /* Biru muda sesuai desain */
    }
    .keranjang-item-row {
        background-color: #fff;
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 10px 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
    }
    .keranjang-header {
        color: #333;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .img-thumb {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }
    .input-jumlah {
        width: 60px;
        text-align: center;
    }
    .btn-hapus {
        background-color: #f0f8ff;
        color: #333;
        border: 1px solid #cceeff;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 6px;
    }
    .total-checkout-area {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-pesan-sekarang {
        background-color: #003366; /* Biru gelap */
        color: #fff;
        padding: 10px 40px;
        font-size: 18px;
        border-radius: 6px;
        border: none;
        width: 100%;
        margin-top: 20px;
    }
</style>

<div class="container py-4">
    <h3 class="keranjang-header">Keranjang Belanja</h3>
    
    <!-- Header Tabel Manual -->
    <div class="row text-secondary mb-2" style="font-size: 14px;">
        <div class="col-1 text-center"></div>
        <div class="col-4">Nama</div>
        <div class="col-2 text-center">Harga Satuan</div>
        <div class="col-1 text-center">Jumlah</div>
        <div class="col-2 text-center">Total</div>
        <div class="col-2 text-center">Aksi</div>
    </div>

    <?php if (empty($keranjang)): ?>
        <div class="alert alert-warning text-center">Keranjang belanja Anda kosong.</div>
    <?php else: ?>
        <!-- Looping Item Keranjang -->
        <?php foreach($keranjang as $item): ?>
        <div class="keranjang-item-row">
            <!-- Kolom Checkbox -->
            <div class="col-1 text-center">
                <input class="form-check-input" type="checkbox" checked>
            </div>
            
            <!-- Kolom Gambar dan Nama -->
            <div class="col-4 d-flex align-items-center">
                <img src="<?= base_url('img/' . $item['gambar']) ?>" class="img-thumb me-3">
                <div>
                    <div class="fw-bold"><?= $item['nama_barang'] ?></div>
                    <div class="text-secondary" style="font-size: 14px;">Harga: Rp.<?= number_format($item['harga_jual']) ?></div>
                </div>
            </div>

            <!-- Kolom Harga Satuan -->
            <div class="col-2 text-center">
                Rp.<?= number_format($item['harga_jual']) ?>
            </div>
            
            <!-- Kolom Jumlah -->
            <div class="col-1 text-center">
                <!-- Gunakan input jumlah dari form untuk update atau checkout -->
                <input type="number" value="<?= $item['jumlah'] ?>" min="1" class="form-control input-jumlah mx-auto" style="display: inline-block;">
            </div>

            <!-- Kolom Total -->
            <div class="col-2 text-center fw-bold">
                Rp.<?= number_format($item['subtotal']) ?>
            </div>

            <!-- Kolom Hapus -->
            <div class="col-2 text-center">
                <a href="<?= base_url('/keranjang/hapus/' . $item['id_keranjang']) ?>" class="btn btn-sm btn-light btn-hapus">hapus</a>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Area Total dan Checkout -->
        <div class="total-checkout-area">
            <div class="d-flex align-items-center">
                <input class="form-check-input me-2" type="checkbox" checked>
                <label class="form-check-label">Pilih semua</label>
            </div>
            <div class="d-flex align-items-center">
                <div class="me-4 fw-bold">Total (<?= count($keranjang) ?> Produk): Rp.<?= number_format($total) ?></div>
                <a href="<?= base_url('/checkout') ?>" class="btn btn-info btn-sm">Buat Pesanan</a>
            </div>
        </div>

        <!-- Tombol Pesan Sekarang -->
        <a href="<?= base_url('/checkout') ?>" class="btn btn-pesan-sekarang">Pesan sekarang</a>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
.order-container { max-width: 600px; margin: 0 auto; padding: 20px; }
.order-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; }
.item-preview { display: flex; align-items: center; margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; }
.item-image { width: 80px; height: 80px; object-fit: cover; border-radius: 6px; margin-right: 20px; }
.item-details h5 { margin: 0 0 5px 0; }
.item-price { font-size: 18px; font-weight: bold; color: #28a745; }
.form-group { margin-bottom: 20px; }
.btn-order { background: #28a745; border: none; padding: 12px 30px; border-radius: 6px; color: white; font-weight: bold; }
.btn-order:hover { background: #218838; color: white; }
</style>

<div class="order-container">
    <h2 class="mb-4">Pesan Langsung</h2>

    <div class="order-card">
        <!-- Preview Item -->
        <div class="item-preview">
            <div>
                <?php if (!empty($barang['gambar'])): ?>
                    <img src="/img/<?= $barang['gambar'] ?>" class="item-image" alt="">
                <?php else: ?>
                    <div style="width: 80px; height: 80px; background: #eee; border-radius: 6px; margin-right: 20px;"></div>
                <?php endif; ?>
            </div>
            <div class="item-details">
                <h5><?= esc($barang['nama_barang']) ?></h5>
                <p class="text-muted mb-1"><?= esc($barang['deskripsi'] ?? 'Tidak ada deskripsi') ?></p>
                <div class="item-price">Rp <?= number_format($barang['harga_jual'], 0, ',', '.') ?></div>
            </div>
        </div>

        <!-- Form Pemesanan -->
        <form action="/pesanan/proses-pesan-langsung" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_barang" value="<?= $barang['id_barang'] ?>">

            <div class="form-group">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input
                    type="number"
                    class="form-control"
                    id="jumlah"
                    name="jumlah"
                    value="<?= old('jumlah', 1) ?>"
                    min="1"
                    max="<?= $barang['stok'] ?? 999 ?>"
                    required
                >
                <?php if (isset($validation) && $validation->hasError('jumlah')): ?>
                    <div class="text-danger mt-1">
                        <?= $validation->getError('jumlah') ?>
                    </div>
                <?php endif; ?>
                <small class="text-muted">Stok tersedia: <?= $barang['stok'] ?? 'Tidak tersedia' ?></small>
            </div>

            <div class="form-group">
                <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
                <textarea
                    class="form-control"
                    id="alamat_pengiriman"
                    name="alamat_pengiriman"
                    rows="3"
                    placeholder="Masukkan alamat lengkap pengiriman"
                    required
                ><?= old('alamat_pengiriman') ?></textarea>

                <?php if (isset($validation) && $validation->hasError('alamat_pengiriman')): ?>
                    <div class="text-danger mt-1">
                        <?= $validation->getError('alamat_pengiriman') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-end">
                <a href="/" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-order">
                    <i class="bi bi-cart-check"></i> Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

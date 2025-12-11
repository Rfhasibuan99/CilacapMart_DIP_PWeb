<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container container-checkout">
    <a href="<?= base_url('/keranjang') ?>" class="back-link">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Keranjang
    </a>

    <h3 class="fw-bold mt-3">Checkout Pesanan</h3>

    <div class="row mt-4">
        <div class="col-lg-8">
            <h5 class="mb-3 mt-4">Detail Pesanan (<?= count($keranjang) ?> Item)</h5>
            <div class="card p-3 mb-4">
                <?php 
                if (!empty($keranjang)): ?>
                    <?php foreach($keranjang as $item): 
                        $subtotal_item = ($item['harga_jual'] ?? 0) * ($item['jumlah'] ?? 0); 
                    ?>
                    <div class="item-detail">
                        <img src="<?= base_url('img/' . ($item['gambar'] ?? '')) ?>" class="item-img" onerror="this.src='https://via.placeholder.com/60x60?text=No+Image'">
                        <div class="flex-grow-1">
                            <div class="fw-bold"><?= $item['nama_barang'] ?></div>
                            <div class="text-secondary" style="font-size: 14px;">
                                Rp <?= number_format($item['harga_jual'] ?? 0) ?> x <?= $item['jumlah'] ?? 0 ?>
                            </div>
                        </div>
                        <div class="fw-bold text-end">
                            Rp <?= number_format($subtotal_item) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-danger">Tidak ada item yang dipilih.</div>
                <?php endif; ?>
            </div>

        </div>

        <div class="col-lg-4">
            <h5 class="mb-3">Rincian Pembayaran</h5>
            <div class="card p-4">
                
                <div class="total-rincian-row">
                    <div class="text-secondary">Subtotal Produk</div>
                    <div>Rp <?= number_format($subtotal_produk) ?></div>
                </div>
                
                <div class="total-rincian-row total-final">
                    <div class="fs-5">Total Bayar</div>
                    <div class="fs-5 fw-bold text-danger">Rp <?= number_format($total_final) ?></div>
                </div>
                
                <form action="<?= base_url('/checkout/proses') ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="alamat_pengiriman" value="<?= $alamat_user['alamat_lengkap'] ?>">
                    <input type="hidden" name="total_final" value="<?= $total_final ?>">
                    <input type="hidden" name="sumber_pesanan" value="keranjang_terpilih"> <input type="hidden" name="items_data" value='<?= json_encode($keranjang) ?>'>

                    <button type="submit" class="btn btn-checkout-final w-100 mt-4">
                        Buat Pesanan (Rp <?= number_format($total_final) ?>)
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
.cart-table { background: #fff; padding:20px; border-radius:10px; }
.cart-img { width:80px; height:80px; object-fit:cover; border-radius:6px; }
.toko-group { margin-bottom:18px; padding:12px; border-radius:8px; background:#f8fbff; }
footer {
    background-color: #003366; /* BIRU TUA */
    padding: 25px 50px;
    color: #ffffff; /* TEKS PUTIH */
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

footer h6 {
    font-weight: 700;
    margin-bottom: 8px;
    color: #ffffff;
}

footer a {
    color: #ffffff;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}
</style>

<div class="container py-4">
    <h3>Keranjang Belanja</h3>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <?php if (!empty($grouped)): ?>
        <?php foreach ($grouped as $tokoId => $items): ?>
            <div class="toko-group">
                <h5>Toko: <?= esc($tokoId) ?></h5>

                <div class="cart-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $subtotal = 0; ?>
                            <?php foreach ($items as $item): ?>
                                <?php $lineTotal = ($item['harga_barang'] ?? 0) * $item['jumlah']; $subtotal += $lineTotal; ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($item['gambar'])): ?>
                                            <img src="/img/<?= $item['gambar'] ?>" class="cart-img" alt="">
                                        <?php else: ?>
                                            <div style="width:80px;height:80px;background:#eee;border-radius:6px;"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['nama_barang']) ?></td>
                                    <td>Rp <?= number_format($item['harga_barang'] ?? 0,0,',','.') ?></td>
                                    <td><?= $item['jumlah'] ?></td>
                                    <td>Rp <?= number_format($lineTotal,0,',','.') ?></td>
                                    <td>
                                        <a href="/keranjang/hapus/<?= $item['id_keranjang'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                <td><strong>Rp <?= number_format($subtotal,0,',','.') ?></strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- tombol checkout per toko -->
                    <div class="text-end">
                        <a href="/pesanan/checkout?toko=<?= urlencode($tokoId) ?>" class="btn btn-primary">Checkout Toko Ini</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- Tombol checkout global -->
        <div class="text-end mt-3">
            <a href="/pesanan/checkout" class="btn btn-success">Checkout Semua</a>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Keranjang masih kosong</div>
    <?php endif; ?>
</div>
<footer>
        <div>
            <h6>Layanan Pelanggan</h6>
            Bantuan<br>Lacak Pengiriman Penjual<br>Lacak Pesanan Pembeli<br>Hubungi Kami
        </div>
        <div>
            <h6>Jelajahi Cilacap Mart</h6>
            Tentang Kami<br>Seller Centre<br>Kontak Media
        </div>
        <div><h6>Pembayaran</h6></div>
        <div><h6>Pengiriman</h6></div>
    </footer>
<?= $this->endSection(); ?>

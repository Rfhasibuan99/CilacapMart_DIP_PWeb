<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<style>
    body {
        background-color: #f0f8ff;
    }

    .container {
        max-width: 900px;
    }

    .invoice-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-top: 30px;
    }

    .success-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .success-icon {
        color: #28a745;
        font-size: 5rem;
        margin-bottom: 10px;
        display: block;
    }

    .invoice-title {
        color: #003366;
        font-weight: bold;
        margin-top: 0;
    }

    .detail-section h6 {
        font-weight: bold;
        color: #003366;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        font-size: 14px;
    }

    .detail-item-list {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px;
        margin-bottom: 20px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dotted #ccc;
    }

    .item-row:last-child {
        border-bottom: none;
    }

    .item-info {
        flex-grow: 1;
        padding-right: 10px;
    }

    .total-section {
        background-color: #e8f3ff;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        font-weight: bold;
    }

    .total-final-amount {
        color: #b30000;
        font-size: 1.5rem;
    }

    .btn-action-group {
        text-align: center;
        margin-top: 30px;
    }

    .btn-finish {
        background-color: #003366;
        color: #fff;
        padding: 12px 30px;
        font-size: 18px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .btn-finish:hover {
        background-color: #002244;
        color: #fff;
    }
</style>

<div class="container py-4">
    <div class="invoice-card">
        <div class="success-header">
            <i class="fas fa-check-circle success-icon"></i>
            <h1 class="invoice-title">PESANAN BERHASIL DIBUAT</h1>
            <p class="text-secondary">Pesanan <?= $pesanan['kode_pesanan'] ?? 'INV/...' ?> telah dibuat. Silahkan selesaikan pembayaran.</p>
        </div>


        <hr>

        <div class="detail-section">
            <h6 class="mb-4">Informasi Transaksi</h6>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="fw-bold">Nomor Pesanan:</div>
                        <div><?= $pesanan['kode_pesanan'] ?? 'INV/20250101/001' ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="fw-bold">Tanggal Pesan:</div>
                        <div><?= date('d M Y, H:i', strtotime($pesanan['tanggal_pesan'] ?? date('Y-m-d H:i'))) ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="fw-bold">Status:</div>
                        <div class="fw-bold text-warning"><?= $pesanan['status'] ?? 'Menunggu Pembayaran' ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="fw-bold">Metode Pembayaran:</div>
                        <div class="fw-bold text-primary"><?= $pesanan['metode_pembayaran'] ?? 'QRIS' ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="mt-3 mt-md-0" style="border-bottom: none; padding-bottom: 0;">Alamat Pengiriman</h6>
                    <div class="card p-3 bg-light border-0">
                        <div class="fw-bold"><?= $pesanan['penerima_pesanan'] ?? 'Nama Penerima' ?> | <?= $pesanan['telp_pesanan'] ?? '0812xxxxxx' ?></div>
                        <div>Metode Pengiriman: **<?= $pesanan['metode_pengiriman'] ?? 'Grob Standard' ?>**</div>
                        <div><?= $pesanan['alamat_lengkap_pesanan'] ?? 'Alamat Tidak Ditemukan.' ?></div>
                    </div>
                </div>
            </div>

            <h6 class="mt-4">Detail Item Pesanan</h6>
            <div class="detail-item-list">
                <?php $totalItems = 0; ?>
                <?php if (!empty($detail)): ?>
                    <?php foreach ($detail as $item): ?>
                        <div class="item-row">
                            <div class="item-info">
                                <div class="fw-bold"><?= $item['nama_barang'] ?></div>
                                <div class="text-secondary" style="font-size: 13px;">
                                    Rp <?= number_format($item['harga_barang'] ?? 0) ?> x <?= $item['jumlah'] ?? 0 ?>
                                </div>
                            </div>
                            <div class="fw-bold">Rp <?= number_format($item['subtotal'] ?? 0) ?></div>
                        </div>
                        <?php $totalItems += $item['jumlah'] ?? 0; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="item-row">Tidak ada detail item.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="total-section">
            <h6 style="color: #003366; border-bottom: none; margin-bottom: 10px;">Ringkasan Pembayaran</h6>

            <div class="detail-row">
                <div>Subtotal Produk (<?= $totalItems ?> Item)</div>
                <div>Rp <?= number_format($pesanan['subtotal'] ?? 0) ?></div>
            </div>
            <div class="detail-row">
                <div>Diskon (10%)</div>
                <div>- Rp <?= number_format($pesanan['diskon'] ?? 0) ?></div>
            </div>
            <div class="detail-row">
                <div>Biaya Pengiriman</div>
                <div>+ Rp <?= number_format($pesanan['ongkir'] ?? 0) ?></div>
            </div>
            <div class="detail-row">
                <div>PPN (11%)</div>
                <div>+ Rp <?= number_format(($pesanan['total_harga'] ?? 0) - (($pesanan['subtotal'] ?? 0) - ($pesanan['diskon'] ?? 0) + ($pesanan['ongkir'] ?? 0))) ?></div>
            </div>


            <hr class="my-2">

            <div class="total-row">
                <div>Total Pembayaran</div>
                <div class="total-final-amount">Rp <?= number_format($pesanan['total_harga'] ?? 0) ?></div>
            </div>
        </div>

        <div class="btn-action-group">

            <a href="<?= base_url('pesanan/bayar/' . ($pesanan['id_pesanan'] ?? 0)) ?>" class="btn-finish" style="background-color: #28a745;">
                <i class="fas fa-money-bill-wave me-2"></i> Lanjut Ke Pembayaran
            </a>

            <a href="<?= base_url('pesanan') ?>" class="btn-finish">
                <i class="fas fa-list-alt me-2"></i> Lihat Riwayat Pesanan
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
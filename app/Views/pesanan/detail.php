<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background-color: #f0f8ff;
    }

    .invoice-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .invoice-header {
        text-align: center;
        border-bottom: 2px solid #003366;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .invoice-title {
        color: #003366;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .invoice-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .info-section h5 {
        color: #003366;
        margin-bottom: 10px;
    }

    .table th {
        background-color: #003366;
        color: white;
        border: none;
    }

    .table td {
        border: 1px solid #dee2e6;
    }

    .total-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .btn-print {
        background-color: #003366;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .btn-print:hover {
        background-color: #002244;
        color: white;
    }
</style>

<div class="container py-5">
    <?php if (in_groups('admin')): ?>
        <div class="d-flex gap-2 mb-3 justify-content-start" style="max-width: 800px; margin: 0 auto 1rem;">
            <a href="/pesanan/ubah/<?= $pesanan['id_pesanan']; ?>" class="btn btn-warning text-white">
                Ubah Pesanan
            </a>

            <a href="/pesanan/hapus/<?= $pesanan['id_pesanan']; ?>" class="btn btn-danger">
                Hapus Pesanan
            </a>
        </div>
    <?php endif; ?>

    <div class="invoice-container">
        <div class="invoice-header">
            <h1 class="invoice-title">INVOICE</h1>
            <p class="mb-0">CilacapMart - Toko Online Terpercaya</p>
        </div>

        <div class="invoice-info">
            <div class="info-section">
                <h5>Informasi Pesanan</h5>
                <p><strong>Kode Pesanan:</strong> <?= $pesanan['kode_pesanan'] ?></p>
                <p><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($pesanan['tanggal_pesan'])) ?></p>
                <p><strong>Status:</strong> <?= $pesanan['status'] ?></p>
            </div>
            <div class="info-section">
                <h5>Informasi Pengiriman</h5>
                <p><strong>Penerima:</strong> <?= $alamat['penerima'] ?? $pesanan['penerima_pesanan'] ?? 'N/A' ?></p>
                <p><strong>Telepon:</strong> <?= $alamat['telp'] ?? $pesanan['telp_pesanan'] ?? 'N/A' ?></p>
                <p><strong>Alamat:</strong> <?= $alamat['alamat_lengkap'] ?? $pesanan['alamat_lengkap_pesanan'] ?? 'N/A' ?></p>
            </div>
        </div>

        <div class="info-section">
            <h5>Metode Pembayaran & Pengiriman</h5>
            <p><strong>Pembayaran:</strong> <?= $metode_bayar ?? $pesanan['metode_pembayaran'] ?? 'N/A' ?></p>
            <p><strong>Pengiriman:</strong> <?= $metode_kirim ?? $pesanan['metode_pengiriman'] ?? 'N/A' ?></p>
        </div>

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                $total = 0; ?>
                <?php foreach ($detail as $d): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['nama_barang'] ?></td>
                        <td>Rp <?= number_format($d['harga_barang']) ?></td>
                        <td><?= $d['jumlah'] ?></td>
                        <td>Rp <?= number_format($d['subtotal']) ?></td>
                    </tr>
                    <?php $total += $d['subtotal']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-section">
            <div class="row">
                <div class="col-md-8">
                    <p><strong>Total Pembayaran:</strong></p>
                </div>
                <div class="col-md-4 text-end">
                    <h4 class="text-primary">Rp <?= number_format($total) ?></h4>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button onclick="window.print()" class="btn btn-print">
                <i class="fas fa-print me-2"></i>Cetak Invoice
            </button>
        </div>

        <?php if ($pesanan['status'] == 'Menunggu Pembayaran'): ?>
            <div class="text-center mt-3">
                <a href="<?= base_url('pembayaran/' . $pesanan['id_pesanan']) ?>" class="btn btn-success">
                    <i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
</script>

<?= $this->endSection(); ?>
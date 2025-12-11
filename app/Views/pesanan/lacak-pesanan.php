<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4Cg+bL/Wq8X0v1zI7K3f6R0e1n7Z1l5y00W6H/3a8g7K8M6+8i5z/e8K/n7Q+9uGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    /* PRINTER STYLES */
    @media print {

        .btn-print,
        .no-print {
            display: none !important;
        }

        .invoice-container {
            box-shadow: none !important;
            border: 0 !important;
            padding: 0 !important;
        }

        body {
            background-color: white !important;
        }
    }

    /* GENERAL STYLES */
    body {
        background-color: #f0f8ff;
        /* Warna latar belakang lembut */
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
        flex-wrap: wrap;
    }

    .info-section {
        width: 48%;
        min-width: 300px;
        margin-bottom: 15px;
    }

    .info-section h5 {
        color: #003366;
        margin-bottom: 10px;
        border-bottom: 1px dashed #ccc;
        padding-bottom: 5px;
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
        padding: 15px;
        margin-top: 20px;
        border: 1px solid #003366;
        border-radius: 5px;
        background-color: #e6f0ff;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        font-size: 1.1rem;
    }

    .total-final {
        border-top: 2px dashed #003366;
        font-weight: bold;
        font-size: 1.3rem;
        margin-top: 10px;
        padding-top: 10px;
        color: #b30000;
    }

    .btn-print,
    .btn-action {
        background-color: #003366;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .btn-print:hover,
    .btn-action:hover {
        background-color: #002244;
        color: white;
    }

    .status-badge {
        font-size: 1rem;
        padding: 5px 10px;
        border-radius: 5px;
    }
</style>

<div class="container py-5">
    <div class="invoice-container">
        <div class="invoice-header">
            <h1 class="invoice-title">DETAIL PESANAN</h1>
            <p class="mb-0">CilacapMart - Toko Online Terpercaya</p>
        </div>

        <?php if (in_groups('admin') && !empty($pesanan['id_pesanan'])): ?>
            <div class="mb-3 no-print text-center">
                <a href="<?= base_url('admin/pesanan/ubah_status/' . $pesanan['id_pesanan']) ?>" class="btn btn-warning text-white me-2">
                    <i class="fas fa-edit me-1"></i> Ubah Status Pesanan
                </a>
                <form action="<?= base_url('admin/pesanan/batalkan/' . $pesanan['id_pesanan']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini? Aksi ini tidak dapat dibatalkan.');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Hapus Pesanan
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <div class="invoice-info">
            <div class="info-section">
                <h5>Informasi Pesanan</h5>
                <p><strong>Kode Pesanan:</strong> <?= $pesanan['kode_pesanan'] ?? 'N/A' ?></p>
                <p><strong>Tanggal Pesan:</strong> <?= date('d/m/Y H:i', strtotime($pesanan['tanggal_pesan'] ?? date('Y-m-d H:i:s'))) ?></p>
                <p><strong>Status:</strong>
                    <?php
                    $status = $pesanan['status'] ?? 'N/A';
                    $badge_class = 'bg-secondary';
                    if ($status == 'Selesai') $badge_class = 'bg-success';
                    else if ($status == 'Diproses') $badge_class = 'bg-info';
                    else if ($status == 'Menunggu Pembayaran') $badge_class = 'bg-warning text-dark';
                    else if ($status == 'Dibatalkan') $badge_class = 'bg-danger';
                    ?>
                    <span class="status-badge <?= $badge_class ?>"><?= $status ?></span>
                </p>
            </div>
            <div class="info-section">
                <h5>Informasi Pengiriman</h5>
                <p><strong>Penerima:</strong> <?= $pesanan['penerima_pesanan'] ?? 'N/A' ?></p>
                <p><strong>Telepon:</strong> <?= $pesanan['telp_pesanan'] ?? 'N/A' ?></p>
                <p><strong>Alamat:</strong> <?= $pesanan['alamat_lengkap_pesanan'] ?? 'N/A' ?></p>
            </div>
        </div>

        <div class="info-section mb-4" style="width: 100%;">
            <h5>Metode Pembayaran & Pengiriman</h5>
            <p class="mb-1"><strong>Pembayaran:</strong> <span class="fw-bold"><?= $pesanan['metode_pembayaran'] ?? 'N/A' ?></span></p>
            <p class="mb-0"><strong>Pengiriman:</strong> <?= $pesanan['metode_pengiriman'] ?? 'N/A' ?></p>
        </div>

        <table class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Barang</th>
                    <th class="text-end">Harga Satuan</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php $totalItems = 0; ?>
                <?php if (!empty($detail)): ?>
                    <?php foreach ($detail as $d): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $d['nama_barang'] ?></td>
                            <td class="text-end">Rp <?= number_format($d['harga_barang'] ?? 0, 0, ',', '.') ?></td>
                            <td class="text-center"><?= $d['jumlah'] ?? 0 ?></td>
                            <td class="text-end">Rp <?= number_format($d['subtotal'] ?? 0, 0, ',', '.') ?></td>
                        </tr>
                        <?php $totalItems += $d['jumlah'] ?? 0; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada detail barang</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal Produk (<?= $totalItems ?> Item):</span>
                <span class="fw-normal">Rp <?= number_format($pesanan['subtotal'] ?? 0, 0, ',', '.') ?></span>
            </div>

            <div class="total-row text-danger">
                <span>Diskon:</span>
                <span class="fw-normal">- Rp <?= number_format($pesanan['diskon'] ?? 0, 0, ',', '.') ?></span>
            </div>

            <div class="total-row">
                <span>PPN (11%):</span>
                <span class="fw-normal">Rp <?= number_format($pesanan['ppn_amount'] ?? 0, 0, ',', '.') ?></span>
            </div>

            <div class="total-row">
                <span>Biaya Pengiriman (Ongkir):</span>
                <span class="fw-normal">Rp <?= number_format($pesanan['ongkir'] ?? 0, 0, ',', '.') ?></span>
            </div>

            <div class="total-row total-final">
                <span>Total Pembayaran Akhir:</span>
                <span>Rp <?= number_format($pesanan['total_harga'] ?? 0, 0, ',', '.') ?></span>
            </div>
        </div>

        <div class="text-center no-print">
            <button onclick="window.print()" class="btn btn-print me-2">
                <i class="fas fa-print me-2"></i>Cetak Invoice
            </button>

            <?php if (($pesanan['status'] ?? '') == 'Menunggu Pembayaran'): ?>
                <a href="<?= base_url('pembayaran/' . $pesanan['id_pesanan']) ?>" class="btn btn-action" style="background-color: #28a745;">
                    <i class="fas fa-money-check-alt me-2"></i>Lanjut Pembayaran
                </a>
            <?php elseif (($pesanan['status'] ?? '') == 'Selesai'): ?>
                <a href="<?= base_url('riwayat-pesanan') ?>" class="btn btn-action">
                    <i class="fas fa-list-alt me-2"></i>Riwayat Pesanan
                </a>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>
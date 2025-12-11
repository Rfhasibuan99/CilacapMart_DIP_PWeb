<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background-color: #f0f8ff; 
    }

    .container {
        max-width: 900px;
    }

    .payment-header {
        color: #003366;
        font-weight: bold;
        padding: 15px 0;
        border-bottom: 1px solid #dee2e6;
    }

    .qr-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 30px;
        margin-top: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .qr-code-box {
        width: 100%;
        max-width: 300px;
        height: auto;
        margin: 20px auto;
        border: 2px solid #ccc;
        padding: 10px;
        border-radius: 8px;
    }

    .qr-code-box img {
        width: 100%;
        height: auto;
    }

    .total-payment {
        margin-top: 20px;
        padding: 15px;
        background-color: #ffe0b2;
        border-radius: 8px;
        font-size: 1.5rem;
        font-weight: bold;
        color: #e65100;
    }

    .payment-instruction {
        margin-top: 30px;
        text-align: left;
        color: #555;
        font-size: 14px;
    }

    .payment-instruction ol {
        padding-left: 20px;
    }

    .btn-finish-payment {
        background-color: #28a745;
        color: #fff;
        padding: 12px;
        font-size: 18px;
        margin-top: 30px;
        border: none;
        border-radius: 6px;
        width: 100%;
        max-width: 300px;
        transition: background-color 0.3s;
    }

    .btn-finish-payment:hover {
        background-color: #218838;
    }
</style>

<div class="container py-4">
    <h3 class="payment-header">Pembayaran Pesanan</h3>

    <div class="qr-card">
        <i class="fas fa-qrcode" style="font-size: 2rem; color: #003366;"></i>
        <h4 class="mt-2 fw-bold">Bayar dengan QRIS</h4>
        <p class="text-secondary">Scan QR Code di bawah ini menggunakan aplikasi pembayaran favorit Anda.</p>

        <?php 
            
            $kodePesanan = $pesanan['kode_pesanan'] ?? '20250101';
            $totalFinal = $pesanan['total_harga'] ?? 0; 
            
            $qrData = "PembayaranQRIS-INV-" . $kodePesanan . "-Total-" . $totalFinal;
        ?>

        <div class="qr-code-box">
            <img 
                src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= urlencode($qrData) ?>" 
                alt="QR Code Pembayaran">
        </div>

        <div class="total-payment mx-auto" style="max-width: 300px;">
            Total: Rp <?= number_format($totalFinal, 0, ',', '.') ?>
        </div>

        <div class="payment-instruction">
            <h6 class="fw-bold">Cara Pembayaran QRIS:</h6>
            <ol>
                <li>Buka aplikasi pembayaran (Mobile Banking / E-Wallet) yang mendukung QRIS.</li>
                <li>Pilih menu *Scan* atau Pindai QR Code.</li>
                <li>Arahkan kamera ke QR Code di atas.</li>
                <li>Pastikan jumlah pembayaran yang muncul adalah Rp <?= number_format($totalFinal, 0, ',', '.') ?>.</li>
                <li>Konfirmasi pembayaran.</li>
            </ol>
        </div>

        <hr>

        <form action="<?= base_url('pesanan/update_status') ?>" method="post">
            
            <?= csrf_field() ?>

            <input type="hidden" name="id_pesanan" value="<?= $pesanan['id_pesanan'] ?? 0 ?>">
            
            <button type="submit" class="btn-finish-payment">
                Saya Sudah Bayar / Lanjut ke Invoice
            </button>
        </form>
        
        <a href="<?= base_url('pesanan/detail/' . ($pesanan['id_pesanan'] ?? 0)) ?>" class="text-danger mt-3 d-block">Lihat Detail Pesanan</a>
    </div>
</div>

<?= $this->endSection() ?>
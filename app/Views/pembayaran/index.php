<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<style>
    body { background-color: #f8f9fa; }
    .payment-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .payment-card:hover { border-color: #003366; background-color: #f7f9ff; }
    .payment-card.selected { border: 2px solid #003366; background-color: #e6f0ff; }
    .payment-logo { width: 50px; height: 50px; object-fit: contain; }
    .rincian-total { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
    .total-akhir { font-size: 1.5rem; color: #C0392B; font-weight: bold; }
    .btn-upload { background-color: #003366; color: #fff; padding: 10px 40px; border-radius: 6px; }
</style>

<div class="container py-4">
    <h3 class="fw-bold">Pembayaran Pesanan #<?= $pesanan['kode_pesanan'] ?></h3>
    <p class="text-secondary">Total tagihan: <span class="total-akhir">Rp <?= number_format($total_tagihan) ?></span></p>

    <div class="row mt-4">
        <!-- Kolom Kiri: Pilih Metode -->
        <div class="col-lg-6">
            <h5>Pilih Metode Pembayaran</h5>
            <form action="<?= base_url('/pembayaran/proses/' . $pesanan['id_pesanan']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                
                <div id="payment-methods">
                    <?php foreach($metode_pembayaran as $metode): ?>
                    <label class="payment-card" for="metode_<?= $metode['kode'] ?>">
                        <div class="d-flex align-items-center">
                            <input type="radio" name="metode_pembayaran" id="metode_<?= $metode['kode'] ?>" value="<?= $metode['kode'] ?>" class="form-check-input me-3" required>
                            <span class="fw-bold"><?= $metode['nama'] ?></span>
                        </div>
                        <img src="<?= base_url('img/' . $metode['gambar']) ?>" class="payment-logo" alt="<?= $metode['nama'] ?>">
                    </label>
                    <?php endforeach; ?>
                </div>

                <div class="card p-3 mt-4">
                    <label for="bukti_transfer" class="form-label fw-bold">Upload Bukti Pembayaran (Wajib)</label>
                    <!-- <input class="form-control" type="file" id="bukti_transfer" name="bukti_transfer" required> -->
                    <div class="alert alert-info mt-2">Simulasi: Setelah klik "Upload Bukti", status pesanan akan berubah menjadi "Menunggu Konfirmasi".</div>
                </div>

                <button type="submit" class="btn btn-upload w-100 mt-4">Upload Bukti Pembayaran</button>
            </form>
        </div>

        <!-- Kolom Kanan: Rincian Tagihan -->
        <div class="col-lg-6">
            <h5>Rincian Tagihan</h5>
            <div class="rincian-total">
                <p>Kode Pesanan: <b><?= $pesanan['kode_pesanan'] ?></b></p>
                <p>Status: <span class="badge bg-warning"><?= $pesanan['status'] ?></span></p>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Total Tagihan:</span>
                    <span class="total-akhir">Rp <?= number_format($total_tagihan) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle selected class pada metode pembayaran
        const radioButtons = document.querySelectorAll('input[name="metode_pembayaran"]');
        radioButtons.forEach(radio => {
            radio.closest('label').addEventListener('click', function() {
                document.querySelectorAll('.payment-card').forEach(card => {
                    card.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });

        // Pilih metode pertama secara default
        if (radioButtons.length > 0) {
            radioButtons[0].checked = true;
            radioButtons[0].closest('label').classList.add('selected');
        }
    });
</script>

<?= $this->endSection() ?>
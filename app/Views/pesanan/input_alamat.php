<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<style>
    body { background-color: #f0f8ff; }
    .container { max-width: 600px; }
    .card-alamat-input {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .btn-next {
        background-color: #003366; 
        color: #fff;
        font-size: 18px;
        padding: 12px;
        margin-top: 20px;
        border: none;
        border-radius: 8px;
        width: 100%;
        transition: background-color 0.3s;
    }
    .btn-next:hover {
        background-color: #002244;
    }
    .form-control:focus {
        border-color: #003366;
        box-shadow: 0 0 0 0.25rem rgba(0, 51, 102, 0.25);
    }
</style>
<form action="<?= base_url('/barang') ?>">
<button class="btn btn-back">
    Kembali
</button>
</form>
<div class="container py-5">
    <h3 class="fw-bold mb-4 text-center">Langkah 1: Input Alamat Pengiriman</h3>

    <div class="card-alamat-input">
        <form action="<?= base_url('pesanan/review') ?>" method="post">
            <?= csrf_field(); ?>
            
            <p class="text-secondary mb-4">Mohon isi data penerima dan alamat pengiriman dengan lengkap.</p>

            <div class="mb-3">
                <label for="penerima" class="form-label fw-bold">Nama Penerima</label>
                <input type="text" class="form-control" id="penerima" name="penerima" required value="<?= old('penerima_pesanan') ?? '' ?>">
            </div>

            <div class="mb-3">
                <label for="telp" class="form-label fw-bold">Nomor Telepon (Contoh: 08123456789)</label>
                <input type="tel" class="form-control" id="telp" name="telp" required value="<?= old('telp_pesanan') ?? '' ?>">
            </div>

            <div class="mb-4">
                <label for="alamat_lengkap" class="form-label fw-bold">Alamat Lengkap</label>
                <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="4" required><?= old('alamat_lengkap_pesanan') ?? '' ?></textarea>
            </div>

            <button type="submit" class="btn btn-next">
                Lanjut ke Konfirmasi Pesanan <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
            
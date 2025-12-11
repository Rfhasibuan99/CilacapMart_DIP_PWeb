<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background-color: #f0f8ff;
    }

    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-header {
        text-align: center;
        border-bottom: 2px solid #003366;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .form-title {
        color: #003366;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .form-control:focus {
        border-color: #003366;
        box-shadow: 0 0 0 0.25rem rgba(0, 51, 102, 0.25);
    }

    .btn-submit {
        background-color: #003366;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .btn-submit:hover {
        background-color: #002244;
        color: white;
    }
</style>

<div class="container py-5">
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">UBAH DETAIL PESANAN</h1>
            <p class="mb-0">Kode Pesanan: <strong><?= $pesanan['kode_pesanan'] ?></strong></p>
        </div>

        <form action="/pesanan/update/<?= $pesanan['id_pesanan']; ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT"> 
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_pesan" class="form-label">Tanggal Pesanan</label>
                        <input type="text" class="form-control" id="tanggal_pesan" value="<?= date('d/m/Y H:i', strtotime($pesanan['tanggal_pesan'])) ?>" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status Pesanan</label>
                        <select name="status" id="status" class="form-select">
                            <?php 
                                $statuses = ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
                                $currentStatus = old('status', $pesanan['status']);
                                foreach ($statuses as $status):
                            ?>
                                <option value="<?= $status ?>" <?= ($currentStatus == $status) ? 'selected' : '' ?>>
                                    <?= $status ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3 text-primary">Informasi Pengiriman</h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="penerima" class="form-label">Nama Penerima</label>
                        <input type="text" name="penerima" id="penerima" class="form-control" 
                               value="<?= old('penerima', $alamat['penerima'] ?? $pesanan['penerima_pesanan'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="telp" class="form-label">Nomor Telepon</label>
                        <input type="text" name="telp" id="telp" class="form-control" 
                               value="<?= old('telp', $alamat['telp'] ?? $pesanan['telp_pesanan'] ?? '') ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" class="form-control" required><?= old('alamat_lengkap_pesanan', $alamat['alamat_lengkap'] ?? $pesanan['alamat_lengkap_pesanan'] ?? '') ?></textarea>
            </div>

            <h5 class="mt-4 mb-3 text-primary">Ringkasan Pembayaran (Read-Only)</h5>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="total_harga" class="form-label">Total Harga Pesanan</label>
                        <input type="text" class="form-control" value="Rp <?= number_format($pesanan['total_harga'] ?? 0) ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <input type="text" class="form-control" value="<?= $metode_bayar ?? $pesanan['metode_pembayaran'] ?? 'N/A' ?>" readonly>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-5">
                <a href="/pesanan/detail/<?= $pesanan['id_pesanan']; ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Detail
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    .form-wrapper {
        max-width: 650px;
        margin: 40px auto; 
    }

    .form-card {
        background: #ffffff;
        padding: 25px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h3 {
        text-align: center;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .btn-primary {
        width: 100%;
        padding: 10px;
        font-weight: bold;
        font-size: 16px;
    }
</style>

<div class="container form-wrapper">

    <div class="form-card">

        <h3>Form Tambah Barang</h3>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <form action="/barang/simpan" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input 
                    type="text" 
                    name="nama_barang"
                    class="form-control <?= (session('errors.nama_barang')) ? 'is-invalid' : ''; ?>"
                    value="<?= old('nama_barang'); ?>"
                    required>
                <div class="invalid-feedback">
                    <?= session('errors.nama_barang') ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Barang / Makanan</label>
                <input 
                    type="text" 
                    name="jenis_barang"
                    class="form-control <?= (session('errors.jenis_barang')) ? 'is-invalid' : ''; ?>"
                    value="<?= old('jenis_barang'); ?>"
                    required>
                <div class="invalid-feedback">
                    <?= session('errors.jenis_barang') ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Beli</label>
                <input 
                    type="number" 
                    name="harga_beli"
                    class="form-control <?= (session('errors.harga_beli')) ? 'is-invalid' : ''; ?>"
                    value="<?= old('harga_beli'); ?>"
                    required>
                <div class="invalid-feedback">
                    <?= session('errors.harga_beli') ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Jual</label>
                <input 
                    type="number" 
                    name="harga_jual"
                    class="form-control <?= (session('errors.harga_jual')) ? 'is-invalid' : ''; ?>"
                    value="<?= old('harga_jual'); ?>"
                    required>
                <div class="invalid-feedback">
                    <?= session('errors.harga_jual') ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Stok Barang</label>
                <input 
                    type="number" 
                    name="stok"
                    class="form-control <?= (session('errors.stok')) ? 'is-invalid' : ''; ?>"
                    value="<?= old('stok'); ?>"
                    required>
                <div class="invalid-feedback">
                    <?= session('errors.stok') ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi Barang</label>
                <textarea 
                    name="deskripsi"
                    rows="3"
                    class="form-control <?= (session('errors.deskripsi')) ? 'is-invalid' : ''; ?>"
                    required><?= old('deskripsi'); ?></textarea>
                <div class="invalid-feedback">
                    <?= session('errors.deskripsi') ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Barang</label>
                <input 
                    type="file" 
                    name="gambar"
                    class="form-control <?= (session('errors.gambar')) ? 'is-invalid' : ''; ?>"
                    required>
                <div class="invalid-feedback">
                    <?= session('errors.gambar') ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Barang</button>

        </form>
    </div>
</div>

<?= $this->endSection(); ?>

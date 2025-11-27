<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="col">
        <h3 class="mt-2">Form Tambah Barang</h3>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <form action="/toko2/simpan" method="post" class="mt-4" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <!-- Nama Barang -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control <?= (session('errors.nama_barang')) ? 'is-invalid' : ''; ?>"
                        name="nama_barang"
                        value="<?= old('nama_barang'); ?>"
                        required>
                    <div class="invalid-feedback">
                        <?= session('errors.nama_barang') ?>
                    </div>
                </div>
            </div>

            <!-- Jenis Barang / Makanan -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Jenis Barang/Makanan</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control <?= (session('errors.jenis_barang')) ? 'is-invalid' : ''; ?>"
                        name="jenis_barang"
                        value="<?= old('jenis_barang'); ?>"
                        required>
                    <div class="invalid-feedback">
                        <?= session('errors.jenis_barang') ?>
                    </div>
                </div>
            </div>

            <!-- Harga Barang -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-4">
                    <input 
                        type="number" 
                        class="form-control <?= (session('errors.harga_beli')) ? 'is-invalid' : ''; ?>"
                        name="harga_beli"
                        value="<?= old('harga_beli'); ?>"
                        required>
                    <div class="invalid-feedback">
                        <?= session('errors.harga_beli') ?>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Harga Jual</label>
                <div class="col-sm-4">
                    <input 
                        type="number" 
                        class="form-control <?= (session('errors.harga_jual')) ? 'is-invalid' : ''; ?>"
                        name="harga_jual"
                        value="<?= old('harga_jual'); ?>"
                        required>
                    <div class="invalid-feedback">
                        <?= session('errors.harga_jual') ?>
                    </div>
                </div>
            </div>
            <!-- Stok Barang -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Stok Barang</label>
                <div class="col-sm-4">
                    <input 
                        type="number" 
                        class="form-control <?= (session('errors.stok')) ? 'is-invalid' : ''; ?>"
                        name="stok"
                        value="<?= old('stok'); ?>"
                        required>
                    <div class="invalid-feedback">
                        <?= session('errors.stok') ?>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Deskripsi Barang</label>
                <div class="col-sm-4">
                    <textarea 
                        class="form-control <?= (session('errors.deskripsi')) ? 'is-invalid' : ''; ?>"
                        name="deskripsi"
                        rows="3"
                        required><?= old('deskripsi'); ?></textarea>
                    <div class="invalid-feedback">
                        <?= session('errors.deskripsi') ?>
                    </div>
                </div>
            </div>

            <!-- Gambar -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Gambar</label>
                <div class="col-sm-4">
                    <input 
                        type="file" 
                        class="form-control <?= (session('errors.gambar')) ? 'is-invalid' : ''; ?>"
                        name="gambar"
                        required>
                    <div class="invalid-feedback">
                        <?= session('errors.gambar') ?>
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="form-group row">
                <div class="col-sm-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection(); ?>

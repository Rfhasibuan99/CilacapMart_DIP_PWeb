<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="col">
        <h3 class="mt-2">Form Tambah Toko</h3>

        <form action="/layout/simpan" method="post" class="mt-4" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <!-- Nama Toko -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Nama Toko</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control"
                        name="nama_toko"
                        value="<?= old('nama_toko'); ?>"
                        required>
                </div>
            </div>

            <!-- Alamat Toko -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Alamat Toko</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control"
                        name="alamat_toko"
                        value="<?= old('alamat_toko'); ?>"
                        required>
                </div>
            </div>

            <!-- Deskripsi Toko -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Deskripsi Toko</label>
                <div class="col-sm-4">
                    <textarea 
                        class="form-control"
                        name="deskripsi_toko"
                        rows="3"
                        required><?= old('deskripsi_toko'); ?></textarea>
                </div>
            </div>

            <!-- Gambar -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Gambar</label>
                <div class="col-sm-4">
                    <input 
                        type="file" 
                        class="form-control"
                        name="gambar"
                        required>
                </div>
            </div>

             <!-- Nomor telephone toko -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Nomor Telephone</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control"
                        name="nomor"
                        value="<?= old('nomor'); ?>"
                        required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Jam Pelayana</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control"
                        name="jam"
                        value="<?= old('jam'); ?>"
                        required>
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

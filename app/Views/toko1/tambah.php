<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="col">
        <h3 class="mt-2">Form Tambah Barang</h3>

        <form action="/toko1/simpan" method="post" class="mt-4" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <!-- Nama Barang -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control"
                        name="nama_barang"
                        value="<?= old('nama_barang'); ?>"
                        required>
                </div>
            </div>

            <!-- Jenis Barang / Makanan -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Jenis Barang/Makanan</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control"
                        name="jenis_barang"
                        value="<?= old('jenis_barang'); ?>"
                        required>
                </div>
            </div>

            <!-- Harga Barang -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Harga Barang</label>
                <div class="col-sm-4">
                    <input 
                        type="number" 
                        class="form-control"
                        name="harga_barang"
                        value="<?= old('harga_barang'); ?>"
                        required>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="form-group row mb-3">
                <label class="col-sm-2 col-form-label">Deskripsi Barang</label>
                <div class="col-sm-4">
                    <textarea 
                        class="form-control"
                        name="deskripsi"
                        rows="3"
                        required><?= old('deskripsi'); ?></textarea>
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

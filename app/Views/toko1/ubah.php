<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="col">
        <h3 class="mt-4">Form Ubah Barang</h3>

        <form action="/toko1/update/<?= $toko1['id_barang']; ?>" method="post" enctype="multipart/form-data" class="mt-4">
            <?= csrf_field(); ?>

            <input type="hidden" name="id_barang" value="<?= $toko1['id_barang']; ?>">
            <input type="hidden" name="gambarLama" value="<?= $toko1['gambar']; ?>">
            <input type="hidden" name="_method" value="PUT">

            <!-- NAMA BARANG -->
            <div class="form-group row mb-3">
                <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>" 
                        id="nama_barang" 
                        name="nama_barang" 
                        value="<?= old('nama_barang') ?: $toko1['nama_barang']; ?>"
                        autofocus>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_barang'); ?>
                    </div>
                </div>
            </div>

            <!-- JENIS MAKANAN -->
            <div class="form-group row mb-3">
                <label for="jenis_barang" class="col-sm-2 col-form-label">Jenis Makanan</label>
                <div class="col-sm-4">
                    <input 
                        type="text" 
                        class="form-control <?= ($validation->hasError('jenis_barang')) ? 'is-invalid' : ''; ?>" 
                        id="jenis_barang" 
                        name="jenis_barang" 
                        value="<?= old('jenis_barang') ?: $toko1['jenis_barang']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('jenis_barang'); ?>
                    </div>
                </div>
            </div>

            <!-- HARGA -->
            <div class="form-group row mb-3">
                <label for="harga_barang" class="col-sm-2 col-form-label">Harga Barang</label>
                <div class="col-sm-4">
                    <input 
                        type="number" 
                        class="form-control <?= ($validation->hasError('harga_barang')) ? 'is-invalid' : ''; ?>" 
                        id="harga_barang" 
                        name="harga_barang" 
                        value="<?= old('harga_barang') ?: $toko1['harga_barang']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('harga_barang'); ?>
                    </div>
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="form-group row mb-3">
                <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                <div class="col-sm-4">
                    <textarea 
                        class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>" 
                        id="deskripsi" 
                        name="deskripsi"><?= old('deskripsi') ?: $toko1['deskripsi']; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('deskripsi'); ?>
                    </div>
                </div>
            </div>

            <!-- GAMBAR -->
            <div class="form-group row mb-4">
                <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>

                <div class="col-sm-2">
                    <img src="/img/<?= $toko1['gambar']; ?>" class="img-thumbnail img-preview" style="width: 120px;">
                </div>

                <div class="col-sm-4">
                    <input 
                        type="file" 
                        class="form-control <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" 
                        id="gambar" 
                        name="gambar" 
                        onchange="previewImg()">
                    <div class="invalid-feedback">
                        <?= $validation->getError('gambar'); ?>
                    </div>
                </div>
            </div>

            <!-- BUTTON -->
            <div class="form-group row">
                <div class="col-sm-4 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection(); ?>

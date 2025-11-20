<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="col">
        <h3 class="mt-4">Form Ubah Toko</h3>

        <form action="/layout/update/<?= $layout['id_toko']; ?>" method="post" enctype="multipart/form-data" class="mt-4">
            <?= csrf_field(); ?>

            <input type="hidden" name="id_toko" value="<?= $layout['id_toko']; ?>">
            <input type="hidden" name="gambarLama" value="<?= $layout['gambar']; ?>">
            <input type="hidden" name="_method" value="PUT">

            <!-- NAMA TOKO -->
            <div class="form-group row mb-3">
                <label for="nama_toko" class="col-sm-2 col-form-label">Nama Toko</label>
                <div class="col-sm-4">
                    <input
                        type="text"
                        class="form-control <?= ($validation->hasError('nama_toko')) ? 'is-invalid' : ''; ?>"
                        id="nama_toko"
                        name="nama_toko"
                        value="<?= old('nama_toko') ?: $layout['nama_toko']; ?>"
                        autofocus>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama_toko'); ?>
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
                        name="deskripsi"><?= old('deskripsi') ?: $layout['deskripsi']; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('deskripsi'); ?>
                    </div>
                </div>
            </div>

            <!-- ALAMAT -->
            <div class="form-group row mb-3">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-4">
                    <input
                        type="text"
                        class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>"
                        id="alamat"
                        name="alamat"
                        value="<?= old('alamat') ?: $layout['alamat']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat'); ?>
                    </div>
                </div>
            </div>

            <!-- NOMOR -->
            <div class="form-group row mb-3">
                <label for="nomor" class="col-sm-2 col-form-label">Nomor</label>
                <div class="col-sm-4">
                    <input
                        type="text"
                        class="form-control <?= ($validation->hasError('nomor')) ? 'is-invalid' : ''; ?>"
                        id="nomor"
                        name="nomor"
                        value="<?= old('nomor') ?: $layout['nomor']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nomor'); ?>
                    </div>
                </div>
            </div>

            <!-- JAM -->
            <div class="form-group row mb-3">
                <label for="jam" class="col-sm-2 col-form-label">Jam</label>
                <div class="col-sm-4">
                    <input
                        type="text"
                        class="form-control <?= ($validation->hasError('jam')) ? 'is-invalid' : ''; ?>"
                        id="jam"
                        name="jam"
                        value="<?= old('jam') ?: $layout['jam']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('jam'); ?>
                    </div>
                </div>
            </div>

            <!-- GAMBAR -->
            <div class="form-group row mb-4">
                <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>

                <div class="col-sm-2">
                    <img src="/img/<?= $layout['gambar']; ?>" class="img-thumbnail img-preview" style="width: 120px;">
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


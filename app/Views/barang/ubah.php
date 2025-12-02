<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h3 class="text-center mb-4">Form Ubah Barang</h3>

                    <form action="/barang/update/<?= $barang['id_barang']; ?>" 
                          method="post" enctype="multipart/form-data">

                        <?= csrf_field(); ?>

                        <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
                        <input type="hidden" name="gambarLama" value="<?= $barang['gambar']; ?>">
                        <input type="hidden" name="_method" value="PUT">

     
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text"
                                   class="form-control <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>"
                                   name="nama_barang"
                                   value="<?= old('nama_barang') ?: $barang['nama_barang']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_barang'); ?>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Jenis Barang</label>
                            <input type="text"
                                   class="form-control <?= ($validation->hasError('jenis_barang')) ? 'is-invalid' : ''; ?>"
                                   name="jenis_barang"
                                   value="<?= old('jenis_barang') ?: $barang['jenis_barang']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenis_barang'); ?>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Harga Beli</label>
                            <input type="number"
                                   class="form-control <?= ($validation->hasError('harga_beli')) ? 'is-invalid' : ''; ?>"
                                   name="harga_beli"
                                   value="<?= old('harga_beli') ?: $barang['harga_beli']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('harga_beli'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Jual</label>
                            <input type="number"
                                   class="form-control <?= ($validation->hasError('harga_jual')) ? 'is-invalid' : ''; ?>"
                                   name="harga_jual"
                                   value="<?= old('harga_jual') ?: $barang['harga_jual']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('harga_jual'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number"
                                   class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>"
                                   name="stok"
                                   value="<?= old('stok') ?: $barang['stok']; ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('stok'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea
                                class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>"
                                name="deskripsi"
                                rows="3"><?= old('deskripsi') ?: $barang['deskripsi']; ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('deskripsi'); ?>
                            </div>
                        </div>


                        <div class="mb-4">
                            <label class="form-label">Gambar</label>
                            <div class="mb-2">
                                <img src="/img/<?= $barang['gambar']; ?>" 
                                     class="img-thumbnail img-preview" style="width: 120px;">
                            </div>

                            <input type="file"
                                   class="form-control <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>"
                                   id="gambar"
                                   name="gambar"
                                   onchange="previewImg()">

                            <div class="invalid-feedback">
                                <?= $validation->getError('gambar'); ?>
                            </div>
                        </div>


                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">Ubah</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>

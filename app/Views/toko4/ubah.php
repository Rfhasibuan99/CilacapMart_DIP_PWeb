<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
    footer {
    background-color: #003366; /* BIRU TUA */
    padding: 25px 50px;
    color: #ffffff; /* TEKS PUTIH */
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

footer h6 {
    font-weight: 700;
    margin-bottom: 8px;
    color: #ffffff;
}

footer a {
    color: #ffffff;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}
</style>
<div class="container">
    <div class="col">
        <h3 class="mt-4">Form Ubah Barang</h3>

        <form action="/toko4/update/<?= $toko4['id_barang']; ?>" method="post" enctype="multipart/form-data" class="mt-4">
            <?= csrf_field(); ?>

            <input type="hidden" name="id_barang" value="<?= $toko4['id_barang']; ?>">
            <input type="hidden" name="gambarLama" value="<?= $toko4['gambar']; ?>">
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
                        value="<?= old('nama_barang') ?: $toko4['nama_barang']; ?>"
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
                        value="<?= old('jenis_barang') ?: $toko4['jenis_barang']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('jenis_barang'); ?>
                    </div>
                </div>
            </div>

            <!-- HARGA -->
            <div class="form-group row mb-3">
                <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-4">
                    <input 
                        type="number" 
                        class="form-control <?= ($validation->hasError('harga_beli')) ? 'is-invalid' : ''; ?>" 
                        id="harga_beli" 
                        name="harga_beli" 
                        value="<?= old('harga_beli') ?: $toko1['harga_beli']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('harga_beli'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                <div class="col-sm-4">
                    <input 
                        type="number" 
                        class="form-control <?= ($validation->hasError('harga_jual')) ? 'is-invalid' : ''; ?>" 
                        id="harga_jual" 
                        name="harga_jual" 
                        value="<?= old('harga_jual') ?: $toko1['harga_jual']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('harga_jual'); ?>
                    </div>
                </div>

            <!-- DESKRIPSI -->
            <div class="form-group row mb-3">
                <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                <div class="col-sm-4">
                    <textarea 
                        class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>" 
                        id="deskripsi" 
                        name="deskripsi"><?= old('deskripsi') ?: $toko4['deskripsi']; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('deskripsi'); ?>
                    </div>
                </div>
            </div>

            <!-- GAMBAR -->
            <div class="form-group row mb-4">
                <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>

                <div class="col-sm-2">
                    <img src="/img/<?= $toko4['gambar']; ?>" class="img-thumbnail img-preview" style="width: 120px;">
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
<footer>
        <div>
            <h6>Layanan Pelanggan</h6>
            Bantuan<br>Lacak Pengiriman Penjual<br>Lacak Pesanan Pembeli<br>Hubungi Kami
        </div>
        <div>
            <h6>Jelajahi Cilacap Mart</h6>
            Tentang Kami<br>Seller Centre<br>Kontak Media
        </div>
        <div><h6>Pembayaran</h6></div>
        <div><h6>Pengiriman</h6></div>
    </footer>
<?= $this->endSection(); ?>

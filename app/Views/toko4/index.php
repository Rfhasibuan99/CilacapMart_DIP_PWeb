<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
    body {
        background-color: #E0F2FE; /* Biru muda */
        font-family: Arial, sans-serif;
    }

    .notif-box {
        background: white;
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-top: 30px;
    }

    .notif-item {
        background: #E0F2FE;
        border-left: 6px solid #0096C7;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .notif-title {
        font-weight: bold;
        color: #0096C7;
        margin-bottom: 5px;
    }

    .navbar-custom {
        background: white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .btn-primary {
        background: #0096C7;
        border: none;
        border-radius: 10px;
    }

    .btn-primary:hover {
        background: #0078A8;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top main-nav">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="../../../../logo.png" alt="Cilacap Mart Logo" class="me-2" width="100px">
                <span>Cilacap Mart</span>
            </a>

           <form action="<?= site_url('/toko4'); ?>" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Masukkan Pencarian Barang" name="cari" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <div class="d-flex align-items-center gap-3">
            <a href="/"><i class="bi bi-bag"></i></a>
            <a href="/"><i class="bi bi-cart fs-4"></i></a>
            <a href="/akun"><i class="bi bi-person-circle fs-4"></i></a>
        </div>
        </div>
    </nav>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Daftar Barang Toko</h2>
        
        <div class="container mt-3">
        <div class="row">
        <div class="col text-end">
            <a href="/toko4/tambah" class="btn btn-primary">Tambah Barang</a>
         </div>
        </div>
        </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Gambar </th>
                        <th scope="col">Barang</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($toko4 as $a): ?>
                <tr>
                    <th scope="row"><?= $i++; ?></th>
                    <td><img src="<?= base_url('img/'.$a['gambar']) ?>" alt="" width="80"></td>
                    <td><?= esc($a['nama_barang']); ?></td>
                    <td><?= esc($a['jenis_barang']); ?></td>
                    <td><?= esc($a['deksripsi']); ?></td>
                    <td><?= esc($a['harga_barang']); ?></td>
                    <td>
                     <a href="/toko4/ubah/<?= $a['id_barang']; ?>" class="btn btn-warning">Ubah</a>
                     <a href="/toko4/hapus/<?= $a['id_barang']; ?>" class="btn btn-danger">Hapus</a>
                     <a href="/toko4 <?= $a['id_barang']; ?>" class="btn btn-primary">Pesan</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </div>
    </div>
</div>
<!-- <div class="container mt-3">
    <div class="row">
        <div class="col text-end">
            <a href="/toko4/tambah" class="btn btn-primary">Tambah Barang</a>
        </div>
    </div>
</div> -->

<?= $this->endSection(); ?>
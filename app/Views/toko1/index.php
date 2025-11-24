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

           <form action="<?= site_url('/toko1'); ?>" method="get">
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
            <a href="/pesan"><i class="bi bi-bag"></i></a>
            <a href="/keranjang"><i class="bi bi-cart fs-4"></i></a>
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
            <!-- <a href="layout/ubah" class="btn btn-secondary">Ubah Toko</a> -->
            <a href="/toko1/tambah" class="btn btn-primary">Tambah Barang</a>
         </div>
        </div>
        </div>

             <!-- CARD DETAIL PRODUK -->
        <div class="col-md-12">
            <?php foreach ($toko1 as $a): ?>
            <div class="card shadow-sm p-3 mb-4">

                <div class="row g-4">
                    <!-- GAMBAR PRODUK -->
                    <div class="col-md-5 text-center">
                        <img 
                            src="<?= base_url('img/' . $a['gambar']) ?>" 
                            onerror="this.src='https://via.placeholder.com/350x350?text=No+Image'"
                            class="img-fluid rounded border"
                            style="max-height: 350px; object-fit: cover;"
                        >
                    </div>

                    <!-- DETAIL PRODUK -->
                    <div class="col-md-7">

                        <h4 class="fw-bold mb-2"><?= $a['nama_barang']; ?></h4>

                        <h5 class="text-danger fw-bold mb-3">
                            Rp <?= number_format($a['harga_jual'], 0, ',', '.'); ?>
                        </h5>

                        <div class="mb-3">
                            <span class="text-muted">Harga Asli: </span>
                            <span class="text-decoration-line-through">
                                Rp <?= number_format($a['harga_beli'], 0, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="mb-3">
                            <span class="fw-bold">Stok:</span> 
                            <?= $a['stok']; ?> barang
                        </div>

                        <div class="mb-3">
                            <span class="fw-bold">Deskripsi Produk:</span>
                            <p class="mt-1"><?= $a['deskripsi']; ?></p>
                        </div>

                        <!-- BUTTON AKSI -->
                        <div class="d-flex gap-3 mt-4">

                            <a href="/keranjang/<?= $a['id_barang']; ?>" class="btn btn-warning px-4">
                                Tambah ke Keranjang
                            </a>                        
                                <a href="<?= base_url('/pesan/' . $a['id_barang']) ?>" class="btn btn-warning px-4">
                                    pesan sekarang
                                </a>

                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
</div>
<!-- <div class="container mt-3">
    <div class="row">
        <div class="col text-end">
            <a href="/toko1/tambah" class="btn btn-primary">Tambah Barang</a>
        </div>
    </div>
</div> -->

<?= $this->endSection(); ?>
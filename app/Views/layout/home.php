<?= $this->extend('layout/template') ?>
<?= $this->section('content'); ?>
<style>
    body {
        background-color: #E0F2FE;
        /* Biru muda */
    }

    /* ====== NAVBAR ======= */
    .main-nav {
        background-color: #0096C7 !important;
        /* Biru utama */
    }

    .navbar-brand span {
        color: white !important;
        font-weight: 600;
    }

    .navbar-brand img {
        border-radius: 10px;
    }

    /* Icon kanan di navbar */
    .main-nav a i {
        color: white !important;
        font-size: 1.4rem;
    }

    .main-nav a:hover i {
        color: #E0F2FE !important;
    }

    /* ====== SEARCH ======= */
    .input-group .form-control {
        border-color: #0096C7;
    }

    .input-group .btn {
        background-color: #0096C7;
        color: white;
        border-color: #0096C7;
    }

    .input-group .btn:hover {
        background-color: #007aa1;
    }

    /* ====== CARD TOKO ======= */
    .card {
        border: none;
        background: white;
        border-left: 5px solid #0096C7;
        transition: 0.2s;
    }

    .card:hover {
        transform: scale(1.02);
    }

    /* Judul toko */
    h4 {
        color: #0096C7;
        font-weight: 700;
    }

    /* Isi teks card */
    .card-body p {
        color: #003049;
    }

    /* Tombol detail toko */
    .btn-primary {
        background-color: #0096C7;
        border-color: #0096C7;
    }

    .btn-primary:hover {
        background-color: #007aa1;
    }
    /* Card Produk */
    .card {
        background: white;
        border-radius: 15px;
        transition: 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
    }

    .carousel-item img {
        height: 350px;
        /* Atur tinggi gambar */
        object-fit: cover;
        /* Agar gambar tidak ketarik */
        border-radius: 20px;
        /* Sudut membulat */
        border: 4px solid #0096C7;
        /* Border biru */
    }

    #carouselExampleCaptions {
        padding: 20px;
    }

    .carousel-inner {
        padding: 0 40px;
    }

    /* Pastikan ini ada di file CSS Anda setelah Bootstrap */
    .category-item:hover .card {
        /* Efek hover opsional, mirip dengan Shopee */
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }

    .category-icon {
        /* Membuat ikon/gambar kategori menjadi lingkaran */
        width: 60px;
        /* Sesuaikan ukuran */
        height: 60px;
        /* Sesuaikan ukuran */
        object-fit: cover;
        border-radius: 50%;
        /* Membuat gambar menjadi bulat */
        border: 1px solid #eee;
        /* Garis tepi tipis opsional */
    }

    /* Sesuaikan tampilan card agar lebih ringan */
    .card {
        transition: all 0.2s ease-in-out;
    }
</style>
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../../../../img/slide1.jpg" class="d-block w-100">
        </div>
        <div class="carousel-item">
            <img src="../../../../img/slide2.jpg" class="d-block w-100">
        </div>
        <div class="carousel-item">
            <img src="../../../../img/slide3.jpg" class="d-block w-100">
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- JS Bootstrap WAJIB -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</div>
<div class="container my-4">
    <h2 class="mb-3">KATEGORI</h2>
    <div class="row row-cols-3 row-cols-sm-4 row-cols-md-6 row-cols-lg-8 g-2 g-md-3 category-grid">

<div class="col">
    <a href="/barang?cari=Minuman" class="category-item text-decoration-none text-dark">
        <div class="card text-center h-100 shadow-sm border-0">
            <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                <img src="/img/Minuman.jpg" class="img-fluid category-icon" alt="Minuman">
                <small class="mt-2 fw-medium">Minuman</small>
            </div>
        </div>
    </a>
</div>

<div class="col">
    <a href="/barang?cari=Makanan" class="category-item text-decoration-none text-dark">
        <div class="card text-center h-100 shadow-sm border-0">
            <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                <img src="/img/Makanan.jpg" class="img-fluid category-icon" alt="Makanan">
                <small class="mt-2 fw-medium">Makanan</small>
            </div>
        </div>
    </a>
</div>

<div class="col">
    <a href="/barang?cari=Fashion" class="category-item text-decoration-none text-dark">
        <div class="card text-center h-100 shadow-sm border-0">
            <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                <img src="/img/Fashion.jpg" class="img-fluid category-icon" alt="Fashion">
                <small class="mt-2 fw-medium">Fashion</small>
            </div>
        </div>
    </a>
</div>

<div class="col">
    <a href="/barang?cari=Barang Kerajinan" class="category-item text-decoration-none text-dark">
        <div class="card text-center h-100 shadow-sm border-0">
            <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                <img src="/img/BarangKerajinan.jpg" class="img-fluid category-icon" alt="Barang Kerajinan">
                <small class="mt-2 fw-medium">Barang Kerajinan</small>
            </div>
        </div>
    </a>
</div>

<div class="col">
    <a href="/barang?cari=Accessories" class="category-item text-decoration-none text-dark">
        <div class="card text-center h-100 shadow-sm border-0">
            <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                <img src="/img/Accesories.jpg" class="img-fluid category-icon" alt="Accessories">
                <small class="mt-2 fw-medium">Accessories</small>
            </div>
        </div>
    </a>
</div>

<div class="col">
    <a href="/barang?cari=Bahan Baku" class="category-item text-decoration-none text-dark">
        <div class="card text-center h-100 shadow-sm border-0">
            <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                <img src="/img/BahanBaku.jpg" class="img-fluid category-icon" alt="Bahan Baku">
                <small class="mt-2 fw-medium">Bahan Baku</small>
            </div>
        </div>
    </a>
</div>


    </div>

</div>

<div class="container mt-4">
    <h1 class="fw-bold text-primary mb-4">Rekomendasi Barang/Makanan</h1>

    <?php if (in_groups('admin')): ?>
        <div class="text-end mb-3">
            <a href="/barang/tambah" class="btn btn-primary">Tambah Barang</a>
        </div>
    <?php endif; ?>

    <!-- GRID 4 KOLOM -->
    <div class="row g-4">
        <?php foreach ($barang as $b): ?>

            <div class="col-6 col-md-4 col-lg-3"> <!-- 4 kolom di desktop -->
                <div class="card shadow-sm h-100 border-0" style="border-radius: 15px;">

                    <!-- GAMBAR PRODUK -->
                    <img src="<?= base_url('img/' . $b['gambar']) ?>"
                        onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'"
                        class="card-img-top"
                        style="height: 220px; object-fit: cover; border-radius: 15px 15px 0 0;">

                    <div class="card-body text-center">
                        <h5 class="fw-bold text-dark">
                            <?= $b['nama_barang']; ?>
                        </h5>
                        <a href="/barang/detail/<?= $b['id_barang']; ?>" class="btn btn-warning">Detail Produk</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="text-end mt-3">
                <button class="btn btn-outline-secondary btn-sm" onclick="window.location.href='/barang'">Lihat Semua Barang</button>
            </div>
</div>
</div>
</div>
<?= $this->endSection(); ?>
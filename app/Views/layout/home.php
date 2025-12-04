<?= $this->extend('layout/template') ?>
<?= $this->section('content'); ?>

<style>
    body {
        background-color: #E8EFF7; /* biru muda sesuai desain */
    }

    /* ====== NAVBAR ======= */
    .main-nav {
        background-color: #003B73 !important; /* biru tua desain */
    }

    .navbar-brand span {
        color: white !important;
        font-weight: 600;
    }

    .navbar-brand img {
        border-radius: 10px;
    }

    /* Icon navbar kanan */
    .main-nav a i {
        color: white !important;
        font-size: 1.4rem;
    }

    .main-nav a:hover i {
        color: #E8EFF7 !important;
    }

    /* ====== SEARCH ======= */
    .input-group .form-control {
        border-color: #003B73;
    }

    .input-group .btn {
        background-color: #003B73;
        color: white;
        border-color: #003B73;
    }

    .input-group .btn:hover {
        background-color: #002b55;
    }

    /* ====== CARD ======= */
    .card {
        background: #FFFFFF;
        border-left: 5px solid #003B73; 
        border-radius: 12px;
        transition: 0.2s;
    }

    .card:hover {
        transform: scale(1.02);
    }

    /* Judul section */
    h2, h1 {
        color: #003B73;
        font-weight: 700;
    }

    /* Teks isi card */
    .card-body p {
        color: #2D2D2D;
    }

    /* Carousel */
    .carousel-item img {
        height: 350px;
        object-fit: cover;
        border-radius: 20px;
        border: 4px solid #003B73;
    }

    #carouselExampleCaptions {
        padding: 20px;
    }

    .carousel-inner {
        padding: 0 40px;
    }

    /* Kategori */
    .category-item:hover .card {
        transform: translateY(-3px);
    }

    .category-icon {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #ccc;
    }

    .card {
        transition: all 0.2s ease-in-out;
    }
</style>


<!-- ========================= CAROUSEL ========================= -->
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


<!-- ========================= KATEGORI ========================= -->
<div class="container my-4">
    <h2 class="mb-3">Kategori</h2>

    <div class="row row-cols-3 row-cols-sm-4 row-cols-md-6 row-cols-lg-8 g-2 g-md-3 category-grid">

        <?php
        $kategori = [
            ["Minuman", "Minuman.jpg"],
            ["Makanan", "Makanan.jpg"],
            ["Fashion", "Fashion.jpg"],
            ["Barang Kerajinan", "BarangKerajinan.jpg"],
            ["Accessories", "Accesories.jpg"],
            ["Bahan Baku", "BahanBaku.jpg"]
        ];

        foreach ($kategori as $k): ?>
            <div class="col">
                <a href="/barang?cari=<?= $k[0] ?>" class="category-item text-decoration-none text-dark">
                    <div class="card text-center h-100 shadow-sm border-0">
                        <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                            <img src="/img/<?= $k[1] ?>" class="img-fluid category-icon" alt="<?= $k[0] ?>">
                            <small class="mt-2 fw-medium"><?= $k[0] ?></small>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>


<!-- ========================= PRODUK ========================= -->
<div class="container mt-4">
    <h1 class="fw-bold mb-4">Rekomendasi Barang/Makanan</h1>

    <?php if (in_groups('admin')): ?>
        <div class="text-end mb-3">
            <a href="/barang/tambah" class="btn btn-primary">Tambah Barang</a>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php foreach ($barang as $b): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card shadow-sm h-100 border-0" style="border-radius: 15px;">
                    <img src="<?= base_url('img/' . $b['gambar']) ?>"
                        onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'"
                        class="card-img-top"
                        style="height: 220px; object-fit: cover; border-radius: 15px 15px 0 0;">

                    <div class="card-body text-center">
                        <h5 class="fw-bold text-dark"><?= $b['nama_barang']; ?></h5>
                        <a href="/barang/detail/<?= $b['id_barang']; ?>" class="btn btn-warning">Detail Produk</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-end mt-3">
        <button class="btn btn-outline-secondary btn-sm" onclick="window.location.href='/barang'">
            Lihat Semua Barang
        </button>
    </div>
</div>

<?= $this->endSection(); ?>

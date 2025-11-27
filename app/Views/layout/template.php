<!doctype html>
<html lang="en">
<style>
    /* --- HEADER STYLE --- */

    .main-nav {
        background-color: #0096C7;
    }

    .header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
    }

    /* LOGO */
    .logo-text {
        font-size: 24px;
        font-weight: bold;
        color: white;
    }

    /* SEARCH */
    .search-area {
        flex: 1;
        max-width: 650px;
    }

    .search-area input {
        border: 1px solid #90E0EF;
    }

    .search-btn {
        background-color: #E0F2FE;
        color: #0096C7;
        border: 1px solid #90E0EF;
        font-weight: bold;
    }

    .search-btn:hover {
        background-color: white;
        color: #0096C7;
    }

    /* ICON GROUP */
    .icon-link {
        color: white;
        font-size: 28px;
        margin-left: 22px;
        transition: 0.2s ease;
    }

    .icon-link:hover {
        color: #E0F2FE;
    }

</style>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cilacap Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="../../../../logo.png" type="image/png">
</head>

<body>
    <header>

    <!-- TOP BAR -->
    <div class="top-bar bg-white py-2 border-bottom d-none d-lg-block">
        <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
            <div>
                <a href="https://wa.me/qr/Q2XTFOSZCJXAJ1">Call Center</a>
                <a href="#">Download</a>
                <span>Ikuti Kami di
                    <a href="https://www.facebook.com/rio.pernandes.90?mibextid=ZbWKwL"><i class="bi bi-facebook ms-1"></i></a>
                    <a href="https://www.instagram.com/fernans_rh?igsh=eXUxcGsxejd1enln"><i class="bi bi-instagram ms-1"></i></a>
                    <a href="#"><i class="bi bi-twitter-x ms-1"></i></a>
                </span>
            </div>

            <div class="d-flex align-items-center">
                <a href="/notifikasi"><i class="bi bi-bell me-1"></i> Notifikasi</a>
                <a href="#"><i class="bi bi-question-circle me-1"></i> Bantuan</a>

                <div class="dropdown">
                    <span class="dropdown-toggle text-secondary" data-bs-toggle="dropdown">
                        Bahasa Indonesia
                    </span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Bahasa Indonesia</a></li>
                        <li><a class="dropdown-item" href="#">English</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN NAV (LOGO - SEARCH - ICONS) -->
    <div class="main-nav container-fluid px-4 py-2">
        <div class="header-row">

            <!-- LOGO -->
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="../../../../logo.png" width="90" class="me-2">
                <span class="logo-text">Cilacap Mart</span>
            </a>

            <!-- SEARCH -->
            <form action="<?= site_url('/'); ?>" method="get" class="search-area">
                <div class="input-group">
                    <input type="text" class="form-control" name="cari" placeholder="Masukkan Pencarian Barang">
                    <button class="btn search-btn" type="submit">Cari</button>
                </div>
            </form>

            <!-- ICONS -->
            <div class="icon-group d-flex align-items-center">
                <a href="/pesanan" class="icon-link"><i class="bi bi-bag"></i></a>
                <a href="/keranjang/index" class="icon-link"><i class="bi bi-cart"></i></a>
                <a href="/akun" class="icon-link"><i class="bi bi-person-circle"></i></a>
            </div>
        </div>
    </div>

</header>


    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cilacap Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" href="../../../../logo.png" type="image/png">

    <style>
        /* Definisikan warna Biru Navy */
        :root {
            --navy-blue: #003366;
            --light-blue: #ADD8E6;
        }

        /* --- STICKY FOOTER CSS --- */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content-wrapper {
            flex: 1;
        }
        
        /* --- TOP BAR STYLE (Perbaikan Alignment Notifikasi & Item Lain) --- */
        .top-bar .container-fluid {
            align-items: center; 
        }

        /* Style untuk grup link di sebelah kiri top-bar */
        .top-bar .left-links > span {
            margin-right: 15px;
        }
        
        /* Style untuk grup link di sebelah kanan top-bar */
        .top-bar .right-links {
            display: flex;
            align-items: center; 
        }

        /* Atur jarak antar item di kanan */
        .top-bar .right-links > span {
            margin-left: 15px;
        }
        
        /* --- HEADER STYLE (Navbar Utama) --- */
        .main-nav {
            background-color: var(--navy-blue);
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
            white-space: nowrap; /* Mencegah teks 'Cilacap Mart' pecah baris */
        }

        /* SEARCH */
        .search-area {
            flex: 1;
            max-width: 650px;
        }

        .search-area input {
            border: 1px solid var(--light-blue);
        }

        .search-btn {
            background-color: var(--light-blue);
            color: var(--navy-blue);
            border: 1px solid var(--light-blue);
            font-weight: bold;
            transition: 0.2s ease;
        }

        .search-btn:hover {
            background-color: white;
            color: var(--navy-blue);
        }

        /* ICON GROUP: Rapi dan Sejajar */
        .icon-group {
            display: flex;
            align-items: center; 
            min-width: 150px; 
            justify-content: flex-end;
        }

        .icon-link {
            color: white;
            font-size: 28px;
            margin-left: 15px; /* Margin diperkecil agar lebih rapi */
            transition: 0.2s ease;
        }

        .icon-link:hover {
            color: var(--light-blue);
        }

        /* --- PRODUCT CARD STYLE (Interaktif) --- */
        .product-card {
            background-color: white;
            cursor: pointer;
            text-align: center;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            width: 100%;
            border: 1px solid #dee2e6;
        }

        .product-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-3px);
        }

        .product-card:active {
            transform: translateY(0);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.075) !important;
        }

        .product-card h5,
        .product-card p {
            color: inherit;
            margin-bottom: 0;
        }

        /* --- FOOTER STYLE --- */
        footer {
            flex-shrink: 0;
            background-color: var(--navy-blue);
            padding: 25px 50px;
            color: #ffffff;
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
    </style>
</head>

<body>

    <div class="main-content-wrapper">
        <header>
            <div class="top-bar bg-white py-2 border-bottom d-none d-lg-block">
                <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
                    <div class="left-links">
                        <span><a href="https://wa.me/qr/Q2XTFOSZCJXAJ1" class="text-decoration-none text-dark me-3">Call Center</a></span>
                        <span><a href="#" class="text-decoration-none text-dark me-3">Download</a></span>
                        <span>Ikuti Kami di
                            <a href="https://www.facebook.com/rio.pernandes.90?mibextid=ZbWKwL" class="text-decoration-none text-dark"><i class="bi bi-facebook ms-1"></i></a>
                            <a href="https://www.instagram.com/annisaaf._/" class="text-decoration-none text-dark"><i class="bi bi-instagram ms-1"></i></a>
                            <a href="https://x.com/aafdila8802?s=11" class="text-decoration-none text-dark"><i class="bi bi-twitter-x ms-1"></i></a>
                        </span>
                    </div>

                    <div class="right-links">
                        <span><a href="/chat" class="text-decoration-none text-dark"><i class="bi bi-bell me-1"></i>Notifikasi</a></span>
                        <span><a href="#" class="text-decoration-none text-dark"><i class="bi bi-question-circle me-1"></i>Bantuan</a></span>
                        <span id="dropdown-trigger" class="dropdown" style="cursor: pointer;">
                            <i class="bi bi-globe2"></i> Bahasa Indonesia <i class="bi bi-caret-down-fill ms-1"></i>
                            <ul id="dropdown-menu" class="dropdown-menu position-absolute" style="display: none;">
                                <li><a class="dropdown-item" href="#">Bahasa Indonesia</a></li>
                                <li><a class="dropdown-item" href="#">English</a></li>
                            </ul>
                        </span>
                    </div>
                </div>
            </div>

            <div class="main-nav container-fluid px-4 py-2">
                <div class="header-row">

                    <a class="navbar-brand d-flex align-items-center" href="/">
                        <img src="../../../../logo.png" width="90" class="me-2">
                        <span class="logo-text">Cilacap Mart</span>
                    </a>

                    <form action="<?= site_url('/'); ?>" method="get" class="search-area">
                        <div class="input-group">
                            <input type="text" class="form-control" name="cari" placeholder="Masukkan Pencarian Barang">
                            <button class="btn search-btn" type="submit">Cari</button>
                        </div>
                    </form>

                    <div class="icon-group d-flex align-items-center">
                        <a href="<?= base_url('pesanan'); ?>" class="icon-link">
                            <i class="bi bi-bag"></i>
                        </a>

                        <a href="<?= base_url('keranjang'); ?>" class="icon-link">
                            <i class="bi bi-cart"></i>
                        </a>

                        <a href="/akun" class="icon-link"><i class="bi bi-person-circle"></i></a>
                    </div>
                </div>
            </div>
        </header>

        <?= $this->renderSection('content') ?>
    </div>
    </div>

    <footer>
        <div>
            <h6>Layanan Pelanggan</h6>
            <a href="/saran">Bantuan</a><br>Hubungi Kami
        </div>
        <div>
            <h6>Jelajahi Cilacap Mart</h6>
            <a href="/layout/about">Tentang Kami</a><br>
            <a href="https://wa.me/qr/BQX4QH6QIARLH1">Call Center</a><br>
            <a href="https://www.instagram.com/annisaaf._/">Kontak Media</a>
        </div>
        <div>
            <h6>Pembayaran</h6>
            <img src="img/bni.png" alt="Logo Bank BNI" class="img-fluid bni-logo" width="80"><br>
            <img src="img/bri.png" alt="Logo BRI" class="img-fluid bri-logo" width="80"><br>
            <img src="img/bca.jpg" alt="Logo bca" class="img-fluid bca-logo" width="80">
        </div>
        <div>
            <h6>Pengiriman</h6>
            <img src="img/jne.jpg" alt="Logo JNE" class="img-fluid jne-logo" width="80"><br>
            <img src="img/grab.jpg" alt="Logo Grab" class="img-fluid grab-logo" width="80"><br>
            <img src="img/gojek.jpg" alt="Logo Gojek" class="img-fluid gojek-logo" width="80">
        </div>
    </footer>
    <script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js"></script>

</body>

</html>
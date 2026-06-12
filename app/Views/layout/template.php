<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cilacap Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="../../../../logo.png" type="image/png">

    <style>
        :root {
            --navy-blue: #003366;
            --light-blue: #ADD8E6;
        }

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

        .main-nav {
            background-color: var(--navy-blue);
        }

        .header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: white;
            white-space: nowrap;
        }

        .custom-search-input {
            height: 40px;
        }

        .icon-link {
            color: white;
            font-size: 28px;
            margin-left: 15px;
            transition: 0.2s ease;
        }

        .icon-link:hover {
            color: var(--light-blue);
        }

        /* --- STYLING FOOTER --- */
        footer {
            flex-shrink: 0;
            background-color: var(--navy-blue);
            padding: 40px 0 20px 0;
            color: #ffffff;
        }

        footer h6 {
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        footer ul li a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            transition: 0.3s;
        }

        footer ul li a:hover {
            color: #ffffff;
        }

        /* Logo Styling Tanpa Background */
        .footer-logo {
            height: 28px;
            width: auto;
            margin-right: 15px;
            margin-bottom: 10px;
            object-fit: contain;
            background: none !important; /* Tanpa background */
            filter: none !important;     /* Tanpa filter agar warna asli keluar */
            transition: 0.3s;
        }

        .footer-logo:hover {
            transform: scale(1.1);
        }

        img[alt="BCA"] {
            height: 20px; /* Ukuran khusus BCA agar seimbang */
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
    <div class="main-content-wrapper">
        <header>
            <div class="main-nav container-fluid px-4 py-3">
                <div class="header-row">
                    <a class="navbar-brand d-flex align-items-center" href="/">
                        <img src="../../../../logo.png" width="80" class="me-2" alt="Logo">
                        <span class="logo-text">Cilacap Mart</span>
                    </a>

                    <form action="/barang" method="GET" class="d-flex flex-grow-1 mx-5" role="search">
                        <input class="form-control me-2 custom-search-input" type="search" name="cari" placeholder="Cari barang...">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </form>

                    <div class="icon-group d-flex">
                        <a href="<?= base_url('pesanan'); ?>" class="icon-link"><i class="bi bi-bag"></i>
                        </a>
                        <a href="<?= base_url('keranjang'); ?>" class="icon-link"><i class="bi bi-cart"></i></a>
                        <a href="<?= base_url('akun') ?>" class="icon-link"><i class="bi bi-person-circle"></i></a>
                    </div>
                </div>
            </div>
        </header>

        <main class="container my-5">
                <?= $this->rendersection('content'); ?>
            </main>
    </div>
    <footer>
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-6 col-md-3 mb-4">
                    <h6>Layanan Pelanggan</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Bantuan</a></li>
                        <li class="mb-2"><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <h6>Jelajahi</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/layout/about">Tentang Kami</a></li>
                        <li><a href="/saran">Saran/Masukan</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-3 mb-4">
                    <h6>Pembayaran</h6>
                    <div class="d-flex flex-wrap align-items-center">
                        <img src="../../../../bni.png" alt="BNI" class="footer-logo">
                        <img src="../../../../bri.png" alt="BRI" class="footer-logo">
                        <img src="../../../../bca.jpg" alt="BCA" class="footer-logo" width="500px">
                    </div>
                </div>

                <div class="col-12 col-md-3 mb-4">
                    <h6>Pengiriman</h6>
                    <div class="d-flex flex-wrap align-items-center">
                        <img src="../../../../jne.jpg" alt="JNE" class="footer-logo">
                        <img src="../../../../grab.jpg" alt="Grab" class="footer-logo">
                        <img src="../../../../gojek.jpg" alt="Gojek" class="footer-logo">
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <small class="text-white-50">&copy; 2026 Cilacap Mart. Semua Hak Dilindungi.</small>
            </div>
        </div>
    </footer>

</body>

</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cilacap Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="../../../../logo.png">
</head>

<body>
    <header>
        <div class="top-bar bg-white py-2 border-bottom d-none d-lg-block">
            <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
                <div>
                    <a href="https://wa.me/qr/Q2XTFOSZCJXAJ1">Call Center</a>
                    <a href="#">Download</a>
                    <span>Ikuti Kami di
                        <a href="https://www.facebook.com/rio.pernandes.90?mibextid=ZbWKwL" class="ms-1 me-0"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/fernans_rh?igsh=eXUxcGsxejd1enln" class="ms-1 me-0"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="ms-1 me-0"><i class="bi bi-twitter-x"></i></a>
                    </span>
                </div>

                <div class="d-flex align-items-center">
                    <a href="/notifikasi"><i class="bi bi-bell me-1"></i> Notifikasi</a>
                    <a href="#"><i class="bi bi-question-circle me-1"></i> Bantuan</a>
                    <div class="dropdown">
                        <span class="dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
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
    </header>

    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
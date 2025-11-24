<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ? $this->renderSection('title') : 'CilacapMart Admin' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        #sidebar {
            min-height: 100vh;
        }
        .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-dark text-white p-3 shadow-lg">
        <h2 class="text-white text-center mb-4 border-bottom pb-3">
            <span class="text-primary">Admin</span>
        </h2>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white active rounded-3" href="/admin">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white rounded-3" href="/admin/pesanan">
                    <i class="bi bi-box-seam me-2"></i> Produk
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white rounded-3" href="/admin/orders">
                    <i class="bi bi-cart-check me-2"></i> Pesanan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white rounded-3" href="#">
                    <i class="bi bi-people me-2"></i> Pengguna
                </a>
            </li>
        </ul>
        <div class="mt-auto pt-3 border-top">
            <a class="btn btn-outline-danger w-100" href="/admin/logout">Logout</a>
        </div>
    </div>
    <!-- Konten Utama -->
<?= $this->extend('layout/template'); ?>

<?= $this->section('title'); ?>
<h2 class="mb-4">Dashboard Admin</h2>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="p-4 bg-white rounded shadow-sm">
        <h4>Selamat datang di Dashboard Admin</h4>
        <p>Gunakan menu di sidebar untuk mengelola data.</p>
    </div>
</div>
<?= $this->endSection(); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

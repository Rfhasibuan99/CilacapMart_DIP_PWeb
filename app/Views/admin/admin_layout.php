<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">
    <div id="sidebar" class="bg-dark text-white p-3" style="min-height:100vh;">
        <h3 class="pb-3 border-bottom mb-3">Admin Panel</h3>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="/admin" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="/admin/pesanan" class="nav-link text-white">Pesanan</a></li>
        </ul>
    </div>

    <div id="content" class="p-4 flex-grow-1">
        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

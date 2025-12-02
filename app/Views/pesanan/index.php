<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h3>Daftar Pesanan</h3>

<table class="table table-striped">
<tr>
    <th>Kode</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php foreach($pesanan as $p): ?>
<tr>
    <td><?= $p['kode_pesanan'] ?></td>
    <td><?= $p['tanggal_pesan'] ?></td>
    <td><?= number_format($p['total_harga']) ?></td>
    <td><?= $p['status'] ?></td>
    <td>
        <a href="/pesanan/detail/<?= $p['id_pesanan'] ?>" class="btn btn-sm btn-primary">Detail</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>

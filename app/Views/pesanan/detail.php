<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h3>Detail Pesanan</h3>

<p><b>Kode:</b> <?= $pesanan['kode_pesanan'] ?></p>
<p><b>Status:</b> <?= $pesanan['status'] ?></p>

<table class="table table-bordered">
<tr class="table-dark">
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Subtotal</th>
</tr>

<?php foreach($detail as $d): ?>
<tr>
    <td><?= $d['nama_barang'] ?></td>
    <td><?= number_format($d['harga']) ?></td>
    <td><?= $d['jumlah'] ?></td>
    <td><?= number_format($d['subtotal']) ?></td>
</tr>
<?php endforeach; ?>

</table>

<a href="/pembayaran/<?= $pesanan['id_pesanan'] ?>" class="btn btn-success w-100 mt-3">Upload Bukti Pembayaran</a>

<?= $this->endSection() ?>

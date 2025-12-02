<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h3>Keranjang Belanja</h3>

<table class="table">
<tr><th>Gambar</th><th>Nama</th><th>Harga</th><th>Jumlah</th><th>Total</th><th></th></tr>

<?php foreach($keranjang as $item): ?>
<tr>
    <td><img src="/img/<?= $item['gambar'] ?>" width="70"></td>
    <td><?= $item['nama_barang'] ?></td>
    <td><?= number_format($item['harga_barang']) ?></td>
    <td><?= $item['jumlah'] ?></td>
    <td><?= number_format($item['subtotal']) ?></td>
    <td><a href="/keranjang/hapus/<?= $item['id_keranjang'] ?>" class="btn btn-danger btn-sm">Hapus</a></td>
</tr>
<?php endforeach; ?>
</table>

<a href="/checkout" class="btn btn-success">Checkout</a>

<?= $this->endSection() ?>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h3>Checkout</h3>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($keranjang as $item): ?>
        <tr>
            <td><?= $item['nama_barang'] ?></td>
            <td>Rp <?= number_format($item['harga_jual']) ?></td>
            <td><?= $item['jumlah'] ?></td>
            <td>Rp <?= number_format($item['harga_jual'] * $item['jumlah']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h4 class="text-end">Total: Rp <?= number_format($total) ?></h4>

<form action="/checkout/proses" method="post">
    <button class="btn btn-primary w-100">Buat Pesanan</button>
</form>

<?= $this->endSection() ?>

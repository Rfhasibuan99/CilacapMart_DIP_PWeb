<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>Daftar Pesanan Saya</h3>

    <div class="card p-3 mt-3">
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($pesanan)): ?>
            <tr>
                <td colspan="5" class="text-center text-muted">Belum ada pesanan yang dibuat.</td>
            </tr>
        <?php else: ?>
            <?php foreach($pesanan as $p): ?>
            <tr>
                <td><?= $p['kode_pesanan'] ?></td>
                <td><?= date('d/m/Y', strtotime($p['tanggal_pesan'])) ?></td>
                <td>Rp <?= number_format($p['total_harga']) ?></td>
                <td>
                    <span class="badge 
                        <?php 
                            if ($p['status'] == 'Dibayar' || $p['status'] == 'Selesai') echo 'bg-success';
                            else if ($p['status'] == 'Menunggu Pembayaran' || $p['status'] == 'Menunggu Konfirmasi') echo 'bg-warning text-dark';
                            else echo 'bg-secondary';
                        ?>">
                        <?= $p['status'] ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('/pesanan/detail/' . $p['id_pesanan']) ?>" class="btn btn-sm btn-primary">Detail</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
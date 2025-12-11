<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container py-5">
    <h2>Daftar Semua Saran & Masukan</h2>
    <p class="text-muted">Akses Terbatas: Hanya untuk Admin. Total Saran: <?= count($saran_list) ?></p>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Pengirim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php if (empty($saran_list)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada saran yang masuk.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($saran_list as $saran): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($saran['judul_saran']); ?></td>
                            <td><span class="badge text-bg-info"><?= esc($saran['kategori']); ?></span></td>
                            <td><?= esc($saran['username_pengirim'] ?? 'Anonim'); ?></td>
                            <td>
                                <span class="badge 
                                    <?= ($saran['status'] == 'Baru') ? 'text-bg-danger' : 
                                       (($saran['status'] == 'Dibaca') ? 'text-bg-warning text-dark' : 'text-bg-success'); ?>">
                                    <?= esc($saran['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('saran/detail_satu/' . $saran['id']); ?>" class="btn btn-sm btn-primary">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
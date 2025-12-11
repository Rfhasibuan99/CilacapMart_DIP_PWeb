<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-primary"><i class="fas fa-list-alt me-2"></i> Daftar Saran & Masukan</h2>
        <a href="<?= base_url('saran'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-plus me-1"></i> Kembali ke Form Saran
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="<?= base_url('saran/daftar'); ?>" method="get" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="kategoriFilter" class="form-label visually-hidden">Filter Kategori</label>
                    <select class="form-select form-select-sm" id="kategoriFilter" name="kategori">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($kategori_opsi as $opsi): ?>
                            <option value="<?= esc($opsi); ?>" <?= ($kategori_aktif == $opsi) ? 'selected' : ''; ?>>
                                <?= esc($opsi); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="statusFilter" class="form-label visually-hidden">Filter Status</label>
                    <select class="form-select form-select-sm" id="statusFilter" name="status">
                        <?php $statusOptions = ['Semua Status' => '', 'Baru' => 'Baru', 'Dibaca' => 'Dibaca', 'Diproses' => 'Diproses', 'Selesai' => 'Selesai']; ?>
                        <?php foreach ($statusOptions as $label => $value): ?>
                            <option value="<?= esc($value); ?>" <?= ($status_aktif == $value) ? 'selected' : ''; ?>>
                                <?= esc($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm me-2"><i class="fas fa-filter me-1"></i> Terapkan</button>
                    <?php if ($kategori_aktif || $status_aktif): ?>
                        <a href="<?= base_url('saran/daftar'); ?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-times me-1"></i> Reset</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <?php if (empty($saran_list)): ?>
        <div class="alert alert-info text-center mt-5" role="alert">
            <i class="fas fa-info-circle me-2"></i> Tidak ada saran yang ditemukan dengan kriteria tersebut.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 30%;">Judul</th>
                        <th style="width: 20%;">Kategori</th>
                        <th style="width: 15%;">Pengirim</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($saran_list as $saran): ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td>
                                <a href="<?= base_url('saran/detail/' . $saran['id']); ?>" class="<?= ($saran['status'] == 'Baru') ? 'fw-bold' : ''; ?>">
                                    <?= esc($saran['judul_saran']); ?>
                                </a>
                            </td>
                            <td><?= esc($saran['kategori']); ?></td>
                            <td><?= esc($saran['username']); ?></td>
                            <td>
                                <?php
                                $badgeClass = match ($saran['status']) {
                                    'Baru' => 'bg-danger',
                                    'Dibaca' => 'bg-warning text-dark',
                                    'Diproses' => 'bg-info text-dark',
                                    'Selesai' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?= $badgeClass; ?>"><?= esc($saran['status']); ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('saran/detail/' . $saran['id']); ?>" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection(); ?>
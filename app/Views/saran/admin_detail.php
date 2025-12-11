<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0 text-primary"><i class="fas fa-search me-2"></i> Detail Saran</h2>
                <a href="<?= base_url('saran/daftar'); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <?php if (session()->getFlashdata('pesan_update')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan_update'); ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= esc($saran['judul_saran']); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kategori:</strong> <?= esc($saran['kategori']); ?></p>
                            <p class="mb-1"><strong>ID Saran:</strong> #<?= esc($saran['id']); ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><strong>Dikirim Oleh:</strong> <?= esc($saran['username']); ?></p>
                            <p class="mb-1"><strong>Tanggal Kirim:</strong> <?= date('d M Y, H:i', strtotime(esc($saran['created_at']))); ?></p>
                        </div>
                    </div>
                    <hr>
                    
                    <h6 class="mt-3">Deskripsi Lengkap:</h6>
                    <div class="p-3 border rounded bg-light mb-4">
                        <p class="mb-0 text-break"><?= nl2br(esc($saran['deskripsi'])); ?></p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Status Saat Ini:</strong> 
                            <?php 
                                $badgeClass = match($saran['status']) {
                                    'Baru' => 'bg-danger',
                                    'Dibaca' => 'bg-warning text-dark',
                                    'Diproses' => 'bg-info text-dark',
                                    'Selesai' => 'bg-success',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <span class="badge <?= $badgeClass; ?> fs-6"><?= esc($saran['status']); ?></span>
                        </div>
                        
                        <div>
                            <form action="<?= base_url('saran/update_status/' . $saran['id']); ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <div class="input-group input-group-sm">
                                    <select name="status" class="form-select form-select-sm" required>
                                        <option value="">Ubah Status...</option>
                                        <option value="Dibaca" <?= ($saran['status'] === 'Dibaca') ? 'selected disabled' : ''; ?>>Dibaca</option>
                                        <option value="Diproses" <?= ($saran['status'] === 'Diproses') ? 'selected disabled' : ''; ?>>Diproses</option>
                                        <option value="Selesai" <?= ($saran['status'] === 'Selesai') ? 'selected disabled' : ''; ?>>Selesai</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="text-center text-muted small mt-4">
                <i class="fas fa-wrench me-1"></i> Hanya admin yang dapat melihat dan mengubah status saran ini.
            </p>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->extend('layout/template');  ?>
<?= $this->section('content'); ?>

<style>
    /* Gaya CSS Khusus untuk Tampilan Detail Tunggal */
    body {
        background-color: #f0f8ff; 
    }
    .saran-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .saran-header {
        text-align: center;
        border-bottom: 2px solid #003366; 
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .saran-title {
        color: #003366;
        font-size: 2rem;
        font-weight: bold;
    }
    /* Gaya untuk tabel detail (untuk memisahkan label dan nilai) */
    .table-detail {
        margin-top: 20px;
    }
    .table-detail td:first-child {
        width: 30%;
        font-weight: bold;
        color: #003366;
        vertical-align: top;
    }
    .table-detail td {
        border-top: 1px solid #dee2e6;
        padding: 12px 0;
    }
    .description-box {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        border: 1px dashed #ced4da;
    }
</style>

<div class="container py-5">
    
    <div class="d-flex gap-2 mb-3 justify-content-start" style="max-width: 800px; margin: 0 auto 1rem;">
        <a href="<?= base_url('saran/daftar'); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
        
        
        </div>
    
    <div class="saran-container">
        <div class="saran-header">
            <h1 class="saran-title">DETAIL SARAN TUNGGAL</h1>
            <p class="mb-0 text-muted">Judul: **<?= esc($saran['judul_saran']); ?>**</p>
        </div>

        <table class="table table-borderless table-detail">
            
            <tr>
                <td>ID Saran</td>
                <td>#<?= esc($saran['id']); ?></td>
            </tr>

            <tr>
                <td>Kategori</td>
                <td>
                    <span class="badge text-bg-info fs-6"><?= esc($saran['kategori']); ?></span>
                </td>
            </tr>

            <tr>
                <td>Status</td>
                <td>
                    <span class="badge fs-6 
                        <?= ($saran['status'] == 'Baru') ? 'text-bg-danger' : (($saran['status'] == 'Dibaca') ? 'text-bg-warning text-dark' : 'text-bg-success'); ?>">
                        <?= esc($saran['status']); ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td>Pengirim</td>
                <td>
                    <?= esc($saran['username_pengirim'] ?? 'Anonim'); ?> 
                    (ID Pengguna: <?= $saran['users_id'] ?? 'N/A'; ?>)
                </td>
            </tr>

            <tr>
                <td>Tanggal Kirim</td>
                <td><?= date('d F Y H:i:s', strtotime($saran['created_at'])); ?></td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <h5 class="mt-4 mb-2" style="color:#003366;">Deskripsi Lengkap</h5>
                    <div class="description-box">
                        <?= nl2br(esc($saran['deskripsi'])); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="text-center mt-4">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print me-2"></i>Cetak Laporan
        </button>
    </div>

</div>

<?= $this->endSection(); ?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php
// Tentukan array gambar/ikon yang lebih umum untuk kategori
$gambarKategoriMapping = [
    'Peningkatan Fitur' => 'fa-lightbulb',
    'Masalah Teknis' => 'fa-bug',
    'Kritik Layanan' => 'fa-comment-alt-slash',
    'Belanja' => 'fa-shopping-cart',
    'Pembayaran' => 'fa-credit-card',
    'Pengiriman' => 'fa-truck',
    'Lain-lain' => 'fa-ellipsis-h',
];
?>

<style>
    body {
        background-color: #f5f5f5;
        font-family: 'Arial', sans-serif;
    }

    .form-page-header {
        background-color: #fff;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .form-title-main {
        color: #003366;
        font-weight: bold;
        margin: 0;
        font-size: 1.5rem;
    }
    
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }
    
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 10px;
        margin-bottom: 25px;
    }

    .category-btn {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 15px 10px;
        text-align: center;
        font-size: 0.9rem;
        color: #333;
        font-weight: 500;
        transition: all 0.2s;
        height: 100%;
        width: 100%;
        cursor: pointer;
        display: block;
        text-decoration: none;
        outline: none; /* Hilangkan outline fokus default */
    }

    .category-btn:hover {
        border-color: #007bff;
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.1);
        transform: translateY(-1px);
    }
    
    .category-btn.selected {
        background-color: #e6f0ff;
        border: 2px solid #003366;
        color: #003366;
        font-weight: 700;
        box-shadow: 0 0 5px rgba(0, 51, 102, 0.2);
    }
    
    /* Styling Icon Kategori */
    .category-icon {
        font-size: 2rem;
        color: #007bff;
        margin-bottom: 5px;
        display: block;
    }

    .category-btn.selected .category-icon {
        color: #003366;
    }
    
    .form-control, .form-select {
        border-radius: 3px;
        border: 1px solid #ccc;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
    }

    .btn-submit {
        background-color: #003366;
        border-color: #003366;
        color: white;
        padding: 10px 15px;
        font-weight: 600;
        transition: background-color 0.2s;
    }

    .btn-submit:hover {
        background-color: #00284f;
        border-color: #00284f;
        color: white;
    }

    .btn-admin-access {
        background-color: #f3f3f3;
        color: #555;
        border: 1px solid #ddd;
        font-size: 0.9rem;
        padding: 8px 15px;
        border-radius: 3px;
    }
</style>

<div class="form-page-header">
    <div class="container">
        <h2 class="form-title-main"><?= $title; ?></h2>
    </div>
</div>

<div class="container py-3">
    <div class="form-container">
        <p class="text-center text-muted mb-4">Bantu kami meningkatkan layanan CilacapMart.</p>

        <?php if (session()->getFlashdata('pesan')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('saran/simpan'); ?>" method="post" id="saranForm">
            <?= csrf_field(); ?>
            
            <input type="hidden" name="kategori" id="selected_kategori" value="<?= old('kategori'); ?>">

            <div class="mb-3">
                <label for="kategori" class="form-label mb-3">Pilih Kategori Saran <span class="text-danger">*</span></label>
                
                <div class="category-grid">
                    <?php
                    // Gunakan $kategori_list yang dilewatkan dari controller
                    $kategoriOpsi = $kategori_list ?? $this->getKategoriOpsiForForm();
                    
                    foreach ($kategoriOpsi as $opsi): 
                        if (empty($opsi)) continue;
                        
                        // Cek apakah kategori ini memiliki ikon/gambar yang telah didefinisikan
                        $iconClass = $gambarKategoriMapping[$opsi] ?? 'fa-question-circle'; // Default icon jika tidak ada
                        $isSelected = (old('kategori') == $opsi) ? 'selected' : '';
                    ?>
                        <button type="button" 
                                class="category-btn <?= $isSelected; ?>" 
                                data-kategori="<?= esc($opsi); ?>"
                                onclick="selectCategory(this)">
                            <i class="fas category-icon <?= esc($iconClass); ?>"></i>
                            <?= esc($opsi); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <?php if (session('errors.kategori')): ?>
                    <div class="text-danger small mt-2">
                        <?= session('errors.kategori'); ?>
                    </div>
                <?php endif; ?>
                
            </div>

            <div class="mb-3">
                <label for="judul_saran" class="form-label">Judul Singkat <span class="text-danger">*</span></label>
                <input type="text" 
                    class="form-control <?= (session('errors.judul_saran')) ? 'is-invalid' : ''; ?>"
                    id="judul_saran" name="judul_saran" value="<?= old('judul_saran'); ?>" 
                    placeholder="Contoh: Perlu Fitur Filter Barang">
                <div class="invalid-feedback">
                    <?= session('errors.judul_saran'); ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control <?= (session('errors.deskripsi')) ? 'is-invalid' : ''; ?>"
                    id="deskripsi" name="deskripsi" rows="5" 
                    placeholder="Jelaskan saran Anda secara detail..."><?= old('deskripsi'); ?></textarea>
                <div class="invalid-feedback">
                    <?= session('errors.deskripsi'); ?>
                </div>
            </div>

            <div class="mb-4 form-check">
                <?php if (!logged_in()): ?>
                    <input type="checkbox" class="form-check-input" id="anonim" name="anonim" value="1" <?= (old('anonim') == '1') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="anonim">Kirim secara anonim (Nama tidak akan dicatat).</label>
                <?php else: ?>
                    <input type="checkbox" class="form-check-input" id="anonim" name="anonim" value="1" <?= (old('anonim') == '1') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="anonim">Kirim secara anonim (Nama dan ID Anda tidak akan dicatat).</label>
                    <p class="text-muted small mt-2">Jika tidak dicentang, Anda mengirim sebagai: <strong><?= user()->username ?? 'Pengguna'; ?></strong></p>
                <?php endif; ?>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-submit">Kirim Saran</button>
            </div>
            <?php if (in_groups('admin')): ?>
                <div class="mt-3 text-center">
                    <a href="<?= base_url('saran/daftar'); ?>" class="btn btn-admin-access">
                        <i class="fas fa-list me-2"></i> Akses Daftar Saran (Admin)
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hiddenInput = document.getElementById('selected_kategori');
        const categoryButtons = document.querySelectorAll('.category-btn');
        
        window.selectCategory = function(selectedButton) {
            categoryButtons.forEach(btn => {
                btn.classList.remove('selected');
            });

            selectedButton.classList.add('selected');

            // Set nilai ke hidden input
            hiddenInput.value = selectedButton.dataset.kategori;

            // Clear validation error message on selection
            const categoryError = document.querySelector('.text-danger.small.mt-2');
            if (categoryError) {
                categoryError.style.display = 'none';
            }
        };

        // Re-select category if 'old' value exists on page load
        if (hiddenInput.value) {
            categoryButtons.forEach(btn => {
                if (btn.dataset.kategori === hiddenInput.value) {
                    btn.classList.add('selected');
                }
            });
        }
    });
    
    // Helper function used by the controller, included here for completeness
    function getKategoriOpsiForForm() {
        return [
            'Peningkatan Fitur', 
            'Masalah Teknis', 
            'Kritik Layanan', 
            'Belanja', 
            'Pembayaran', 
            'Pengiriman', 
            'Lain-lain'
        ];
    }
</script>

<?= $this->endSection(); ?>
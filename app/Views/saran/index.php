<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

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
    }

    .category-btn:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        transform: translateY(-3px);
    }
    
    .category-btn.selected {
        background-color: #e6f0ff;
        border: 2px solid #003366;
        color: #003366;
        font-weight: 700;
        box-shadow: 0 0 5px rgba(0, 51, 102, 0.2);
    }
    
    /* Styling Gambar Kategori */
    .category-image {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-bottom: 5px;
        display: block;
        margin-left: auto;
        margin-right: auto;
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
        <h2 class="form-title-main">Sampaikan Saran & Masukan Anda</h2>
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
                    $kategoriOpsi = isset($kategori_list) ? $kategori_list : [
                        'Minuman', 'Makanan', 'Fashion', 'Barang Kerajinan', 'Accessories', 'Bahan Baku', 'Belanja', 'Pembayaran', 'Pengiriman', 'Fitur Aplikasi', 'Lainnya'
                    ];
                    
                    $gambarKategori = [
                        'Minuman' => 'Minuman.jpg',
                        'Makanan' => 'Makanan.jpg',
                        'Fashion' => 'Fashion.jpg',
                        'Barang Kerajinan' => 'BarangKerajinan.jpg',
                        'Accessories' => 'Accesories.jpg',
                        'Bahan Baku' => 'BahanBaku.jpg',
                        'Belanja' => 'fa-shopping-cart',
                        'Pembayaran' => 'fa-credit-card',
                        'Pengiriman' => 'fa-truck',
                        'Fitur Aplikasi' => 'fa-mobile-alt',
                        'Lainnya' => 'fa-ellipsis-h',
                    ];
                    
                    foreach ($kategoriOpsi as $opsi): 
                        if (empty($opsi)) continue;
                        $fileName = $gambarKategori[$opsi] ?? 'default.jpg';
                        $isSelected = (old('kategori') == $opsi) ? 'selected' : '';
                    ?>
                        <button type="button" 
                                class="category-btn <?= $isSelected; ?>" 
                                data-kategori="<?= $opsi; ?>"
                                onclick="selectCategory(this)">
                            <img src="<?= base_url('img/' . $fileName); ?>" 
                                 class="category-image" 
                                 alt="<?= $opsi; ?>">
                            <?= $opsi; ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <?php if (validation_show_error('kategori')): ?>
                    <div class="text-danger small mt-2">
                        <?= validation_show_error('kategori'); ?>
                    </div>
                <?php endif; ?>
                
            </div>

            <div class="mb-3">
                <label for="judul_saran" class="form-label">Judul Singkat <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (validation_show_error('judul_saran')) ? 'is-invalid' : ''; ?>"
                    id="judul_saran" name="judul_saran" value="<?= old('judul_saran'); ?>" placeholder="Contoh: Perlu Fitur Filter Barang">
                <div class="invalid-feedback">
                    <?= validation_show_error('judul_saran'); ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control <?= (validation_show_error('deskripsi')) ? 'is-invalid' : ''; ?>"
                    id="deskripsi" name="deskripsi" rows="5" placeholder="Jelaskan saran Anda secara detail..."><?= old('deskripsi'); ?></textarea>
                <div class="invalid-feedback">
                    <?= validation_show_error('deskripsi'); ?>
                </div>
            </div>

            <div class="mb-4 form-check">
                <?php if (!logged_in()): ?>
                    <input type="checkbox" class="form-check-input" id="anonim" name="anonim" value="1" <?= (old('anonim')) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="anonim">Kirim secara anonim (Nama tidak akan dicatat).</label>
                <?php else: ?>
                    <p class="text-muted small">Anda mengirim sebagai: <strong><?= user()->username; ?></strong></p>
                    <input type="hidden" name="id_pengguna" value="<?= user_id(); ?>">
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

            hiddenInput.value = selectedButton.dataset.kategori;
        };

        if (hiddenInput.value) {
            categoryButtons.forEach(btn => {
                if (btn.dataset.kategori === hiddenInput.value) {
                    btn.classList.add('selected');
                }
            });
        }
    });
</script>

<?= $this->endSection(); ?>
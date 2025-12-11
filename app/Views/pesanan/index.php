<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4Cg+bL/Wq8X0v1zI7K3f6R0e1n7Z1l5y00W6H/3a8g7K8M6+8i5z/e8K/n7Q+9uGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    :root {
        --color-primary: #003366;
        --color-success: #28a745;
        --color-warning: #ffc107;
        --color-info: #17a2b8;
        --color-danger: #dc3545;
        --color-bg-light: #f0f8ff;
    }

    body {
        background-color: var(--color-bg-light);
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
        min-width: 120px;
        text-align: center;
        text-transform: capitalize;
    }

    .status-MenungguPembayaran {
        background-color: var(--color-warning);
        color: #343a40;
    }

    .status-Diproses {
        background-color: var(--color-info);
        color: white;
    }

    .status-Selesai {
        background-color: var(--color-success);
        color: white;
    }

    .status-Dibatalkan {
        background-color: var(--color-danger);
        color: white;
    }

    .status-Pengiriman {
        background-color: var(--color-primary);
        color: white;
    }

    .order-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        padding: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
        border-left: 5px solid var(--color-primary);
    }

    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
    }

    .total-text {
        font-size: 1.1rem;
        font-weight: bold;
        color: var(--color-danger);
    }

    .no-orders {
        text-align: center;
        padding: 40px;
        background-color: #e9ecef;
        border-radius: 10px;
        color: #6c757d;
    }

    .order-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .order-date {
        font-size: 0.85rem;
        color: #999;
        margin-top: 5px;
    }
</style>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Daftar Riwayat Pesanan Saya</h3>

            <?php if (empty($pesanan)): ?>
                <div class="no-orders">
                    <i class="fas fa-box-open fa-3x mb-3"></i>
                    <p class="mb-0">Belum ada riwayat pesanan yang ditemukan.</p>
                    <a href="<?= base_url('/barang') ?>" class="btn btn-primary mt-3"><i class="fas fa-shopping-cart me-2"></i>Mulai Berbelanja</a>
                </div>
            <?php else: ?>
                <?php foreach ($pesanan as $order):
                    $identifier = $order['kode_pesanan'] ?? $order['id_pesanan'];
                    $statusKey = str_replace(' ', '', $order['status'] ?? 'Default');
                    $statusClass = 'status-' . $statusKey;
                    $finalTotal = $order['total_akhir'] ?? $order['total_harga'] ?? 0;
                    $gambarProduk = $order['gambar'] ?? 'default.jpg';
                ?>
                    <div 
                        class="order-card d-flex justify-content-between align-items-center" 
                        onclick="window.location.href='<?= base_url('pesanan/detail/' . $identifier) ?>'"
                    >

                        <div class="d-flex align-items-center flex-grow-1">
                            
                            <img
                                src="<?= base_url('img/' . esc($gambarProduk)) ?>"
                                class="order-thumbnail me-3"
                                alt="Gambar Produk"
                                onerror="this.onerror=null;this.src='https://placehold.co/60x60/cccccc/333333?text=Item'">

                            <div>
                                <div class="fw-bold mb-1" style="font-size: 1.1rem;"><?= esc($order['kode_pesanan']) ?></div>
                                
                                <div class="text-secondary" style="font-size: 0.9rem;">
                                    <?= esc($order['item_count']) ?? '?' ?> Barang | Total:
                                    <span class="total-text">Rp <?= number_format($finalTotal, 0, ',', '.') ?></span>
                                </div>
                                
                                <div class="order-date">
                                    <i class="far fa-clock me-1"></i> Dipesan: <?= date('d M Y', strtotime($order['tanggal_pesan'] ?? date('Y-m-d'))) ?>
                                </div>
                            </div>
                        </div>

                        <div class="text-end d-flex align-items-center">
                            <span class="status-badge <?= esc($statusClass) ?> me-2">
                                <?= esc($order['status'] ?? 'Tidak Diketahui') ?>
                            </span>
                            <i class="fas fa-chevron-right text-secondary"></i>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
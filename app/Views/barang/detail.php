<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4Cg+bL/Wq8X0v1zI7K3f6R0e1n7Z1l5y00W6H/3a8g7K8M6+8i5z/e8K/n7Q+9uGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body {
        background-color: #F5F6F8;
    }
    .back-text h4 {
        color: #003366;
        cursor: pointer;
        font-weight: 600;
    }
    .container h2,
    .detail-info h3 {
        color: #003366;
    }
    .detail-container {
        display: flex;
        gap: 20px;
        background: #ffffff;
        padding: 25px;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e5e5;
    }
    .detail-container img {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }
    .detail-info h4 {
        color: #C0392B;
        font-weight: bold;
    }
    .product-price {
        color: #C0392B;
    }
    
    .button-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }
    .btn-action {
        width: 100%;
        max-width: 220px; 
        padding: 10px;
        font-weight: 600;
        text-align: center;
        border-radius: 6px;
    }
    .btn-buy-now {
        background-color: #FFC107;
        border-color: #FFC107;
        color: #333;
    }
    .btn-buy-now:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        color: #333;
    }
    .btn-add-cart {
        background-color: #003366;
        border-color: #003366;
    }
    .btn-add-cart:hover {
        background-color: #002849;
        border-color: #002849;
    }
    .qty-input-group {
        width: 180px; 
        margin-top: 15px;
    }
    /* ----------------------------- */
</style>

<div class="mb-3 back-text" onclick="history.back()">
    <h4>← Kembali ke Dashboard</h4>
</div>

<div class="container pt-4">

    <h2 class="mb-4 fw-bold">Detail Produk</h2>

    <div class="detail-container">

        <img src="<?= base_url('img/' . $barang['gambar']) ?>"
            onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">

        <div class="detail-info">

            <h3><?= $barang['nama_barang']; ?></h3>

            <h4 class="mt-2 product-price">
                Rp <?= number_format($barang['harga_jual'], 0, ',', '.'); ?>
            </h4>

            <p class="mt-2">
                <strong>Stok:</strong> <?= $barang['stok']; ?>
            </p>

            <p class="mt-3"><?= $barang['deskripsi']; ?></p>

            <form id="qtyForm" action="javascript:void(0);"> 
                <div class="input-group qty-input-group">
                    <span class="input-group-text">Qty</span>
                    <input type="number" id="input_jumlah" name="jumlah" value="1" min="1" max="<?= $barang['stok']; ?>" class="form-control text-center" required>
                </div>
            </form>
            
            <div class="button-container">
                
                <form action="<?= base_url('/pesanan/buy_now_start') ?>" method="post" id="formBuyNow">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
                    <input type="hidden" name="nama_barang" value="<?= $barang['nama_barang']; ?>">
                    <input type="hidden" name="harga_jual" value="<?= $barang['harga_jual']; ?>">
                    <input type="hidden" name="gambar" value="<?= $barang['gambar']; ?>">
                    <input type="hidden" name="jumlah" id="buy_now_jumlah" value="1"> 
                    
                    <button type="submit" class="btn btn-action btn-buy-now">
                        <i class="fas fa-money-check-alt me-1"></i> Beli Sekarang
                    </button>
                </form>
                
                <form action="<?= base_url('/keranjang/tambah') ?>" method="post" id="formAddCart">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
                    <input type="hidden" name="jumlah" id="add_cart_jumlah" value="1"> 
                    
                    <button type="submit" class="btn btn-action btn-add-cart text-white">
                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </form>

            </div>

        </div>

    </div>
</div>

<script>    const inputJumlah = document.getElementById('input_jumlah');
    const buyNowJumlah = document.getElementById('buy_now_jumlah');
    const addCartJumlah = document.getElementById('add_cart_jumlah');

    inputJumlah.addEventListener('input', function() {
        const value = this.value;
        buyNowJumlah.value = value;
        addCartJumlah.value = value;
    });

    buyNowJumlah.value = inputJumlah.value;
    addCartJumlah.value = inputJumlah.value;
</script>

<?= $this->endSection(); ?>
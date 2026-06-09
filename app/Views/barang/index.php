<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
    body {
        background-color: #F5F5F5;
        font-family: 'Arial', sans-serif;
    }

    .product-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        gap: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
    }

    .product-card img {
        width: 100%;
        max-width: 350px;
        height: 350px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #ddd;
        flex-shrink: 0;
    }

    .product-info {
        flex-grow: 1;
    }

    .product-info h3 {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .price {
        color: #FF5722;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .old-price {
        text-decoration: line-through;
        color: #888;
        font-size: 16px;
    }

    .stock {
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }

    .desc-box {
        background: #f8f8f8;
        border-radius: 8px;
        padding: 12px;
        margin-top: 10px;
        border: 1px solid #e4e4e4;
        margin-bottom: 20px;
    }

    .qty-input-group {
        width: 150px;
        margin-bottom: 15px;
    }

    .action-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 200px;
    }

    .action-group .btn {
        width: 100%;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-beli {
        background-color: #FF9800;
        border: none;
        color: white;
    }

    .btn-beli:hover {
        background-color: #e68900;
    }

    .btn-cart {
        background-color: #0096C7;
        border: none;
        color: white;
    }

    .btn-cart:hover {
        background-color: #007AA1;
    }

    .admin-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
</style>

<form action="<?= base_url('/') ?>">
    <button class="btn btn-back">
        Kembali Ke Dasboard
    </button>
</form>
<div class="container pt-4">
    <h2 class="mb-4 fw-bold">Daftar Produk</h2>

    <?php if (in_groups('admin')): ?>
        <div class="text-end mb-3">
            <a href="/barang/tambah" class="btn btn-primary">Tambah Barang</a>
        </div>
    <?php endif; ?>

    <?php $barang = isset($barang) ? $barang : []; ?>
    <?php foreach ($barang as $b): ?>
        <div class="product-card">

            <div>
                <img src="<?= base_url('img/' . $b['gambar']) ?>"
                    onerror="this.src='https://via.placeholder.com/350x350?text=No+Image'">
            </div>

            <div class="product-info">

                <h3><?= $b['nama_barang']; ?></h3>

                <div class="price">
                    Rp <?= number_format($b['harga_jual'], 0, ',', '.'); ?>
                </div>

                <?php if (in_groups('admin')): ?>
                    <div class="old-price">
                        Harga asli: Rp <?= number_format($b['harga_beli'], 0, ',', '.'); ?>
                    </div>
                <?php endif; ?>

                <div class="stock">
                    Stok: <strong><?= $b['stok']; ?></strong>
                </div>

                <div class="desc-box">
                    <?= $b['deskripsi']; ?>
                </div>

                <div class="action-user">

                    <div class="input-group qty-input-group">
                        <span class="input-group-text">Qty</span>
                        <input type="number" id="qty_<?= $b['id_barang']; ?>"
                            name="jumlah_input"
                            value="1" min="1" max="<?= $b['stok']; ?>"
                            class="form-control text-center" required>
                    </div>

                    <div class="action-group">

                        <form action="<?= base_url('/pesanan/buy_now_start') ?>" method="post" id="form_buy_<?= $b['id_barang']; ?>">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_barang" value="<?= $b['id_barang']; ?>">
                            <input type="hidden" name="nama_barang" value="<?= $b['nama_barang']; ?>">
                            <input type="hidden" name="harga_jual" value="<?= $b['harga_jual']; ?>">
                            <input type="hidden" name="gambar" value="<?= $b['gambar']; ?>">
                            <input type="hidden" name="jumlah" id="jumlah_buy_<?= $b['id_barang']; ?>" value="1">

                            <button type="submit" class="btn btn-beli">Beli Sekarang</button>
                        </form>

                        <form action="<?= base_url('/keranjang/tambah') ?>" method="post" id="form_cart_<?= $b['id_barang']; ?>">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_barang" value="<?= $b['id_barang']; ?>">
                            <input type="hidden" name="jumlah" id="jumlah_cart_<?= $b['id_barang']; ?>" value="1">

                            <button type="submit" class="btn btn-cart">Tambah ke Keranjang</button>
                        </form>

                    </div>
                </div>

                <?php if (in_groups('admin')): ?>
                    <div class="admin-actions">
                        <a href="/barang/ubah/<?= $b['id_barang']; ?>" class="btn btn-warning text-white">
                            Ubah
                        </a>
                        <a href="/barang/hapus/<?= $b['id_barang']; ?>" class="btn btn-danger">
                            Hapus
                        </a>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    <?php endforeach; ?>
</div>

<script>
    document.querySelectorAll('.product-card').forEach(card => {
        const idBarang = card.querySelector('input[name="id_barang"]').value;
        const inputQty = card.querySelector(`#qty_${idBarang}`);
        const jumlahBuy = card.querySelector(`#jumlah_buy_${idBarang}`);
        const jumlahCart = card.querySelector(`#jumlah_cart_${idBarang}`);

        function syncQty() {
            const value = inputQty.value;
            jumlahBuy.value = value;
            jumlahCart.value = value;
        }

        if (inputQty) {
            inputQty.addEventListener('input', syncQty);
            syncQty();
        }
    });
</script>


<?= $this->endSection(); ?>
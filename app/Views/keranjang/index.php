<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<style>
    body {
        background-color: #E8EFF7 !important; 
    }
    .keranjang-item-row {
        background-color: #fff;
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 10px 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
    }
    .keranjang-header {
        color: #333;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .img-thumb {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }
    .input-jumlah {
        width: 60px;
        text-align: center;
    }
    .btn-hapus {
        background-color: #f0f8ff;
        color: #333;
        border: 1px solid #cceeff;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 6px;
    }
    .total-checkout-area {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-pesan-sekarang {
        background-color: #003366; 
        color: #fff;
        padding: 10px 40px;
        font-size: 18px;
        border-radius: 6px;
        border: none;
        width: 100%;
        margin-top: 20px;
    }
</style>

<div class="container py-4">
    <h3 class="keranjang-header">Keranjang Belanja</h3>
    
    <div class="row text-secondary mb-2" style="font-size: 14px;">
        <div class="col-1 text-center"></div>
        <div class="col-4">Nama</div>
        <div class="col-2 text-center">Harga Satuan</div>
        <div class="col-1 text-center">Jumlah</div>
        <div class="col-2 text-center">Total</div>
        <div class="col-2 text-center">Aksi</div>
    </div>
    
    <form id="formCheckout" action="<?php echo base_url('pesanan/prepare_review'); ?>" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="selected_items_json" id="selectedItemsJson">
        <input type="hidden" name="calculated_total_price" id="calculatedTotalPrice">

        <?php if (empty($keranjang)): ?>
            <div class="alert alert-warning text-center">Keranjang belanja Anda kosong.</div>
        <?php else: ?>
            <?php foreach($keranjang as $item): ?>
            <div class="keranjang-item-row" data-harga="<?php echo $item['harga_jual']; ?>" data-id="<?php echo $item['id_keranjang']; ?>">
                
                <div class="col-1 text-center">
                    <input class="form-check-input item-checkbox" type="checkbox" checked data-id="<?php echo $item['id_keranjang']; ?>" 
                            data-item='<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>'> 
                </div>
                
                <div class="col-4 d-flex align-items-center">
                    <img src="<?php echo base_url('img/' . $item['gambar']); ?>" class="img-thumb me-3" onerror="this.src='https://via.placeholder.com/100x100?text=No+Image'">
                    <div>
                        <div class="fw-bold"><?php echo $item['nama_barang']; ?></div>
                        <div class="text-secondary" style="font-size: 14px;">Harga: Rp.<?php echo number_format($item['harga_jual'], 0, ',', '.'); ?></div>
                    </div>
                </div>

                <div class="col-2 text-center">
                    Rp.<?php echo number_format($item['harga_jual'], 0, ',', '.'); ?>
                </div>
                
                <div class="col-1 text-center">
                    <input type="number" value="<?php echo $item['jumlah']; ?>" min="1" max="99" class="form-control input-jumlah input-jumlah-item mx-auto" data-id="<?php echo $item['id_keranjang']; ?>" style="display: inline-block;">
                </div>

                <div class="col-2 text-center fw-bold">
                    Rp.<span class="subtotal-item" data-id="<?php echo $item['id_keranjang']; ?>"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
                </div>

                <div class="col-2 text-center">
                    <a href="<?php echo base_url('/keranjang/hapus/' . $item['id_keranjang']); ?>" class="btn btn-sm btn-light btn-hapus">hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
            
            <div class="total-checkout-area">
                <div class="d-flex align-items-center">
                    <input class="form-check-input me-2" type="checkbox" id="pilihSemuaCheckbox" checked>
                    <label class="form-check-label" for="pilihSemuaCheckbox">Pilih semua</label>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-4 fw-bold">Total (<span id="totalProduk">0</span> Produk): Rp.<span id="totalHarga">0</span></div>
                </div>
            </div>

            <button type="submit" class="btn btn-pesan-sekarang">Pesan sekarang</button>
        <?php endif; ?>
    </form>
</div>

<script>
$(document).ready(function() {
    function formatRupiah(angka) {
        return parseFloat(angka).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    function hitungTotal() {
        let totalProdukTerpilih = 0;
        let totalHargaTerpilih = 0;
        let selectedItems = [];

        if ($('.keranjang-item-row').length === 0) {
            $('#totalProduk').text(0);
            $('#totalHarga').text(0);
            $('#selectedItemsJson').val(JSON.stringify([]));
            $('#calculatedTotalPrice').val(0);
            return;
        }

        $('.keranjang-item-row').each(function() {
            const itemId = $(this).data('id');
            const $checkbox = $('.item-checkbox[data-id="' + itemId + '"]');
            const $inputJumlah = $('.input-jumlah-item[data-id="' + itemId + '"]');
            const hargaSatuan = parseFloat($(this).data('harga'));
            const jumlah = parseInt($inputJumlah.val() || 0); 
            const subtotal = hargaSatuan * jumlah;
            
            $('.subtotal-item[data-id="' + itemId + '"]').text(formatRupiah(subtotal));
            
            if ($checkbox.is(':checked')) {
                totalProdukTerpilih += jumlah;
                totalHargaTerpilih += subtotal;
                
                try {
                    let itemData = JSON.parse($checkbox.attr('data-item'));
                    itemData.jumlah = jumlah;
                    itemData.subtotal = subtotal;
                    selectedItems.push(itemData);
                } catch (e) {
                    console.error("Gagal parse JSON item keranjang:", e);
                }
            }
        });

        $('#totalProduk').text(totalProdukTerpilih);
        $('#totalHarga').text(formatRupiah(totalHargaTerpilih));

        $('#selectedItemsJson').val(JSON.stringify(selectedItems));
        $('#calculatedTotalPrice').val(totalHargaTerpilih);
    }

    $('#pilihSemuaCheckbox').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.item-checkbox').prop('checked', isChecked);
        hitungTotal();
    });

    $(document).on('change', '.item-checkbox', function() {
        hitungTotal();
        const allChecked = $('.item-checkbox:checked').length === $('.item-checkbox').length;
        $('#pilihSemuaCheckbox').prop('checked', allChecked);
    });

    $(document).on('change keyup', '.input-jumlah-item', function() {
        let $input = $(this);
        let jumlah = parseInt($input.val());

        if (isNaN(jumlah) || jumlah < 1) {
            $input.val(1);
        }
        hitungTotal();
    });
    
    hitungTotal();
});
</script>

<?= $this->endSection(); ?>
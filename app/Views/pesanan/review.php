<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<style>
    body {
        background-color: #f0f8ff;
    }

    .container {
        max-width: 900px;
    }

    .back-link {
        font-weight: bold;
        color: #333;
        text-decoration: none;
        display: block;
        margin-bottom: 20px;
    }

    .card-alamat {
        background-color: #003366;
        color: #fff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .item-card {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .item-detail {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .item-detail:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .item-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-right: 15px;
        border-radius: 4px;
    }

    .metode-pembayaran,
    .metode-pengiriman {
        margin-bottom: 20px;
    }

    .metode-item {
        background-color: #e8f3ff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s;
    }

    .metode-item:hover,
    .metode-item.selected {
        border-color: #003366;
    }

    .metode-item img {
        height: 30px;
    }

    .rincian-harga {
        margin-top: 20px;
        padding: 15px;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .rincian-row {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
    }

    .total-final {
        font-size: 1.2rem;
        font-weight: bold;
        color: #003366;
    }

    .btn-checkout-final {
        background-color: #003366;
        color: #fff;
        font-size: 18px;
        padding: 12px;
        margin-top: 20px;
        border: none;
        border-radius: 6px;
        width: 100%;
    }
</style>

<div class="container py-4">
    <a href="<?= base_url('keranjang/') ?>" class="back-link">
        <i class="fas fa-arrow-left me-2"></i> Kembali Ke Keranjang
    </a>
    <h3 class="fw-bold mb-4">Konfirmasi Pesanan</h3>

    <form action="<?= base_url('pesanan/proses') ?>" method="post" id="formFinalCheckout">
        
        <?= csrf_field() ?>
        
        <input type="hidden" id="baseSubtotal" value="<?= $subtotalProduk ?? 0 ?>">
        <input type="hidden" id="discountAmount" value="<?= $diskon ?? 0 ?>">
        
        <input type="hidden" name="metode_pembayaran" id="inputMetodeBayar" required>
        <input type="hidden" name="metode_pengiriman" id="inputMetodeKirim" required>

        <input type="hidden" name="ppn_amount_final" id="inputPpnAmount" value="<?= $ppn ?? 0 ?>">
        <input type="hidden" name="total_akhir_final" id="inputTotalFinal" value="<?= $totalFinal ?? 0 ?>">
        <input type="hidden" name="ongkir_final" id="inputOngkir" value="<?= $ongkir ?? 0 ?>">


        <div class="row">
            <div class="col-12">
                <h5 class="fw-bold">Alamat Pengiriman</h5>
                <div class="card-alamat">
                    <h5><?= $alamat['penerima'] ?? 'nama_penerima' ?> | <?= $alamat['telp'] ?? 'Telepon' ?></h5>
                    <p class="mb-0"><?= $alamat['alamat_lengkap_pesanan'] ?? 'Alamat Tidak Ditemukan. Silahkan lengkapi' ?></p>
                </div>

                <div class="item-card">
                    <h5 class="fw-bold mb-3">
                        Detail Barang (<?= count($keranjangItems ?? []) ?> Item)
                    </h5>
                    
                    <?php if (!empty($keranjangItems)): ?>
                        <?php foreach ($keranjangItems as $item): ?>
                            <div class="item-detail">
                                <img src="<?= base_url('img/' . ($item['gambar'] ?? 'placeholder.png')) ?>" class="item-img" onerror="this.src='https://via.placeholder.com/60x60?text=Item'">
                                <div class="flex-grow-1">
                                    <div class="fw-bold"><?= $item['nama_barang'] ?></div>
                                    <div class="text-secondary" style="font-size: 14px;">
                                        Rp <?= number_format($item['harga_jual']) ?> x <?= $item['jumlah'] ?>
                                    </div>
                                </div>
                                <div class="fw-bold text-end">
                                    Rp <?= number_format($item['subtotal']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <h5 class="fw-bold mt-4">Metode Pembayaran</h5>
                <div class="metode-pembayaran">
                    <div class="metode-item" data-value="QRIS">
                        <div class="d-flex align-items-center">
                            <img src="https://placehold.co/30x30/2A70B4/FFFFFF?text=QR" class="me-3">
                            <span class="fw-bold">QRIS</span>
                        </div>
                        <i class="fas fa-check-circle text-primary d-none icon-check"></i>
                    </div>
                    <div class="metode-item" data-value="BNI Virtual Account">
                        <div class="d-flex align-items-center">
                            <img src="https://placehold.co/30x30/CC0000/FFFFFF?text=BNI" class="me-3">
                            <span class="fw-bold">BNI Virtual Account</span>
                        </div>
                        <i class="fas fa-check-circle text-primary d-none icon-check"></i>
                    </div>
                </div>

                <h5 class="fw-bold mt-4">Metode Pengiriman</h5>
                <div class="metode-pengiriman">
                    <div class="metode-item" data-value="Grab Standard" data-cost="20000">
                        <div class="d-flex align-items-center">
                            <img src="https://placehold.co/30x30/00A94F/FFFFFF?text=Grab" class="me-3">
                            <span class="fw-bold">Grab Standard (Rp 20.000)</span>
                        </div>
                        <i class="fas fa-check-circle text-primary d-none icon-check"></i>
                    </div>
                    <div class="metode-item" data-value="Gojek Express" data-cost="15000">
                        <div class="d-flex align-items-center">
                            <img src="https://placehold.co/30x30/00AA13/FFFFFF?text=Gojek" class="me-3">
                            <span class="fw-bold">Gojek Express (Rp 15.000)</span>
                        </div>
                        <i class="fas fa-check-circle text-primary d-none icon-check"></i>
                    </div>
                </div>

                <div class="rincian-harga">
                    <div class="rincian-row">
                        <div>Harga Bersih (<?= count($keranjangItems ?? []) ?> Item)</div>
                        <div id="subtotalBersihDisplay">Rp <?= number_format($subtotalProduk ?? 0) ?></div>
                    </div>
                    <div class="rincian-row">
                        <div>Diskon 10%</div>
                        <div id="diskonDisplay">- Rp <?= number_format($diskon ?? 0) ?></div>
                    </div>
                    
                    <div class="rincian-row">
                        <div>Biaya Pengiriman</div>
                        <div id="ongkirDisplay">+ Rp <?= number_format($ongkir ?? 0) ?></div>
                    </div>

                    <div class="rincian-row">
                        <div>PPN 11%</div>
                        <div id="ppnAmountDisplay">+ Rp <?= number_format(0) ?></div>
                    </div>
                    
                    <hr>
                    
                    <div class="rincian-row total-final">
                        <div>Total Pembayaran</div>
                        <div id="totalFinalDisplay">Rp <?= number_format($totalFinal ?? 0) ?></div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-checkout-final mt-4 mb-5" id="btnCheckoutFinal">
                    Proses Pesanan Sekarang (Rp <?= number_format($totalFinal ?? 0) ?>)
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const baseSubtotal = parseFloat(document.getElementById('baseSubtotal').value) || 0;
        const discountAmount = parseFloat(document.getElementById('discountAmount').value) || 0;
        const subtotalAfterDiscount = baseSubtotal - discountAmount;

        const PPN_RATE = 0.11;

        const bayarItems = document.querySelectorAll('.metode-pembayaran .metode-item');
        const kirimItems = document.querySelectorAll('.metode-pengiriman .metode-item');
        const inputMetodeBayar = document.getElementById('inputMetodeBayar');
        const inputMetodeKirim = document.getElementById('inputMetodeKirim');
        const form = document.getElementById('formFinalCheckout');

        const ongkirDisplay = document.getElementById('ongkirDisplay');
        const ppnAmountDisplay = document.getElementById('ppnAmountDisplay');
        const totalFinalDisplay = document.getElementById('totalFinalDisplay');
        const btnCheckoutFinal = document.getElementById('btnCheckoutFinal');

        const inputPpnAmount = document.getElementById('inputPpnAmount');
        const inputTotalFinal = document.getElementById('inputTotalFinal');
        const inputOngkir = document.getElementById('inputOngkir');


        function formatRupiah(number) {
            return 'Rp ' + Math.round(number).toLocaleString('id-ID');
        }

        function calculateTotal() {
            const selectedItem = document.querySelector('.metode-pengiriman .metode-item.selected');
            let shippingCost = 0;

            if (selectedItem) {
                shippingCost = parseFloat(selectedItem.getAttribute('data-cost')) || 0;
            }

            const totalBeforePPN = subtotalAfterDiscount + shippingCost;
            const ppnAmount = totalBeforePPN * PPN_RATE;
            const totalFinalCalculated = totalBeforePPN + ppnAmount;

            ongkirDisplay.textContent = '+ ' + formatRupiah(shippingCost).replace('Rp ', '');
            ppnAmountDisplay.textContent = '+ ' + formatRupiah(ppnAmount).replace('Rp ', '');
            totalFinalDisplay.textContent = formatRupiah(totalFinalCalculated);
            btnCheckoutFinal.textContent = `Proses Pesanan Sekarang (${formatRupiah(totalFinalCalculated)})`;

            inputPpnAmount.value = ppnAmount;
            inputTotalFinal.value = totalFinalCalculated;
            inputOngkir.value = shippingCost;
        }

        function setupSelection(items, inputField, initialValue, isShipping = false) {
            items.forEach(item => {
                item.addEventListener('click', () => {
                    items.forEach(i => {
                        i.classList.remove('selected');
                        i.querySelector('.icon-check').classList.add('d-none');
                    });

                    item.classList.add('selected');
                    item.querySelector('.icon-check').classList.remove('d-none');

                    inputField.value = item.getAttribute('data-value');

                    if (isShipping) {
                        calculateTotal();
                    }
                });

                if (item.getAttribute('data-value') === initialValue) {
                    item.click();
                }
            });

            if (!inputField.value && items.length > 0) {
                items[0].click();
            }
        }

        setupSelection(bayarItems, inputMetodeBayar, 'QRIS', false);
        setupSelection(kirimItems, inputMetodeKirim, 'Grob Standard', true);

        form.addEventListener('submit', function(e) {
            const paymentContainer = document.querySelector('.metode-pembayaran');
            const shippingContainer = document.querySelector('.metode-pengiriman');
            paymentContainer.style.border = 'none';
            shippingContainer.style.border = 'none';


            if (!inputMetodeBayar.value || !inputMetodeKirim.value) {
                e.preventDefault();

                if (!inputMetodeBayar.value) paymentContainer.style.border = '1px solid red';
                if (!inputMetodeKirim.value) shippingContainer.style.border = '1px solid red';

                alert('Mohon pilih Metode Pembayaran dan Metode Pengiriman terlebih dahulu.');
            }
        });

        calculateTotal();
    });
</script>

<?= $this->endSection() ?>
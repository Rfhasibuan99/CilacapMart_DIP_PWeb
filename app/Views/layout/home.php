<?= $this->extend('layout/template') ?>
<?= $this->section('content');?>
<style>body {
    background-color: #E0F2FE; /* Biru muda */
}

/* ====== NAVBAR ======= */
.main-nav {
    background-color: #0096C7 !important; /* Biru utama */
}

.navbar-brand span {
    color: white !important;
    font-weight: 600;
}

.navbar-brand img {
    border-radius: 10px;
}

/* Icon kanan di navbar */
.main-nav a i {
    color: white !important;
    font-size: 1.4rem;
}

.main-nav a:hover i {
    color: #E0F2FE !important;
}

/* ====== SEARCH ======= */
.input-group .form-control {
    border-color: #0096C7;
}

.input-group .btn {
    background-color: #0096C7;
    color: white;
    border-color: #0096C7;
}

.input-group .btn:hover {
    background-color: #007aa1;
}

/* ====== CARD TOKO ======= */
.card {
    border: none;
    background: white;
    border-left: 5px solid #0096C7;
    transition: 0.2s;
}

.card:hover {
    transform: scale(1.02);
}

/* Judul toko */
h4 {
    color: #0096C7;
    font-weight: 700;
}

/* Isi teks card */
.card-body p {
    color: #003049;
}

/* Tombol detail toko */
.btn-primary {
    background-color: #0096C7;
    border-color: #0096C7;
}

.btn-primary:hover {
    background-color: #007aa1;
}
footer {
    background-color: #003366; /* BIRU TUA */
    padding: 25px 50px;
    color: #ffffff; /* TEKS PUTIH */
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

footer h6 {
    font-weight: 700;
    margin-bottom: 8px;
    color: #ffffff;
}

footer a {
    color: #ffffff;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top main-nav">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="../../../../logo.png" alt="Cilacap Mart Logo" class="me-2" width="100px">
            <span>Cilacap Mart</span>
        </a>

        <form action="<?= site_url('/'); ?>" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Masukkan Pencarian Barang" name="cari" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

        <div class="d-flex align-items-center gap-3">
            <a href="/pesanan"><i class="bi bi-bag"></i></a>
            <a href="/keranjang"><i class="bi bi-cart fs-4"></i></a>
            <a href="/akun"><i class="bi bi-person-circle fs-4"></i></a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1>Selamat Datang Di CilacapMart</h1>

    <div class="row mt-3">

        <!-- CARD TOKO (Template) -->
        <?php
        $tokoList = [
            [
                'nama' => 'Jajan Koe', 
                'link' => '/toko1',
                'img'  => '/img/jajankoe.jpg',
                'deksripsi' => 'Jajan Koe adalah toko yang menjual beraneka 
                ragam roti khas Cilacap dengan cita rasa autentik dan selalu fresh setiap hari. 
                Kami menghadirkan berbagai pilihan roti manis, gurih, hingga jajanan tradisional yang 
                cocok untuk camilan keluarga, acara spesial, atau oleh-oleh.',

                'alamat' => 'Jl. Gatot Subroto No.128, Karang Lor, Gunungsimping,
                Kec. Cilacap Tengah, Kabupaten Cilacap.',
                'nomor' => '08226628282',
                'jam' => '08.00 - 21.00 WIB'
            ],
            [
                'nama' => 'Cemiland',
                'link' => '/toko2',
                'img'  => '/img/cemiland2.jpg',
                'deksripsi' => 'Cemilland_ adalah toko yang menjual berbagai olahan cemilan khas Cilacap dengan rasa autentik dan kualitas terbaik. 
                Tersedia aneka camilan renyah, gurih, manis, dan oleh-oleh khas daerah yang cocok untuk ngemil santai ataupun dijadikan buah tangan.',
                'alamat' => 'Pertokoan Semarak Town House, Kios No. 11 Jl. Dr. Sutomo, Cilacap, Jawa Tengah, Indonesia',
                'nomor' => '0876-55445',
                'jam' => '08.00 - 21.00 WIB'
            ],
            [
                'nama' => 'Grek',
                'link' => '/toko3',
                'img'  => '/img/grek.jpg',
                'deksripsi' => 'Grek adalah toko yang menjual bubuk kopi dan coklat berkualitas dengan rasa khas Cilacap. Kami menyediakan berbagai varian kopi dan coklat pilihan yang cocok untuk penikmat minuman hangat, pelaku usaha minuman, maupun untuk stok harian di rumah.',
                'alamat' => 'Jl. Kendeng, Cilacap, Jawa Tengah',
                'nomor' => '0812-5566-9900',
                'jam' => '09.30 - 22.00 WIB'
            ],
            [
                'nama' => 'Handcraft',
                'link' => '/toko4',
                'img'  => '/img/handcraft.jpg',
                'deksripsi' => 'Handcraft adalah toko yang menjual berbagai kerajinan tangan unik buatan lokal Cilacap. Setiap produk dibuat secara manual dengan kualitas terjaga—mulai dari dekorasi rumah, aksesori, hingga souvenir yang cocok untuk hadiah maupun kebutuhan acara.',
                'alamat' => 'Cipari, Cilacap, Jawa Tengah',
                'nomor' => '0812-5566-9900',
                'jam' => '08.00 - 21.00 WIB'
            ],
            [
                'nama' => 'WS Jaya Cilacap',
                'link' => '/toko5',
                'img'  => '/img/wsjaya.jpg',
                'deksripsi' => 'WS Jaya Cilacap menjual berbagai jenis ikan kering hasil laut yang diproduksi langsung dari nelayan lokal Cilacap. Produk tersedia dalam kondisi bersih, berkualitas, dan tahan lama—cocok untuk kebutuhan rumah tangga, usaha kuliner, maupun oleh-oleh khas daerah pesisir.',
                'alamat' => 'Cilacap, Jawa Tengah',
                'nomor' => '0812-5566-9900',
                'jam' => '08.00 - 20.00 WIB'
            ]
        ];
        ?>

        <?php foreach ($tokoList as $t): ?>
        <div class="col-sm-12 col-md-6 mb-4">
            <h4><?= $t['nama'] ?></h4>

            <div class="card shadow-sm">
                <div class="row g-0">

                    <!-- GAMBAR TOKO -->
                    <div class="col-md-4">
                        <img src="<?= $t['img'] ?>" 
                             class="img-fluid rounded-start" 
                             alt="Foto <?= $t['nama'] ?>">
                    </div>

                    <!-- KETERANGAN -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <p class="card-title"><?= $t['deksripsi'] ?></p>

                            <p><b>Alamat Toko:</b><?= $t['alamat'] ?></p>
                            <p><b>Nomor Telepon:</b><?= $t['nomor'] ?></p>
                            <p><b>Jam Pelayanan:</b><?= $t['jam'] ?></p>

                            <a href="<?= $t['link'] ?>" class="btn btn-primary mt-2">
                                Detail Toko
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php endforeach ?>

    </div>
</div>
    <footer>
        <div>
            <h6>Layanan Pelanggan</h6>
            Bantuan<br>Lacak Pengiriman Penjual<br>Lacak Pesanan Pembeli<br>Hubungi Kami
        </div>
        <div>
            <h6>Jelajahi Cilacap Mart</h6>
            Tentang Kami<br>Seller Centre<br>Kontak Media
        </div>
        <div><h6>Pembayaran</h6></div>
        <div><h6>Pengiriman</h6></div>
    </footer>

<?= $this->endSection(); ?>

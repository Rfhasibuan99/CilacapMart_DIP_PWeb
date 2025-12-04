<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
    body {
        background-color: #E8EFF7; /* biru muda sesuai desain */
    }
</style>
<h2>Tentang Kami</h2>
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
<div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/img/clpmart.jpg" class="d-block w-100" width="500px" height="500px">
        </div>
    </div>
</div>
<br>
<p>Cilacap Mart adalah platform e-commerce yang didedikasikan untuk menyediakan berbagai produk berkualitas kepada pelanggan kami. Kami berkomitmen untuk memberikan pengalaman belanja online yang mudah, aman, dan menyenangkan bagi semua pengguna kami.</p>
<p>Selamat datang di Cilcap Mart, toko online terpercaya yang menyediakan berbagai kebutuhan sehari-hari dengan kualitas terbaik dan harga terjangkau. Kami berkomitmen untuk memberikan pelayanan terbaik kepada pelanggan kami dengan menyediakan produk-produk berkualitas, layanan pengiriman cepat, dan pengalaman belanja yang menyenangkan.</p>
<p>Di Cilcap Mart, Anda dapat menemukan berbagai kategori produk mulai dari kebutuhan rumah tangga, elektronik, fashion, hingga makanan dan minuman. Kami bekerja sama dengan berbagai supplier terpercaya untuk memastikan setiap produk yang kami tawarkan memenuhi standar kualitas tinggi.</p>
<p>Kami juga menyediakan layanan pelanggan yang responsif dan siap membantu Anda dengan segala pertanyaan atau kebutuhan terkait belanja di Cilcap Mart. Kepuasan pelanggan adalah prioritas utama kami, dan kami berusaha untuk terus meningkatkan layanan kami agar dapat memberikan pengalaman belanja yang terbaik.</p>

<p>Terima kasih telah memilih Cilcap Mart sebagai destinasi belanja online Anda. Kami berharap dapat melayani Anda dengan produk-produk terbaik dan layanan yang memuaskan.</p>
<div class="d-grid gap-2">
  <button class="btn btn-primary" type="button" onclick="window.location.href='<?= base_url('/'); ?>'">Jelajahi CilcapMart</button>
</div>
<?= $this->endSection(); ?>
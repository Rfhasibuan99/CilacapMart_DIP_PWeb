<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\PesananModel;
use App\Models\DetailPesananModel;

class Checkout extends BaseController
{
    protected $keranjangModel;
    protected $pesananModel;
    protected $detailPesananModel;
    protected $user_id;

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
        $this->pesananModel = new PesananModel();
        $this->detailPesananModel = new DetailPesananModel();
        $this->user_id = 1; // Ganti dengan ID pengguna yang sedang login
    }

    // Menampilkan halaman checkout (Alur 1 & Alur 2)
    public function index()
    {
        $keranjangItems = [];
        $total = 0;
        $isBeliLangsung = session()->get('beli_langsung_item');

        if ($isBeliLangsung) {
            // Alur 2: Pembelian Langsung (Menggunakan data dari session sementara)
            $keranjangItems[] = $isBeliLangsung;
            $total = $isBeliLangsung['harga_satuan'] * $isBeliLangsung['jumlah'];
            session()->remove('beli_langsung_item'); // Hapus setelah diambil
        } else {
            // Alur 1: Dari Keranjang (Menggunakan data dari database)
            $keranjangItems = $this->keranjangModel->getItemsKeranjang($this->user_id);
            $total = $this->keranjangModel->getTotalKeranjang($this->user_id)['total_harga'] ?? 0;
        }

        if (empty($keranjangItems)) {
            return redirect()->to('/')->with('error', 'Keranjang belanja kosong.');
        }

        $data = [
            'title' => 'Konfirmasi Checkout',
            'keranjang' => $keranjangItems,
            'total' => $total, // Ini total barang mentah. Perlu logic diskon/ongkir
            // Data dummy alamat, harusnya dari model User
            'alamat_user' => [
                'penerima' => 'Annisa Afdfa',
                'telp' => '+6282230244457',
                'alamat_lengkap' => 'Jl. Kembengan Gg 02 No 1/2, Kesugihan, Cilacap, Jawa Tengah'
            ]
        ];
        
        // Asumsi view ada di app/Views/checkout/index.php
        return view('checkout/index', $data); 
    }
    
    // Fungsi yang dipanggil dari form 'Beli Langsung' di halaman detail barang
    public function beliLangsung()
    {
        // Alur 2: Menerima 1 item langsung dari halaman detail barang
        $id_barang = $this->request->getPost('id_barang');
        $jumlah = $this->request->getPost('jumlah');
        
        // *** HARUS: Ambil detail barang (nama, harga, gambar) dari BarangModel ***
        // $barang = $this->barangModel->find($id_barang); 
        
        $itemBeliLangsung = [
            'id_barang' => $id_barang,
            'nama_barang' => 'Nama Barang Contoh', // Ganti dengan $barang['nama']
            'gambar' => 'default.png', 
            'harga_satuan' => 50000, // Ganti dengan $barang['harga']
            'jumlah' => $jumlah
        ];
        
        // Simpan data di session untuk diproses di index()
        session()->set('beli_langsung_item', $itemBeliLangsung);
        
        return redirect()->to('/checkout');
    }

    public function proses()
    {
        // Ambil item dari keranjang (Alur 1)
        $keranjangItems = $this->keranjangModel->getItemsKeranjang($this->user_id);
        $totalKeranjang = $this->keranjangModel->getTotalKeranjang($this->user_id)['total_harga'] ?? 0;
        
        // Asumsi data alamat dan total sudah dikirim dari form checkout
        $alamat = $this->request->getPost('alamat_pengiriman');
        $total_final = $this->request->getPost('total_final'); // Total setelah diskon/ongkir

        // 1. Buat data Pesanan (Header)
        $dataPesanan = [
            'id_user' => $this->user_id,
            'kode_pesanan' => 'ORD-' . time(),
            'alamat_pengiriman' => $alamat,
            'tanggal_pesan' => date('Y-m-d H:i:s'),
            'total_harga' => $total_final,
            'status' => 'Menunggu Pembayaran'
        ];

        $id_pesanan = $this->pesananModel->insert($dataPesanan);

        if ($id_pesanan) {
            // 2. Buat Detail Pesanan (Items)
            foreach ($keranjangItems as $item) {
                $dataDetail = [
                    'id_pesanan' => $id_pesanan,
                    'id_barang' => $item['id_barang'],
                    'nama_barang' => $item['nama_barang'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_barang'],
                    'subtotal' => $item['harga_barang'] * $item['jumlah']
                ];
                $this->detailPesananModel->insert($dataDetail);
            }

            // 3. Hapus Keranjang (Khusus Alur 1)
            $this->keranjangModel->hapusKeranjangByUser($this->user_id);

            // Redirect ke halaman Pembayaran
            return redirect()->to('/pembayaran/' . $id_pesanan);
        }

        return redirect()->back()->with('error', 'Gagal membuat pesanan.');
    }
}
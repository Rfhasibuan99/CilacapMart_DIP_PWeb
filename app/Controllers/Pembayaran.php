<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\PembayaranModel;

class Pembayaran extends BaseController
{
    protected $pesananModel;
    protected $pembayaranModel;
    protected $user_id;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->user_id = 1; // Ganti dengan ID pengguna yang sedang login
    }

    // Menampilkan halaman menu pembayaran untuk pesanan tertentu
    public function index($id_pesanan)
    {
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($pesanan['status'] == 'Dibayar') {
             return redirect()->to('/')->with('info', 'Pesanan ini sudah dibayar.');
        }

        $data = [
            'title' => 'Menu Pembayaran',
            'pesanan' => $pesanan,
            'total_tagihan' => $pesanan['total_harga'],
            // Opsi metode pembayaran
            'metode_pembayaran' => [
                ['kode' => 'qris', 'nama' => 'QRIS (Semua Bank/E-Wallet)', 'ikon' => 'qr-code.png'],
                ['kode' => 'transfer_bca', 'nama' => 'Transfer Bank BCA', 'ikon' => 'bca.png'],
            ]
        ];

        // Asumsi view ada di app/Views/pembayaran/index.php
        return view('pembayaran/index', $data);
    }
    
    // Proses pemilihan metode dan simulasi pembayaran
    public function prosesBayar($id_pesanan)
    {
        $metode = $this->request->getPost('metode_pembayaran');
        $pesanan = $this->pesananModel->find($id_pesanan);

        if (!$pesanan || $pesanan['id_user'] != $this->user_id) {
             return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // 1. Simpan data pembayaran ke tabel 'pembayaran'
        $dataPembayaran = [
            'id_pesanan' => $id_pesanan,
            'metode' => $metode,
            'jumlah' => $pesanan['total_harga'],
            'status' => 'Pending'
        ];
        $this->pembayaranModel->insert($dataPembayaran);

        // 2. Update status Pesanan (Simulasi Pembayaran Berhasil)
        $this->pesananModel->update($id_pesanan, ['status' => 'Dibayar']);
        
        // 3. Redirect ke halaman status pesanan atau terima kasih
        return redirect()->to('/pesanan/status/' . $id_pesanan)->with('success', 'Pembayaran Berhasil! Pesanan sedang diproses.');
    }
}
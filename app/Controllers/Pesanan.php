<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\KeranjangModel;

class Pesanan extends BaseController
{
    protected $pesananModel;
    protected $detailPesananModel;
    protected $keranjangModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->detailPesananModel = new DetailPesananModel();
        $this->keranjangModel = new KeranjangModel();
    }

    // ======================
    // INDEX - DAFTAR PESANAN
    // ======================
    public function index()
    {
        $idUser = session()->get('id');
        $role = session()->get('role') ?? 'user';

        if ($role === 'admin') {
            // Admin melihat semua pesanan
            $pesanan = $this->pesananModel->findAll();
        } else {
            // User melihat pesanan sendiri
            $pesanan = $this->pesananModel->getPesananByUser($idUser);
        }

        $data = [
            'title' => 'Daftar Pesanan',
            'pesanan' => $pesanan,
            'role' => $role
        ];

        return view('pesanan/index', $data);
    }

    // ======================
    // DETAIL PESANAN
    // ======================
    public function detail($idPesanan)
    {
        $idUser = session()->get('id');
        $role = session()->get('role') ?? 'user';

        $pesanan = $this->pesananModel->getPesananWithDetails($idPesanan);
        $detail = $this->detailPesananModel->getDetailByPesanan($idPesanan);

        // Cek akses (user hanya bisa lihat pesanan sendiri, admin semua)
        if ($role !== 'admin' && $pesanan['id_user'] != $idUser) {
            return redirect()->to('/pesanan')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Detail Pesanan',
            'pesanan' => $pesanan,
            'detail' => $detail,
            'role' => $role
        ];

        return view('pesanan/detail', $data);
    }

    // ======================
    // CHECKOUT DARI KERANJANG
    // ======================
    public function checkout()
    {
        $idUser = session()->get('id');

        // Ambil data keranjang
        $keranjang = $this->keranjangModel
            ->select('keranjang.*, barang.nama_barang, barang.harga_barang')
            ->join('barang', 'barang.id_barang = keranjang.id_barang')
            ->where('keranjang.id_user', $idUser)
            ->findAll();

        if (empty($keranjang)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang kosong');
        }

        // Hitung total
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga_barang'] * $item['jumlah'];
        }

        $data = [
            'title' => 'Checkout',
            'keranjang' => $keranjang,
            'total' => $total
        ];

        return view('pesanan/checkout', $data);
    }

    // ======================
    // PROSES CHECKOUT
    // ======================
    public function prosesCheckout()
    {
        $idUser = session()->get('id');
        $alamat = $this->request->getPost('alamat_pengiriman');

        // Validasi
        if (!$this->validate([
            'alamat_pengiriman' => 'required|min_length[10]'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Ambil data keranjang
        $keranjang = $this->keranjangModel
            ->select('keranjang.*, barang.nama_barang, barang.harga_barang')
            ->join('barang', 'barang.id_barang = keranjang.id_barang')
            ->where('keranjang.id_user', $idUser)
            ->findAll();

        if (empty($keranjang)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang kosong');
        }

        // Hitung total
        $total = 0;
        $detailData = [];
        foreach ($keranjang as $item) {
            $subtotal = $item['harga_barang'] * $item['jumlah'];
            $total += $subtotal;

            $detailData[] = [
                'id_barang' => $item['id_barang'],
                'nama_barang' => $item['nama_barang'],
                'harga_barang' => $item['harga_barang'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $subtotal
            ];
        }

        // Insert pesanan
        $idPesanan = $this->pesananModel->insert([
            'id_user' => $idUser,
            'tanggal_pesanan' => date('Y-m-d H:i:s'),
            'total_harga' => $total,
            'status' => 'pending',
            'alamat_pengiriman' => $alamat
        ]);

        // Insert detail pesanan
        foreach ($detailData as &$detail) {
            $detail['id_pesanan'] = $idPesanan;
        }
        $this->detailPesananModel->insertBatch($detailData);

        // Hapus keranjang
        $this->keranjangModel->where('id_user', $idUser)->delete();

        return redirect()->to('/pesanan')->with('pesan', 'Pesanan berhasil dibuat');
    }

    // ======================
    // UPDATE STATUS PESANAN (ADMIN)
    // ======================
    public function updateStatus($idPesanan)
    {
        $role = session()->get('role') ?? 'user';

        if ($role !== 'admin') {
            return redirect()->to('/pesanan')->with('error', 'Akses ditolak');
        }

        $status = $this->request->getPost('status');

        if ($this->pesananModel->updateStatus($idPesanan, $status)) {
            return redirect()->to('/pesanan/detail/' . $idPesanan)->with('pesan', 'Status pesanan berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal update status');
    }
}

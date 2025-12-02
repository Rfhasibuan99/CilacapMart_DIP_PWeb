<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\KeranjangModel;
use App\Models\BarangModel;

class Pesanan extends BaseController
{
    protected $pesananModel;
    protected $detailPesananModel;
    protected $keranjangModel;
    protected $barangModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->detailPesananModel = new DetailPesananModel();
        $this->keranjangModel = new KeranjangModel();
        $this->barangModel = new BarangModel();
    }
    public function index()
    {
        $idUser = session()->get('id');
        $role = session()->get('role') ?? 'user';

        if ($role === 'admin') {
            $pesanan = $this->pesananModel->findAll();
        } else {

            $pesanan = $this->pesananModel->getPesananByUser($idUser);
        }

        $data = [
            'title' => 'Daftar Pesanan',
            'pesanan' => $pesanan,
            'role' => $role
        ];

        return view('pesanan/index', $data);
    }


    public function detail($idPesanan)
{
    $idUser = session()->get('id');
    $role = session()->get('role') ?? 'user';

    $pesanan = $this->pesananModel->getPesananWithDetails($idPesanan);
    $detail  = $this->detailPesananModel->getDetailByPesanan($idPesanan);

    if (!$pesanan) {
        return redirect()->to('/pesanan')->with('error', 'Pesanan tidak ditemukan');
    }

    if ($role !== 'admin' && $pesanan['id_user'] != $idUser) {
        return redirect()->to('/pesanan')->with('error', 'Akses ditolak');
    }

    $data = [
        'title'   => 'Detail Pesanan',
        'pesanan' => $pesanan,
        'detail'  => $detail
    ];

    return view('pesanan/detail', $data);
}


    public function checkout()
{
    $idUser = session()->get('id');
    if (!$idUser) {
        return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
    }

    $cart = $this->keranjangModel->getKeranjangByUser($idUser);

    if (!$cart) {
        return redirect()->to('/keranjang')->with('error', 'Keranjang kosong');
    }

    // Hitung total harga
    $totalBelanja = 0;
    foreach ($cart as $c) {
        $totalBelanja += $c['harga'] * $c['jumlah'];
    }

    // Generate kode pesanan
    $kodePesanan = 'ORD-' . time();

    // Insert data pesanan
    $dataPesanan = [
        'id_user' => $idUser,
        'kode_pesanan' => $kodePesanan,
        'total_harga' => $totalBelanja,
        'status' => 'pending'
    ];
    $this->pesananModel->insert($dataPesanan);

    $idPesanan = $this->pesananModel->insertID();

    // Insert detail pesanan
    foreach ($cart as $c) {
        $this->detailPesananModel->insert([
            'id_pesanan' => $idPesanan,
            'id_barang'  => $c['id_barang'],
            'jumlah'     => $c['jumlah'],
            'harga'      => $c['harga'],
            'subtotal'   => $c['jumlah'] * $c['harga']
        ]);
    }

    // Kosongkan keranjang user
    $this->keranjangModel->where('id_user', $idUser)->delete();

    return redirect()->to('/pesanan/' . $idPesanan)
            ->with('success', 'Pesanan berhasil dibuat');
}


    public function prosesCheckout()
    {
        $idUser = session()->get('id');
        $alamat = $this->request->getPost('alamat_pengiriman');


        if (!$this->validate([
            'alamat_pengiriman' => 'required|min_length[10]'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }


        $keranjang = $this->keranjangModel
            ->select('keranjang.*, barang.nama_barang, barang.harga_barang')
            ->join('barang', 'barang.id_barang = keranjang.id_barang')
            ->where('keranjang.id_user', $idUser)
            ->findAll();

        if (empty($keranjang)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang kosong');
        }


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


        $idPesanan = $this->pesananModel->insert([
            'id_user' => $idUser,
            'tanggal_pesanan' => date('Y-m-d H:i:s'),
            'total_harga' => $total,
            'status' => 'pending',
            'alamat_pengiriman' => $alamat
        ]);

        foreach ($detailData as &$detail) {
            $detail['id_pesanan'] = $idPesanan;
        }
        $this->detailPesananModel->insertBatch($detailData);


        $this->keranjangModel->where('id_user', $idUser)->delete();

        return redirect()->to('/pesanan')->with('pesan', 'Pesanan berhasil dibuat');
    }
    public function pesanLangsung($idBarang)
    {
        $idUser = session()->get('id');
        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $barang = $this->barangModel->find($idBarang);
        if (!$barang) {
            return redirect()->to('/barang')->with('error', 'Barang tidak ditemukan');
        }

        $data = [
            'title' => 'Pesan Langsung',
            'barang' => $barang
        ];

        return view('pesanan/pesan_langsung', $data);
    }

    public function prosesPesanLangsung()
    {
        $idUser = session()->get('id');
        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $idBarang = $this->request->getPost('id_barang');
        $jumlah = $this->request->getPost('jumlah');
        $alamat = $this->request->getPost('alamat_pengiriman');


        if (!$this->validate([
            'id_barang' => 'required|numeric',
            'jumlah' => 'required|numeric|greater_than[0]',
            'alamat_pengiriman' => 'required|min_length[10]'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $barang = $this->barangModel->find($idBarang);
        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan');
        }


        if ($jumlah > $barang['stok']) {
            return redirect()->back()->withInput()->with('error', 'Stok tidak mencukupi');
        }

        $harga = $barang['harga_jual'];
        $total = $harga * $jumlah;

        $idPesanan = $this->pesananModel->insert([
            'id_user' => $idUser,
            'tanggal_pesanan' => date('Y-m-d H:i:s'),
            'total_harga' => $total,
            'status' => 'pending',
            'alamat_pengiriman' => $alamat
        ]);

        $this->detailPesananModel->insert([
            'id_pesanan' => $idPesanan,
            'id_barang' => $idBarang,
            'nama_barang' => $barang['nama_barang'],
            'harga_barang' => $harga,
            'jumlah' => $jumlah,
            'subtotal' => $total
        ]);


        $this->barangModel->update($idBarang, [
            'stok' => $barang['stok'] - $jumlah
        ]);

        return redirect()->to('/pesanan')->with('pesan', 'Pesanan berhasil dibuat');
    }

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

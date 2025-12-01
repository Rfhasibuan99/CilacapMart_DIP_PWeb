<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\ShopModel;

class Keranjang extends BaseController
{
    protected $keranjangModel;
    protected $ShopModel;

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
        $this->ShopModel = new ShopModel();
    }

    public function index()
{
    $idUser = session()->get('id');
    if (!$idUser) {
        return redirect()->to('/login');
    }

    $keranjang = $this->keranjangModel
        ->where('id_user', $idUser)
        ->findAll();

    // Ambil detail barang
    $shopModel = new \App\Models\ShopModel();

    foreach ($keranjang as &$item) {
        $barang = $shopModel->find($item['id_toko']);

        if ($barang) {
            $item['nama_barang'] = $barang['nama_barang'];
            $item['harga_barang'] = $barang['harga_barang'];
            $item['gambar']       = $barang['gambar'];
        }
    }

    return view('keranjang/index', ['keranjang' => $keranjang]);
}


   public function tambah()
{
    $idUser = session()->get('id');
    if (!$idUser) {
        return redirect()->to('/login');
    }

    $idToko = $this->request->getPost('id_toko');
    $jumlah = $this->request->getPost('jumlah');

    if (!$idToko || !$jumlah) {
        return redirect()->back()->with('error', 'Data tidak valid');
    }

    // cek barang
    $barang = $this->ShopModel->find($idToko);

    if (!$barang) {
        return redirect()->back()->with('error', 'Barang tidak ditemukan');
    }

    // cek jika barang sudah ada
    $cek = $this->keranjangModel
        ->where('id_toko', $idToko)
        ->where('id_user', $idUser)
        ->first();

    if ($cek) {
        $this->keranjangModel->update($cek['id_keranjang'], [
            'jumlah' => $cek['jumlah'] + $jumlah
        ]);
    } else {
        $this->keranjangModel->insert([
            'id_user' => $idUser,
            'id_toko' => $idToko,
            'jumlah' => $jumlah
        ]);
    }

    return redirect()->to('/keranjang')->with('pesan', 'Barang ditambahkan');
}



    public function hapus($id_keranjang)
    {
        $idUser = session()->get('id_user');
        if (!$idUser) {
            return redirect()->to('/login');
        }

        $item = $this->keranjangModel
            ->where('id_keranjang', $id_keranjang)
            ->where('id_user', $idUser)
            ->first();

        if ($item) {
            $this->keranjangModel->delete($id_keranjang);
            return redirect()->to('/keranjang')->with('pesan', 'Item keranjang berhasil dihapus');
        }

        return redirect()->to('/keranjang')->with('error', 'Item tidak ditemukan atau bukan milik Anda');
    }
}

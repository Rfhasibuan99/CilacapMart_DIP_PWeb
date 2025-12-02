<?php

namespace App\Controllers;

use App\Models\KeranjangModel;
use App\Models\BarangModel;

class Keranjang extends BaseController
{
    protected $keranjangModel;
    protected $barangModel;

    public function __construct()
    {
        $this->keranjangModel = new KeranjangModel();
        $this->barangModel = new BarangModel();
    }

    private function getUserId()
    {
        if (function_exists('user')) return user()->id;
        return session()->get('id');
    }

    public function index()
    {
        $idUser = $this->getUserId();
        $items = $this->keranjangModel->where('id_user', $idUser)->findAll();

        foreach ($items as &$item) {
            $barang = $this->barangModel->find($item['id_barang']);
            $item['nama_barang']  = $barang['nama_barang'];
            $item['harga_barang'] = $barang['harga_jual'];
            $item['gambar']       = $barang['gambar'];
            $item['subtotal']     = $barang['harga_jual'] * $item['jumlah'];
        }

        return view('keranjang/index', ['keranjang' => $items]);
    }

    public function tambah()
    {
        $idUser = $this->getUserId();
        $idBarang = $this->request->getPost('id_barang');

        $cek = $this->keranjangModel
            ->where('id_user', $idUser)
            ->where('id_barang', $idBarang)
            ->first();

        if ($cek)
            $this->keranjangModel->update($cek['id_keranjang'], ['jumlah' => $cek['jumlah'] + 1]);
        else
            $this->keranjangModel->save(['id_user' => $idUser, 'id_barang' => $idBarang, 'jumlah' => 1]);

        return redirect()->to('/keranjang');
    }

    public function hapus($id)
    {
        $this->keranjangModel->delete($id);
        return redirect()->to('/keranjang');
    }
    public function beliSekarang()
{
    $idUser = $this->getUserId();
    if (!$idUser) return redirect()->to('/login');

    $idBarang = $this->request->getPost('id_barang');

    // Hapus keranjang dulu agar checkout 1 item saja
    $this->keranjangModel->where('id_user', $idUser)->delete();

    $this->keranjangModel->save([
        'id_user' => $idUser,
        'id_barang' => $idBarang,
        'jumlah' => 1
    ]);

    return redirect()->to('/checkout');
}

}
